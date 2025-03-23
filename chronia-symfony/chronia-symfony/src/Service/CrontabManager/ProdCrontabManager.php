<?php

namespace App\Service\CrontabManager;

use App\Service\Platform\PlatformHandlerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Psr\Log\LoggerInterface;

class ProdCrontabManager implements CrontabManagerInterface
{
    private string $crontabUser;
    private string $tempDir;
    private PlatformHandlerInterface $platformHandler;
    private LoggerInterface $logger;
    private array $allowedCommands;
    
    public function __construct(
        string $crontabUser,
        string $tempDir,
        PlatformHandlerInterface $platformHandler,
        LoggerInterface $logger,
        array $allowedCommands
    ) {
        $this->crontabUser = $crontabUser;
        $this->tempDir = $tempDir;
        $this->platformHandler = $platformHandler;
        $this->logger = $logger;
        $this->allowedCommands = $allowedCommands;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEntries(): array
    {
        try {
            $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', '-l']);
            $process->run();
            
            if (!$process->isSuccessful()) {
                // If the user has no crontab, return empty array
                if (strpos($process->getErrorOutput(), 'no crontab') !== false) {
                    return [];
                }
                
                $this->logger->error('Failed to get crontab entries: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }
            
            $output = explode("\n", $process->getOutput());
            
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
        } catch (\Exception $e) {
            $this->logger->error('Error getting crontab entries: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Parse a crontab line into a structured format
     */
    protected function parseCrontabLine(string $line, int $id): ?array
    {
        // Basic crontab line parsing - same as DevCrontabManager
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
        // In a real implementation, this would query the logs
        // Here we'll just return placeholder data
        return [
            'time' => null,
            'status' => null,
            'output' => null
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function addEntry(string $schedule, string $command): bool
    {
        try {
            $entries = $this->getEntries();
            
            // Create a temporary file with the current crontab contents
            $tempFile = tempnam($this->tempDir, 'chronia_crontab_');
            $handle = fopen($tempFile, 'w');
            
            // Write existing entries
            foreach ($entries as $entry) {
                fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
            }
            
            // Add the new entry
            fwrite($handle, $schedule . ' ' . $command . "\n");
            fclose($handle);
            
            // Install the new crontab
            $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', $tempFile]);
            $process->run();
            
            // Clean up
            unlink($tempFile);
            
            if (!$process->isSuccessful()) {
                $this->logger->error('Failed to add crontab entry: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }
            
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Error adding crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function updateEntry(int $id, string $schedule, string $command): bool
    {
        try {
            $entries = $this->getEntries();
            
            // Create a temporary file with the updated crontab contents
            $tempFile = tempnam($this->tempDir, 'chronia_crontab_');
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
            $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', $tempFile]);
            $process->run();
            
            // Clean up
            unlink($tempFile);
            
            if (!$process->isSuccessful()) {
                $this->logger->error('Failed to update crontab entry: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }
            
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Error updating crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteEntry(int $id): bool
    {
        try {
            $entries = $this->getEntries();
            
            // Create a temporary file without the deleted entry
            $tempFile = tempnam($this->tempDir, 'chronia_crontab_');
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
            $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', $tempFile]);
            $process->run();
            
            // Clean up
            unlink($tempFile);
            
            if (!$process->isSuccessful()) {
                $this->logger->error('Failed to delete crontab entry: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }
            
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Error deleting crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function toggleEntryActive(int $id, bool $active): bool
    {
        try {
            $entries = $this->getEntries();
            
            // Create a temporary file with the updated crontab contents
            $tempFile = tempnam($this->tempDir, 'chronia_crontab_');
            $handle = fopen($tempFile, 'w');
            
            $updated = false;
            foreach ($entries as $entry) {
                if ($entry['id'] == $id) {
                    $line = $entry['schedule'] . ' ' . $entry['command'];
                    if (!$active) {
                        $line = '#' . $line . ' # Disabled by Chronia';
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
            $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', $tempFile]);
            $process->run();
            
            // Clean up
            unlink($tempFile);
            
            if (!$process->isSuccessful()) {
                $this->logger->error('Failed to toggle crontab entry: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }
            
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Error toggling crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function testRun(int $id)
    {
        try {
            $entries = $this->getEntries();
            
            foreach ($entries as $entry) {
                if ($entry['id'] == $id) {
                    // Run the command through the job runner
                    $jobRunner = '/usr/bin/chrona_job_runner.sh';
                    $process = new Process(['sudo', '-u', $this->crontabUser, $jobRunner, $entry['command']]);
                    $process->run();
                    
                    return [
                        'exit_code' => $process->getExitCode(),
                        'output' => $process->getOutput() . "\n" . $process->getErrorOutput()
                    ];
                }
            }
            
            return false;
        } catch (\Exception $e) {
            $this->logger->error('Error testing crontab entry: ' . $e->getMessage());
            return [
                'exit_code' => 1,
                'output' => 'Error: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getNextRunTimes(string $schedule, int $count = 5): array
    {
        // Use Cron\CronExpression in production version
        // This is a placeholder implementation
        // In Symfony version, we would use the cron-expression library
        $times = [];
        $now = time();
        
        for ($i = 1; $i <= $count; $i++) {
            $times[] = date('Y-m-d H:i:s', $now + ($i * 3600)); // Placeholder: every hour
        }
        
        return $times;
    }
}