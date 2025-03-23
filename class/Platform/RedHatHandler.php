<?php
/**
 * RedHatHandler.php - RedHat-specific platform implementation
 */

namespace Chrona\Platform;

class RedHatHandler extends StandardHandler {
    /**
     * Get the service name for cron on RedHat systems
     */
    public function getCronServiceName() {
        return 'crond';
    }
    
    /**
     * Get platform-specific details
     */
    public function getPlatformDetails() {
        $version = 'Unknown';
        if (file_exists('/etc/redhat-release')) {
            $version = trim(file_get_contents('/etc/redhat-release'));
        }
        
        return [
            'name' => 'RedHat/CentOS',
            'version' => $version,
            'detected' => true
        ];
    }
}