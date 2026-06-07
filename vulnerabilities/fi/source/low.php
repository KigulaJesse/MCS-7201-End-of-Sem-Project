<?php
$file = $_GET[ 'page' ];

// only allow the pages this feature is meant to load
$allowed = array("include.php", "file1.php", "file2.php", "file3.php");
if (!in_array($file, $allowed)) {
    echo "ERROR: File not found!";
    exit;
}
?>


