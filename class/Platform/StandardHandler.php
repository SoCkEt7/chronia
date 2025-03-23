<?php
/**
 * StandardHandler.php - Standard platform implementation for crontab operations
 */

namespace Chrona\Platform;

class StandardHandler implements PlatformHandlerInterface {
    /**
     * Get the command to list all crontab entries
     */
    public function getListCommand() {
        return 'crontab -l';
    }
    
    /**
     * Get the command to install a new crontab
     */
    public function getInstallCommand($file) {
        return 'crontab ' . escapeshellarg($file);
    }
    
    /**
     * Get the service name for cron
     */
    public function getCronServiceName() {
        return 'cron';
    }
    
    /**
     * Get the status of the cron service
     */
    public function getCronStatus() {
        $output = [];
        $exitCode = 0;
        
        exec('systemctl status cron 2>&1', $output, $exitCode);
        
        if ($exitCode !== 0) {
            // Try crond as an alternative
            exec('systemctl status crond 2>&1', $output, $exitCode);
        }
        
        return [
            'running' => $exitCode === 0,
            'output' => implode("\n", $output)
        ];
    }
    
    /**
     * Get platform-specific details
     */
    public function getPlatformDetails() {
        return [
            'name' => 'Standard Linux',
            'version' => 'Unknown',
            'detected' => true
        ];
    }
}