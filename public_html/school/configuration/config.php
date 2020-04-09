<?php
error_reporting(0);
#================ DATABASE CONFIGURATIONS ====================

define('DBHOST', 'localhost');
define('DBUSER', 'dreamuni_dream');
define('DBPASS', 'Hello@1985');
define('DBNAME', 'dreamuni_shopping');

/*define('DBHOST', 'localhost');
define('DBUSER', 'root');
define('DBPASS', '');
define('DBNAME', 'dreamuniform');*/

// mysql_connect(DBHOST,DBUSER,DBPASS);
// mysql_select_db(DBNAME);
#=============================================================
include('db.php');
#=============================================================

#================ SITE CONFIGURATIONS ==================
define('SITE_NAME', 'Dreamuniform');
define('SITE_MAINKEY', 'Dreamuniform');
define('TITLE_PRIFIX','Dreamuniform');
define('DEFAULT_TITLE','Dreamuniform');
define('DEFAULT_KEY','Dreamuniform');
define('DEFAULT_META','Dreamuniform');
define('IMG_TAG',SITE_NAME.' '.TITLE_PRIFIX);


#================ DIRECTORY CONFIGURATIONS ==================
define('F_PATH', $_SERVER['DOCUMENT_ROOT'].'/shopping/');  // Site Home directory : File path.
//define('F_PATH', $_SERVER['DOCUMENT_ROOT'].'/');  // Site Home directory : File path.
define('S_PATH', 'http://'.$_SERVER['HTTP_HOST'].rtrim(dirname($_SERVER['PHP_SELF']), '/\\').'/'); //Site path
define('H_PATH', 'http://'.$_SERVER['HTTP_HOST'].'/shopping/'); //host path
//define('H_PATH', 'http://'.$_SERVER['HTTP_HOST'].'/'); //host path
define('INC_PATH',F_PATH.'includes/');
define('RES_PATH',F_PATH.'resources/');
define('RES_PATH_S',S_PATH.'resources/');
define('RES_PATH_H',H_PATH.'resources/');
define('LIB_PATH',F_PATH.'lib/' );
define('IMAGE_PATH', F_PATH.'images/');			      // Image Path
define('IMAGE_PATH_S', S_PATH.'images/');			      // Image Path
define('IMAGE_PATH_H', H_PATH.'images/');			      // Image Path
define('MULTIMEDIA_PATH', F_PATH.'multimedia/');			      // Image Path
define('MULTIMEDIA_PATH_S', S_PATH.'multimedia/');			      // Image Path
define('MULTIMEDIA_PATH_H', H_PATH.'multimedia/');
define('BANNER_PATH', MULTIMEDIA_PATH.'banner/');			      // Image Path
define('BANNER_PATH_H', MULTIMEDIA_PATH_H.'banner/');			      // Image Path

define('BRAND_PATH', MULTIMEDIA_PATH.'brand/');
define('BRAND_PATH_H', MULTIMEDIA_PATH_H.'brand/');

define('PRODUCT_PATH', MULTIMEDIA_PATH.'product/');
define('PRODUCT_PATH_H', MULTIMEDIA_PATH_H.'product/');
define('GALLERY_PATH', MULTIMEDIA_PATH.'gallery/');
define('GALLERY_PATH_H', MULTIMEDIA_PATH_H.'gallery/');
define('NEWS_PATH', MULTIMEDIA_PATH.'news/');
define('NEWS_PATH_H', MULTIMEDIA_PATH_H.'news/');
define('CAT_PATH', MULTIMEDIA_PATH.'catagory/');
define('CAT_PATH_H', MULTIMEDIA_PATH_H.'catagory/');
define('CAT_THUMB_PATH', MULTIMEDIA_PATH.'catagory/thumb/');
define('CAT_THUMB_PATH_H', MULTIMEDIA_PATH_H.'catagory/thumb/');
define('TESTI_PATH', MULTIMEDIA_PATH.'testimonial/');
define('TESTI_PATH_H', MULTIMEDIA_PATH_H.'testimonial/');


#=============================================================

$localpath=getenv("SCRIPT_NAME");
$absolutepath=getenv("SCRIPT_FILENAME");
$_SERVER['DOCUMENT_ROOT']=substr($absolutepath,0,strpos($absolutepath,$localpath));

?>