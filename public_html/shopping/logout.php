<?php 
@session_start();
session_destroy();
//header("location:index.php"); Line changed by birbal -26-06-2016
//header("location:lfigpuniforms.php");
header( 'Location: http://www.dreamuniforms.ae/school/lfigpuniforms.php' );
?>