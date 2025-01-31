<?php
// PHP shortcode function to execute PHP code
function shortcode_php($attributes, $content) {
    // Check if content is provided
    if (empty($content)) {
        return '<p>Error: No PHP code provided.</p>';
    }

    // Sanitize the content if needed (optional, but recommended for safety)
    // E.g., sanitize with a whitelist of allowed functions or code.
    
    // Evaluate the PHP code safely
    ob_start();  // Start output buffering
    eval($content);  // Execute the PHP code
    $output = ob_get_clean();  // Get the result and clean buffer

    return $output;
}
?>