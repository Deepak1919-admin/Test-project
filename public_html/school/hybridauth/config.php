<?php
/*!
* HybridAuth
* http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
* (c) 2009-2012, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
*/

// ----------------------------------------------------------------------------------------
//	HybridAuth Config file: http://hybridauth.sourceforge.net/userguide/Configuration.html
// ----------------------------------------------------------------------------------------
$burl= $_SERVER['SERVER_NAME'];
$config =array(
		"base_url" => "http://".$burl."/shopping/hybridauth/hybridauth/index.php", 
		"providers" => array ( 

			"Google" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "190791288973-2lf7qsddacvkjs9bflo62gjoo55b31e0.apps.googleusercontent.com", "secret" => "LkmOxaWMGVrVSp9iCSK5hm-L" ), 
			),

			"Facebook" => array ( 
				"enabled" => true,
				"keys"    => array ( "id" => "579511622207296", "secret" => "2f0ebd1b339993ee68ac1e27adcd0e34" ), 
			),

			"Twitter" => array ( 
				"enabled" => true,
				"keys"    => array ( "key" => "gpPZXbZLmPkRhjRnwsImHrLOl", "secret" => "kLB7ahwtkk9j9wNGm3KfVRtvbqJso7eXCjqfSsCJluXGvciMlY" ) 
			),
		),
		// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
		"debug_mode" => false,
		"debug_file" => "",
	);