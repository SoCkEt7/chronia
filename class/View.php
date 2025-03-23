<?php
/**
 * View.php - Simple view class for rendering templates
 */

namespace Chrona;

class View {
    /**
     * Render a view template with data
     */
    public function render($template, $data = []) {
        // Extract data to make variables available in the template
        extract($data);
        
        // Include header
        include dirname(__DIR__) . '/view/header.php';
        
        // Include the template
        $templateFile = dirname(__DIR__) . '/view/' . $template . '.php';
        if (file_exists($templateFile)) {
            include $templateFile;
        } else {
            echo '<div class="alert alert-danger">Template not found: ' . htmlspecialchars($template) . '</div>';
        }
        
        // Include footer
        include dirname(__DIR__) . '/view/footer.php';
    }
}