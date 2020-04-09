<?php 
session_start();
ob_start();
include '../commonclass.php';

if(isset($_SESSION['dream']['user_id'])) {
	 function esc($s)
    {
        $s = mysql_real_escape_string($s);
        $s = htmlentities($s);
        return $s;
    }
	if (isset($_POST['oldPassword'], $_POST['password'])) {	
		$oldPassword = esc($_POST['oldPassword']);
		$password = esc($_POST['password']);
		if($_SESSION['dream']['type']=='school' ){
			$userRow = $objSchool->getRow($_SESSION['dream']['user_id'], $oldPassword);
		}else if($_SESSION['dream']['type']=='corporate'){
			$userRow = $objCorporate->getRow($_SESSION['dream']['user_id'], $oldPassword);
		}else if($_SESSION['dream']['type']=='user'){
			$userRow = $objUsers->getRow($_SESSION['dream']['user_id'], $oldPassword);
		}
			
		if (count($userRow) > 1) {
			$upadatearray = array();
			$upadatearray['id'] = $userRow['id'];
			$upadatearray['password'] = $_POST['password'];
			if($_SESSION['dream']['type']=='school' ){
				$objSchool->setArrData($upadatearray);
				$objSchool->update_pwd();
			}else if($_SESSION['dream']['type']=='corporate'){
				$objCorporate->setArrData($upadatearray);
				$objCorporate->update_pwd();
			}else if($_SESSION['dream']['type']=='user'){
				$objUsers->setArrData($upadatearray);
				$objUsers->update_pwd();
			}

				$_SESSION['msg'] = '<div class="alert alert-success" role="alert">Updated Successfully</div>';
		} else {
			$_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Something Went Wrong</div>';
		}
	}
}
header("location:".$_SERVER['HTTP_REFERER']);
?>