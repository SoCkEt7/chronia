<?php
/**
 * DevCrontabManager.php - Development version of CrontabManager that works without root permissions
 */

namespace Chrona;

class DevCrontabManager extends CrontabManager {
    private $mockDataDir;
    private $mockCrontabFile;
    private $mockLogsDir;
    
    /**
     * Constructor
     */
    public function __construct($config = null) {
        parent::__construct($config);
        
        // Set up mock data paths
        $this->mockDataDir = dirname(__DIR__) . '/data';
        $this->mockCrontabFile = $this->mockDataDir . '/crontab.txt';
        $this->mockLogsDir = $this->mockDataDir . '/logs';
        
        // Ensure mock data exists
        $this->ensureMockData();
    }
    
    /**
     * Ensure mock data exists
     */
    private function ensureMockData() {
        // Create directories if they don't exist
        if (!is_dir($this->mockDataDir)) {
            mkdir($this->mockDataDir, 0755, true);
        }
        
        if (!is_dir($this->mockLogsDir)) {
            mkdir($this->mockLogsDir, 0755, true);
        }
        
        // Create sample crontab file if it doesn't exist
        if (!file_exists($this->mockCrontabFile)) {
            file_put_contents($this->mockCrontabFile, "# Sample crontab for development\n0 * * * * /usr/bin/php -f /path/to/script.php\n0 0 * * * /usr/bin/backup.sh\n*/5 * * * * /usr/bin/monitor.sh");
        }
        
        // Create sample log files if they don't exist
        if (count(glob($this->mockLogsDir . '/*.log')) === 0) {
            $now = date('Y-m-d H:i:s');
            $successLog = "JOB_START: {$now}\nCOMMAND: /usr/bin/backup.sh\n----------\nBackup completed successfully.\n----------\nJOB_END: {$now}\nEXIT_CODE: 0";
            $failureLog = "JOB_START: {$now}\nCOMMAND: /usr/bin/failed-script.sh\n----------\nError: File not found\n----------\nJOB_END: {$now}\nEXIT_CODE: 1";
            
            file_put_contents($this->mockLogsDir . '/job_sample_success.log', $successLog);
            file_put_contents($this->mockLogsDir . '/job_sample_failure.log', $failureLog);
        }
    }
    
    /**
     * Get all crontab entries - overridden to use mock data
     */
    public function getEntries() {
        $output = file($this->mockCrontabFile, FILE_IGNORE_NEW_LINES);
        
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
                // This is a fully commented line, skip it if it doesn't look like a disabled job
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
     * Add a new crontab entry - overridden to use mock data
     */
    public function addEntry($schedule, $command) {
        $current = file_get_contents($this->mockCrontabFile);
        $current .= "\n" . $schedule . ' ' . $command;
        
        // Save the updated crontab
        return file_put_contents($this->mockCrontabFile, $current) !== false;
    }
    
    /**
     * Update an existing crontab entry - overridden to use mock data
     */
    public function updateEntry($id, $schedule, $command) {
        $entries = $this->getEntries();
        $lines = file($this->mockCrontabFile, FILE_IGNORE_NEW_LINES);
        
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
        $lineIndex = 0;
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
            $lineIndex++;
        }
        
        // Save the updated crontab
        return file_put_contents($this->mockCrontabFile, implode("\n", $newContent)) !== false;
    }
    
    /**
     * Delete a crontab entry - overridden to use mock data
     */
    public function deleteEntry($id) {
        $entries = $this->getEntries();
        $lines = file($this->mockCrontabFile, FILE_IGNORE_NEW_LINES);
        
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
        return file_put_contents($this->mockCrontabFile, implode("\n", $newContent)) !== false;
    }
    
    /**
     * Toggle the active state of a crontab entry - overridden to use mock data
     */
    public function toggleEntryActive($id, $active) {
        $entries = $this->getEntries();
        $lines = file($this->mockCrontabFile, FILE_IGNORE_NEW_LINES);
        
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
        return file_put_contents($this->mockCrontabFile, implode("\n", $newContent)) !== false;
    }
    
    /**
     * Test run a crontab entry - overridden to simulate execution
     */
    public function testRun($id) {
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
     * Get information about the last run of a command - overridden to use mock data
     */
    protected function getLastRunInfo($command) {
        // In development mode, randomly assign a status and time
        $logs = glob($this->mockLogsDir . '/*.log');
        
        if (empty($logs)) {
            return [
                'time' => null,
                'status' => null,
                'output' => null
            ];
        }
        
        // Pick a random log
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
     * Helper method to check if a line matches an entry
     */
    private function lineMatches($line, $entry) {
        $line = trim($line);
        
        // Handle commented lines (inactive entries)
        if (!$entry['active'] && strpos($line, '# ') === 0) {
            $line = ltrim($line, '# ');
        }
        
        return strpos($line, $entry['schedule'] . ' ' . $entry['command']) !== false;
    }
}