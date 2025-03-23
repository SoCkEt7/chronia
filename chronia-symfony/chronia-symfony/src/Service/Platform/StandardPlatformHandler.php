<?php

namespace App\Service\Platform;

use Symfony\Component\Process\Process;
use Psr\Log\LoggerInterface;

class StandardPlatformHandler implements PlatformHandlerInterface
{
    private string $cronServiceName;
    private LoggerInterface $logger;
    
    public function __construct(string $cronServiceName, LoggerInterface $logger)
    {
        $this->cronServiceName = $cronServiceName;
        $this->logger = $logger;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getCronServiceName(): string
    {
        return $this->cronServiceName;
    }
    
    /**
     * {@inheritdoc}
     */
    public function restartCronService(): bool
    {
        try {
            $process = new Process(['sudo', '/bin/systemctl', 'restart', $this->cronServiceName]);
            $process->run();
            
            if (!$process->isSuccessful()) {
                $this->logger->error('Failed to restart cron service: ' . $process->getErrorOutput());
                return false;
            }
            
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Error restarting cron service: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function isCronServiceRunning(): bool
    {
        try {
            $process = new Process(['systemctl', 'is-active', $this->cronServiceName]);
            $process->run();
            
            return $process->isSuccessful() && trim($process->getOutput()) === 'active';
        } catch (\Exception $e) {
            $this->logger->error('Error checking cron service: ' . $e->getMessage());
            return false;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getPlatformInfo(): array
    {
        return [
            'platform' => 'standard',
            'cron_service' => $this->cronServiceName,
        ];
    }
}