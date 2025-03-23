<?php
/**
 * DebianHandler.php - Debian-specific platform implementation
 */

namespace Chrona\Platform;

class DebianHandler extends StandardHandler {
    /**
     * Get the service name for cron on Debian
     */
    public function getCronServiceName() {
        return 'cron';
    }
    
    /**
     * Get platform-specific details
     */
    public function getPlatformDetails() {
        $version = 'Unknown';
        if (file_exists('/etc/debian_version')) {
            $version = trim(file_get_contents('/etc/debian_version'));
        }
        
        return [
            'name' => 'Debian',
            'version' => $version,
            'detected' => true
        ];
    }
}