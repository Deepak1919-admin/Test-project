<?php 
define('DBHOST', 'localhost');
define('DBUSER', 'dreamuni_dream');
define('DBPASS', 'Hello@1985');
define('DBNAME', 'dreamuni_shopping');
$conn = mysqli_connect(DBHOST,DBUSER,DBPASS,DBNAME) or die('DB connection faied');
?>