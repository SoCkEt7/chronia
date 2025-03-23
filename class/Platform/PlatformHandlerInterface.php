<?php
/**
 * PlatformHandlerInterface.php - Interface for platform-specific handlers
 */

namespace Chrona\Platform;

interface PlatformHandlerInterface {
    /**
     * Get the command to list all crontab entries
     */
    public function getListCommand();
    
    /**
     * Get the command to install a new crontab
     */
    public function getInstallCommand($file);
    
    /**
     * Get the service name for cron
     */
    public function getCronServiceName();
    
    /**
     * Get the status of the cron service
     */
    public function getCronStatus();
    
    /**
     * Get platform-specific details
     */
    public function getPlatformDetails();
}