<?php
	/* New Markdown Parser - There is a proper readme in the PHP-Markdown-Parser folder */
	require './required/PHP-Markdown-Parser/from.php';
	require './required/PHP-Markdown-Parser/to.php';

	/* We need to define the functions so that we can use the parser anywhere and as much as we want */
    function from_markdown(...$v) {
        return x\markdown\from(...$v);
    }

    function to_markdown(...$v) {
        return x\markdown\to(...$v);
    }
?>