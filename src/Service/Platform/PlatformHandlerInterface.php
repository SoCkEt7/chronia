<?php

namespace App\Service\Platform;

interface PlatformHandlerInterface
{
    /**
     * Get the service name for the cron service
     */
    public function getCronServiceName(): string;
    
    /**
     * Restart the cron service
     */
    public function restartCronService(): bool;
    
    /**
     * Check if the cron service is running
     */
    public function isCronServiceRunning(): bool;
    
    /**
     * Get platform-specific information
     */
    public function getPlatformInfo(): array;
}