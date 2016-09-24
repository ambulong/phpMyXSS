<?php
/**
 * Generate Password
 */
if(count($argv) != 2)
    die("Usage: ".$argv[0]." password\n");

require "./includes/lib/class.passwordhash.php";
$hasher = new PasswordHash ( 8, FALSE );
$hash = $hasher->HashPassword ( $argv[1] );
echo "{$hash}\n";
