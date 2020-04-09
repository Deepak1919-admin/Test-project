<?php

// First file loaded in the application. All the initializations are done here
// get the application Configurations
include('configuration/config.php');

// Get our functions
include 'include/functions.php';

// Sanitize the global arrays.
_sanitize_globals();

// Get Mysql Instance and Connect to DB
$db = load_class('DB');
?>