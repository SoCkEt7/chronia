<?php
/**
 * CrontabManager.php - Core class for managing crontab entries
 */

namespace Chrona;

class CrontabManager {
    private $config;
    private $tempDir = '/tmp';
    private $platformHandler;
    
    /**
     * Constructor
     */
    public function __construct($config = null) {
        if ($config === null) {
            $configFile = dirname(__DIR__) . '/config/system.json';
            if (file_exists($configFile)) {
                $this->config = json_decode(file_get_contents($configFile), true);
            } else {
                $this->config = [];
            }
        } else {
            $this->config = $config;
        }
        
        // Initialize platform-specific handler
        $this->initPlatformHandler();
    }
    
    /**
     * Initialize the appropriate platform handler
     */
    private function initPlatformHandler() {
        // Detect platform and initialize appropriate handler
        if (isset($this->config['platform'])) {
            $platform = $this->config['platform'];
        } else {
            $platform = $this->detectPlatform();
        }
        
        switch ($platform) {
            case 'debian':
                $this->platformHandler = new Platform\DebianHandler();
                break;
            case 'redhat':
                $this->platformHandler = new Platform\RedHatHandler();
                break;
            default:
                $this->platformHandler = new Platform\StandardHandler();
        }
    }
    
    /**
     * Detect the current platform
     */
    private function detectPlatform() {
        // Basic platform detection
        if (file_exists('/etc/debian_version')) {
            return 'debian';
        } elseif (file_exists('/etc/redhat-release')) {
            return 'redhat';
        } else {
            return 'standard';
        }
    }
    
    /**
     * Get all crontab entries
     */
    public function getEntries() {
        $output = [];
        $exitCode = 0;
        
        // Execute the crontab -l command as the chrona user
        exec('sudo -u chrona crontab -l 2>/dev/null', $output, $exitCode);
        
        // Parse the output into a structured format
        $entries = [];
        $id = 1;
        
        foreach ($output as $line) {
            // Skip empty lines and comments
            if (empty(trim($line)) || strpos(trim($line), '#') === 0) {
                continue;
            }
            
            // Parse the crontab entry
            $entry = $this->parseCrontabLine($line, $id);
            if ($entry) {
                $entries[] = $entry;
                $id++;
            }
        }
        
        return $entries;
    }
    
    /**
     * Parse a crontab line into a structured format
     */
    protected function parseCrontabLine($line, $id) {
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
    protected function getLastRunInfo($command) {
        // In a real implementation, this would query the logs
        // Here we'll just return placeholder data
        return [
            'time' => null,
            'status' => null,
            'output' => null
        ];
    }
    
    /**
     * Add a new crontab entry
     */
    public function addEntry($schedule, $command) {
        $entries = $this->getEntries();
        
        // Create a temporary file with the current crontab contents
        $tempFile = $this->tempDir . '/chrona_crontab_' . uniqid();
        $handle = fopen($tempFile, 'w');
        
        // Write existing entries
        foreach ($entries as $entry) {
            fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
        }
        
        // Add the new entry
        fwrite($handle, $schedule . ' ' . $command . "\n");
        fclose($handle);
        
        // Install the new crontab
        $output = [];
        $exitCode = 0;
        exec('sudo -u chrona crontab ' . $tempFile . ' 2>&1', $output, $exitCode);
        
        // Clean up
        unlink($tempFile);
        
        return $exitCode === 0;
    }
    
    /**
     * Update an existing crontab entry
     */
    public function updateEntry($id, $schedule, $command) {
        $entries = $this->getEntries();
        
        // Create a temporary file with the updated crontab contents
        $tempFile = $this->tempDir . '/chrona_crontab_' . uniqid();
        $handle = fopen($tempFile, 'w');
        
        $updated = false;
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                fwrite($handle, $schedule . ' ' . $command . "\n");
                $updated = true;
            } else {
                fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
            }
        }
        
        fclose($handle);
        
        if (!$updated) {
            unlink($tempFile);
            return false;
        }
        
        // Install the new crontab
        $output = [];
        $exitCode = 0;
        exec('sudo -u chrona crontab ' . $tempFile . ' 2>&1', $output, $exitCode);
        
        // Clean up
        unlink($tempFile);
        
        return $exitCode === 0;
    }
    
    /**
     * Delete a crontab entry
     */
    public function deleteEntry($id) {
        $entries = $this->getEntries();
        
        // Create a temporary file without the deleted entry
        $tempFile = $this->tempDir . '/chrona_crontab_' . uniqid();
        $handle = fopen($tempFile, 'w');
        
        $deleted = false;
        foreach ($entries as $entry) {
            if ($entry['id'] != $id) {
                fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
            } else {
                $deleted = true;
            }
        }
        
        fclose($handle);
        
        if (!$deleted) {
            unlink($tempFile);
            return false;
        }
        
        // Install the new crontab
        $output = [];
        $exitCode = 0;
        exec('sudo -u chrona crontab ' . $tempFile . ' 2>&1', $output, $exitCode);
        
        // Clean up
        unlink($tempFile);
        
        return $exitCode === 0;
    }
    
    /**
     * Toggle the active state of a crontab entry
     */
    public function toggleEntryActive($id, $active) {
        $entries = $this->getEntries();
        
        // Create a temporary file with the updated crontab contents
        $tempFile = $this->tempDir . '/chrona_crontab_' . uniqid();
        $handle = fopen($tempFile, 'w');
        
        $updated = false;
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                $line = $entry['schedule'] . ' ' . $entry['command'];
                if (!$active) {
                    $line = '#' . $line . ' # Disabled by Chrona';
                }
                fwrite($handle, $line . "\n");
                $updated = true;
            } else {
                fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
            }
        }
        
        fclose($handle);
        
        if (!$updated) {
            unlink($tempFile);
            return false;
        }
        
        // Install the new crontab
        $output = [];
        $exitCode = 0;
        exec('sudo -u chrona crontab ' . $tempFile . ' 2>&1', $output, $exitCode);
        
        // Clean up
        unlink($tempFile);
        
        return $exitCode === 0;
    }
    
    /**
     * Test run a crontab entry
     */
    public function testRun($id) {
        $entries = $this->getEntries();
        
        foreach ($entries as $entry) {
            if ($entry['id'] == $id) {
                // Run the command through the job runner
                $output = [];
                $exitCode = 0;
                
                $command = 'sudo -u chrona /usr/bin/chrona_job_runner.sh ' . escapeshellarg($entry['command']) . ' 2>&1';
                exec($command, $output, $exitCode);
                
                return [
                    'exit_code' => $exitCode,
                    'output' => implode("\n", $output)
                ];
            }
        }
        
        return false;
    }
    
    /**
     * Calculate the next run times for a crontab entry
     */
    public function getNextRunTimes($schedule, $count = 5) {
        // In a real implementation, this would calculate the actual next run times
        // This is a placeholder
        $times = [];
        $now = time();
        
        for ($i = 1; $i <= $count; $i++) {
            $times[] = date('Y-m-d H:i:s', $now + ($i * 3600)); // Placeholder: every hour
        }
        
        return $times;
    }
}