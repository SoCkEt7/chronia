<?php

namespace App\Service\CrontabManager;

use App\Service\Platform\PlatformHandlerInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Psr\Log\LoggerInterface;
use Monolog\Logger;

class ProdCrontabManager implements CrontabManagerInterface
{
    private string $crontabUser;
    private string $tempDir;
    private PlatformHandlerInterface $platformHandler;
    private LoggerInterface $logger;
    private array $allowedCommands;
    
    public function __construct(
        string $tempDir,
        PlatformHandlerInterface $platformHandler,
        LoggerInterface $logger,
        array $allowedCommands,
        ?string $crontabUser = null
    ) {
        // Use provided user, fallback to current user for crontab operations
        if ($crontabUser) {
            $this->crontabUser = $crontabUser;
        } else {
            $this->crontabUser = posix_getpwuid(posix_geteuid())['name'];
        }
        
        $this->tempDir = $tempDir;
        $this->platformHandler = $platformHandler;
        $this->logger = $logger;
        $this->allowedCommands = $allowedCommands;
        
        $this->logger->info('Crontab user set to: ' . $this->crontabUser);
    }
    
    /**
     * {@inheritdoc}
     */
    public function getEntries(?string $user = null): array
    {
        // Temporarily override the crontab user if specified
        $originalUser = null;
        if ($user !== null && $user !== $this->crontabUser) {
            $originalUser = $this->crontabUser;
            $this->crontabUser = $user;
            $this->logger->info('Temporarily using crontab user: ' . $user);
        }
        
        try {
            // Exécution de crontab avec l'utilisateur spécifié si différent de l'utilisateur courant
            $currentUser = posix_getpwuid(posix_geteuid())['name'];
            
            if ($currentUser === $this->crontabUser) {
                // Même utilisateur, exécution directe
                $process = new Process(['crontab', '-l']);
            } else {
                // Utilisateur différent, utiliser sudo si possible
                $this->logger->info('Trying to access crontab for user ' . $this->crontabUser);
                $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', '-l']);
            }
            
            $process->run();
            
            if (!$process->isSuccessful()) {
                // If the user has no crontab, return empty array
                if (strpos($process->getErrorOutput(), 'no crontab') !== false) {
                    $this->logger->info('No crontab found for user ' . $this->crontabUser);
                    return [];
                }
                
                // Si l'accès sudo échoue, essayer sans sudo
                if (strpos($process->getErrorOutput(), 'sudo') !== false) {
                    $this->logger->warning('Failed to access crontab via sudo, falling back to current user');
                    $this->crontabUser = $currentUser;
                    $process = new Process(['crontab', '-l']);
                    $process->run();
                    
                    if (!$process->isSuccessful()) {
                        if (strpos($process->getErrorOutput(), 'no crontab') !== false) {
                            return [];
                        }
                        $this->logger->error('Failed to get crontab entries: ' . $process->getErrorOutput());
                        throw new ProcessFailedException($process);
                    }
                } else {
                    $this->logger->error('Failed to get crontab entries: ' . $process->getErrorOutput());
                    throw new ProcessFailedException($process);
                }
            }
            
            $output = explode("\n", $process->getOutput());
            
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
            
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
            }
            
            return $entries;
        } catch (\Exception $e) {
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
            }
            
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
     * Helper method for updating crontab with the appropriate user
     */
    private function updateCrontab(string $tempFile): bool
    {
        $currentUser = posix_getpwuid(posix_geteuid())['name'];
        
        if ($currentUser === $this->crontabUser) {
            // Même utilisateur, exécution directe
            $process = new Process(['crontab', $tempFile]);
        } else {
            // Utilisateur différent, utiliser sudo si possible
            $process = new Process(['sudo', '-u', $this->crontabUser, 'crontab', $tempFile]);
        }
        
        $process->run();
        
        if (!$process->isSuccessful()) {
            // Si l'accès sudo échoue, essayer sans sudo
            if ($currentUser !== $this->crontabUser && strpos($process->getErrorOutput(), 'sudo') !== false) {
                $this->logger->warning('Failed to update crontab via sudo, falling back to current user');
                $this->crontabUser = $currentUser;
                $process = new Process(['crontab', $tempFile]);
                $process->run();
                
                if (!$process->isSuccessful()) {
                    $this->logger->error('Failed to update crontab: ' . $process->getErrorOutput());
                    throw new ProcessFailedException($process);
                }
            } else {
                $this->logger->error('Failed to update crontab: ' . $process->getErrorOutput());
                throw new ProcessFailedException($process);
            }
        }
        
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public function addEntry(string $schedule, string $command, ?string $user = null): bool
    {
        try {
            // Temporarily override the crontab user if specified
            $originalUser = null;
            if ($user !== null && $user !== $this->crontabUser) {
                $originalUser = $this->crontabUser;
                $this->crontabUser = $user;
                $this->logger->info('Temporarily using crontab user: ' . $user);
            }
            
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
            $result = $this->updateCrontab($tempFile);
            
            // Clean up
            unlink($tempFile);
            
            $this->logger->info('Added new crontab entry for user ' . $this->crontabUser . ': ' . $schedule . ' ' . $command);
            
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
            }
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->error('Error adding crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function updateEntry(int $id, string $schedule, string $command, ?string $user = null): bool
    {
        try {
            // Temporarily override the crontab user if specified
            $originalUser = null;
            if ($user !== null && $user !== $this->crontabUser) {
                $originalUser = $this->crontabUser;
                $this->crontabUser = $user;
                $this->logger->info('Temporarily using crontab user: ' . $user);
            }
            
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
                
                // Restore original user if we temporarily changed it
                if ($originalUser !== null) {
                    $this->crontabUser = $originalUser;
                }
                
                return false;
            }
            
            // Install the new crontab
            $result = $this->updateCrontab($tempFile);
            
            // Clean up
            unlink($tempFile);
            
            $this->logger->info('Updated crontab entry ID ' . $id . ' for user ' . $this->crontabUser . ': ' . $schedule . ' ' . $command);
            
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
            }
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->error('Error updating crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function deleteEntry(int $id, ?string $user = null): bool
    {
        try {
            // Temporarily override the crontab user if specified
            $originalUser = null;
            if ($user !== null && $user !== $this->crontabUser) {
                $originalUser = $this->crontabUser;
                $this->crontabUser = $user;
                $this->logger->info('Temporarily using crontab user: ' . $user);
            }
            
            $entries = $this->getEntries();
            
            // Create a temporary file without the deleted entry
            $tempFile = tempnam($this->tempDir, 'chronia_crontab_');
            $handle = fopen($tempFile, 'w');
            
            $deleted = false;
            $deletedCommand = '';
            foreach ($entries as $entry) {
                if ($entry['id'] != $id) {
                    fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
                } else {
                    $deleted = true;
                    $deletedCommand = $entry['command'];
                }
            }
            
            fclose($handle);
            
            if (!$deleted) {
                unlink($tempFile);
                
                // Restore original user if we temporarily changed it
                if ($originalUser !== null) {
                    $this->crontabUser = $originalUser;
                }
                
                return false;
            }
            
            // Install the new crontab
            $result = $this->updateCrontab($tempFile);
            
            // Clean up
            unlink($tempFile);
            
            $this->logger->info('Deleted crontab entry ID ' . $id . ' for user ' . $this->crontabUser . ': ' . $deletedCommand);
            
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
            }
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->error('Error deleting crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function toggleEntryActive(int $id, bool $active, ?string $user = null): bool
    {
        try {
            // Temporarily override the crontab user if specified
            $originalUser = null;
            if ($user !== null && $user !== $this->crontabUser) {
                $originalUser = $this->crontabUser;
                $this->crontabUser = $user;
                $this->logger->info('Temporarily using crontab user: ' . $user);
            }
            
            $entries = $this->getEntries();
            
            // Create a temporary file with the updated crontab contents
            $tempFile = tempnam($this->tempDir, 'chronia_crontab_');
            $handle = fopen($tempFile, 'w');
            
            $updated = false;
            $toggledCommand = '';
            foreach ($entries as $entry) {
                if ($entry['id'] == $id) {
                    $line = $entry['schedule'] . ' ' . $entry['command'];
                    if (!$active) {
                        $line = '#' . $line . ' # Disabled by Chronia';
                    }
                    fwrite($handle, $line . "\n");
                    $updated = true;
                    $toggledCommand = $entry['command'];
                } else {
                    fwrite($handle, $entry['schedule'] . ' ' . $entry['command'] . "\n");
                }
            }
            
            fclose($handle);
            
            if (!$updated) {
                unlink($tempFile);
                
                // Restore original user if we temporarily changed it
                if ($originalUser !== null) {
                    $this->crontabUser = $originalUser;
                }
                
                return false;
            }
            
            // Install the new crontab
            $result = $this->updateCrontab($tempFile);
            
            // Clean up
            unlink($tempFile);
            
            $status = $active ? 'activated' : 'deactivated';
            $this->logger->info('Crontab entry ID ' . $id . ' ' . $status . ' for user ' . $this->crontabUser . ': ' . $toggledCommand);
            
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
            }
            
            return $result;
        } catch (\Exception $e) {
            $this->logger->error('Error toggling crontab entry: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function testRun(int $id, ?string $user = null)
    {
        try {
            // Temporarily override the crontab user if specified
            $originalUser = null;
            if ($user !== null && $user !== $this->crontabUser) {
                $originalUser = $this->crontabUser;
                $this->crontabUser = $user;
                $this->logger->info('Temporarily using crontab user: ' . $user);
            }
            
            $entries = $this->getEntries();
            
            foreach ($entries as $entry) {
                if ($entry['id'] == $id) {
                    // Créer un fichier temporaire pour exécuter la commande
                    $tempScript = tempnam($this->tempDir, 'chronia_test_');
                    unlink($tempScript); // Supprimer le fichier pour le recréer avec l'extension .sh
                    $tempScript .= '.sh';
                    
                    // Écrire le script avec la commande à tester
                    file_put_contents($tempScript, "#!/bin/bash\n\necho \"=== Exécution de la commande pour test ===\"\necho \"Commande: {$entry['command']}\"\necho \"Utilisateur: $(whoami)\"\necho \"Date: $(date)\"\necho \"===================================\"\n\n{$entry['command']}\n");
                    chmod($tempScript, 0755);
                    
                    // Exécuter le script - en tant qu'utilisateur crontab si possible
                    $this->logger->info('Testing command for user ' . $this->crontabUser . ': ' . $entry['command']);
                    
                    $currentUser = posix_getpwuid(posix_geteuid())['name'];
                    if ($currentUser === $this->crontabUser) {
                        $process = new Process([$tempScript]);
                    } else {
                        $process = new Process(['sudo', '-u', $this->crontabUser, $tempScript]);
                    }
                    
                    $process->setTimeout(60); // Timeout de 60 secondes
                    $process->run();
                    
                    // Si sudo échoue, réessayer en tant qu'utilisateur courant
                    if (!$process->isSuccessful() && $currentUser !== $this->crontabUser && 
                        strpos($process->getErrorOutput(), 'sudo') !== false) {
                        $this->logger->warning('Failed to test via sudo, trying as current user');
                        $process = new Process([$tempScript]);
                        $process->setTimeout(60);
                        $process->run();
                    }
                    
                    // Nettoyage
                    unlink($tempScript);
                    
                    // Restore original user if we temporarily changed it
                    if ($originalUser !== null) {
                        $this->crontabUser = $originalUser;
                        $this->logger->info('Restored original crontab user: ' . $originalUser);
                    }
                    
                    return [
                        'exit_code' => $process->getExitCode(),
                        'output' => $process->getOutput() . "\n" . $process->getErrorOutput()
                    ];
                }
            }
            
            // Restore original user if we temporarily changed it
            if ($originalUser !== null) {
                $this->crontabUser = $originalUser;
                $this->logger->info('Restored original crontab user: ' . $originalUser);
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
        try {
            $cron = new \Cron\CronExpression($schedule);
            $times = [];
            $nextTime = new \DateTime();
            
            for ($i = 0; $i < $count; $i++) {
                $nextTime = $cron->getNextRunDate($nextTime);
                $times[] = $nextTime->format('Y-m-d H:i:s');
            }
            
            return $times;
        } catch (\Exception $e) {
            $this->logger->error('Invalid cron schedule: ' . $schedule);
            // Fallback to placeholder if expression is invalid
            $times = [];
            $now = time();
            
            for ($i = 1; $i <= $count; $i++) {
                $times[] = date('Y-m-d H:i:s', $now + ($i * 3600)); // Placeholder: every hour
            }
            
            return $times;
        }
    }
}