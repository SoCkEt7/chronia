<?php

namespace App\Service\CrontabManager;

use Symfony\Component\Filesystem\Filesystem;

class DevCrontabManager implements CrontabManagerInterface
{
    private string $dataPath;
    private string $logPath;
    private string $crontabFile;
    private Filesystem $filesystem;
    
    public function __construct(string $dataPath, string $logPath, Filesystem $filesystem)
    {
        $this->dataPath = $dataPath;
        $this->logPath = $logPath;
        $this->crontabFile = $dataPath . '/crontab.txt';
        $this->filesystem = $filesystem;
        
        $this->ensureMockData();
    }
    
    /**
     * Ensure mock data exists for development
     */
    private function ensureMockData(): void
    {
        // Create directories if they don't exist
        if (!$this->filesystem->exists($this->dataPath)) {
            $this->filesystem->mkdir($this->dataPath, 0755);
        }
        
        if (!$this->filesystem->exists($this->logPath)) {
            $this->filesystem->mkdir($this->logPath, 0755);
        }
        
        // Create sample crontab file if it doesn't exist
        if (!$this->filesystem->exists($this->crontabFile)) {
            $this->filesystem->dumpFile(
                $this->crontabFile,
                "# Sample crontab for development\n" .
                "0 * * * * /usr/bin/php -f /path/to/script.php\n" .
                "0 0 * * * /usr/bin/backup.sh\n" .
                "*/5 * * * * /usr/bin/monitor.sh"
            );
        }
        
        // Create sample log files if necessary
        $logFiles = glob($this->logPath . '/*.log');
        if (empty($logFiles)) {
            $now = date('Y-m-d H:i:s');
            $successLog = "JOB_START: {$now}\nCOMMAND: /usr/bin/backup.sh\n----------\nBackup completed successfully.\n----------\nJOB_END: {$now}\nEXIT_CODE: 0";
            $failureLog = "JOB_START: {$now}\nCOMMAND: /usr/bin/failed-script.sh\n----------\nError: File not found\n----------\nJOB_END: {$now}\nEXIT_CODE: 1";
            
            $this->filesystem->dumpFile($this->logPath . '/job_sample_success.log', $successLog);
            $this->filesystem->dumpFile($this->logPath . '/job_sample_failure.log', $failureLog);
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEntries(): array
    {
        $output = file($this->crontabFile, FILE_IGNORE_NEW_LINES);
        
        // Parse the output into a structured format
        $entries = [];
        $id = 1;
        
        foreach ($output as $line) {
            // Skip empty lines
            if (empty(trim($line))) {
                continue;
            }
            
            // Check if the line is a comment (inactive job)
            $active = true;
            if (strpos(trim($line), '#') === 0) {
                // Skip fully commented lines that don't look like disabled jobs
                if (strpos($line, '# ') === 0 && !preg_match('/^# [0-9*]+/', $line)) {
                    continue;
                }
                
                // This might be a disabled job, try to extract the actual cron line
                $active = false;
                $line = ltrim($line, '#');
            }
            
            // Parse the crontab entry
            $entry = $this->parseCrontabLine($line, $id);
            if ($entry) {
                $entry['active'] = $active;
                $entries[] = $entry;
                $id++;
            }
        }
        
        return $entries;
    }
    
    /**
     * Parse a crontab line into a structured format
     */
    protected function parseCrontabLine(string $line, int $id): ?array
    {
        // Basic crontab line parsing
        $pattern = '/^(@(yearly|annually|monthly|weekly|daily|hourly|reboot))|(@every_(\d+(s|m|h|d|w|m|y)))|((\\*|[0-9,\\-\\/]+)\\s+(\\*|[0-9,\\-\\/]+)\\s+(\\*|[0-9,\\-\\/]+)\\s+(\\*|[0-9,\\-\\/]+)\\s+(\\*|[0-9,\\-\\/]+))\\s+(.*)$/i';
        
        if (preg_match($pattern, $line, $matches)) {
            $command = trim($matches[count($matches) - 1]);
            
            // Extract schedule parts based on which format was matched
            if (!empty($matches[1])) {
                // @yearly, @monthly, etc.
                $schedule = $matches[1];
                $schedule_parts = ['@special', $matches[2], '', '', '', ''];
            } elseif (!empty($matches[3])) {
                // @every_1h format
                $schedule = $matches[3];
                $schedule_parts = ['@every', $matches[4], $matches[5], '', '', ''];
            } else {
                // Standard crontab format
                $schedule = trim(substr($line, 0, strpos($line, $command)));
                $schedule_parts = [
                    trim($matches[6]), // minute
                    trim($matches[7]), // hour
                    trim($matches[8]), // day of month
                    trim($matches[9]), // month
                    trim($matches[10]) // day of week
                ];
            }
            
            return [
                'id' => $id,
                'schedule' => $schedule,
                'schedule_parts' => $schedule_parts,
                'command' => $command,
                'active' => true,
                'last_run' => $this->getLastRunInfo($command)
            ];
        }
        
        return null;
    }
    
    /**
     * Get information about the last run of a command
     */
    protected function getLastRunInfo(string $command): array
    {
        // In development mode, randomly assign a status and time
        $logs = glob($this->logPath . '/*.log');
        
        if (empty($logs)) {
            return [
                'time' => null,
                'status' => null,
                'output' => null
            ];
        }
        
        // Pick a random log for simulation
        $log = $logs[array_rand($logs)];
        $content = file_get_contents($log);
        
        // Parse the log
        $time = null;
        if (preg_match('/JOB_START: (.+)/', $content, $matches)) {
            $time = $matches[1];
        }
        
        $status = null;
        if (preg_match('/EXIT_CODE: (\d+)/', $content, $matches)) {
            $status = (int)$matches[1] === 0;
        }
        
        return [
            'time' => $time,
            'status' => $status,
            'output' => $content
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function addEntry(string $schedule, string $command): bool
    {
        $current = file_get_contents($this->crontabFile);
        $current .= "\n" . $schedule . ' ' . $command;
        
        // Save the updated crontab
        return file_put_contents($this->crontabFile, $current) !== false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function updateEntry(int $id, string $schedule, string $command): bool
    {
        $entries = $this->getEntries();
        $lines = file($this->crontabFile, FILE_IGNORE_NEW_LINES);
        
        // Find the entry to update
        $entryToUpdate = null;
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                $entryToUpdate = $entry;
                break;
            }
        }
        
        if ($entryToUpdate === null) {
            return false;
        }
        
        // Create a new crontab file
        $newContent = [];
        $found = false;
        
        foreach ($lines as $line) {
            if (!$found && $this->lineMatches($line, $entryToUpdate)) {
                // This is the line to update
                $newLine = $schedule . ' ' . $command;
                if (!$entryToUpdate['active']) {
                    $newLine = '# ' . $newLine;
                }
                $newContent[] = $newLine;
                $found = true;
            } else {
                $newContent[] = $line;
            }
        }
        
        // Save the updated crontab
        return file_put_contents($this->crontabFile, implode("\n", $newContent)) !== false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteEntry(int $id): bool
    {
        $entries = $this->getEntries();
        $lines = file($this->crontabFile, FILE_IGNORE_NEW_LINES);
        
        // Find the entry to delete
        $entryToDelete = null;
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                $entryToDelete = $entry;
                break;
            }
        }
        
        if ($entryToDelete === null) {
            return false;
        }
        
        // Create a new crontab file without the deleted entry
        $newContent = [];
        $found = false;
        
        foreach ($lines as $line) {
            if (!$found && $this->lineMatches($line, $entryToDelete)) {
                // Skip this line
                $found = true;
            } else {
                $newContent[] = $line;
            }
        }
        
        // Save the updated crontab
        return file_put_contents($this->crontabFile, implode("\n", $newContent)) !== false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function toggleEntryActive(int $id, bool $active): bool
    {
        $entries = $this->getEntries();
        $lines = file($this->crontabFile, FILE_IGNORE_NEW_LINES);
        
        // Find the entry to toggle
        $entryToToggle = null;
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                $entryToToggle = $entry;
                break;
            }
        }
        
        if ($entryToToggle === null) {
            return false;
        }
        
        // Create a new crontab file with the toggled entry
        $newContent = [];
        $found = false;
        
        foreach ($lines as $line) {
            if (!$found && $this->lineMatches($line, $entryToToggle)) {
                // This is the line to toggle
                $newLine = $entryToToggle['schedule'] . ' ' . $entryToToggle['command'];
                
                if (!$active) {
                    // Disable the entry
                    $newLine = '# ' . $newLine;
                } else {
                    // Enable the entry
                    $newLine = ltrim($line, '# ');
                }
                
                $newContent[] = $newLine;
                $found = true;
            } else {
                $newContent[] = $line;
            }
        }
        
        // Save the updated crontab
        return file_put_contents($this->crontabFile, implode("\n", $newContent)) !== false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function testRun(int $id)
    {
        $entries = $this->getEntries();
        
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                // Simulate running the command
                $exitCode = rand(0, 10) > 2 ? 0 : 1; // 70% chance of success
                
                $output = [
                    "====== DEVELOPMENT MODE ======",
                    "Would execute: " . $entry['command'],
                    "==============================",
                    "",
                    $exitCode === 0 
                        ? "Simulated successful execution" 
                        : "Simulated failure for testing purposes"
                ];
                
                return [
                    'exit_code' => $exitCode,
                    'output' => implode("\n", $output)
                ];
            }
        }
        
        return false;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getNextRunTimes(string $schedule, int $count = 5): array
    {
        // Use Cron\CronExpression if available in production version
        // Here we just simulate it for development
        $times = [];
        $now = time();
        
        for ($i = 1; $i <= $count; $i++) {
            $times[] = date('Y-m-d H:i:s', $now + ($i * 3600)); // Placeholder: every hour
        }
        
        return $times;
    }
    
    /**
     * Helper method to check if a line matches an entry
     */
    private function lineMatches(string $line, array $entry): bool
    {
        $line = trim($line);
        
        // Handle commented lines (inactive entries)
        if (!$entry['active'] && strpos($line, '# ') === 0) {
            $line = ltrim($line, '# ');
        }
        
        return strpos($line, $entry['schedule'] . ' ' . $entry['command']) !== false;
    }
}