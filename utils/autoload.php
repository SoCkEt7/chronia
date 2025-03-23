<?php
/**
 * autoload.php - Simple autoloader for Chrona classes
 */

spl_autoload_register(function ($class) {
    // Convert namespace separators to directory separators
    $classPath = str_replace('\\', '/', $class);
    
    // Handle the Chrona namespace
    if (strpos($classPath, 'Chrona/') === 0) {
        $classPath = substr($classPath, 7); // Remove the "Chrona/" prefix
        $classFile = __DIR__ . '/../class/' . $classPath . '.php';
        
        if (file_exists($classFile)) {
            require_once $classFile;
            return true;
        }
    }
    
    return false;
});