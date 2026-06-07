<?php

header ("X-XSS-Protection: 0");

// Is there any input?
if( array_key_exists( "name", $_GET ) && $_GET[ 'name' ] != NULL ) {
	// Feedback for end user
	// $html .= '<pre>Hello ' . $_GET[ 'name' ] . '</pre>';

	// escape the input so it prints as text instead of running as HTML
	$name = htmlspecialchars($_GET['name'], ENT_QUOTES, 'UTF-8');
	$html .= '<pre>Hello ' . $name . '</pre>';
}

?>
