<?php
	// Preformatted content shortcode
	function shortcode_pre($attributes, $content) {
		return '<pre>' . htmlspecialchars($content) . '</pre>';
	}
?>