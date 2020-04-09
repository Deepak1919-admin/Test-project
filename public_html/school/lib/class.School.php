<?php
class School {
	var $name;
	var $settings;
	var $err;
	/// constructors
	function School($err=""){
		global $db;
		$this->err =$err; 
	}
	function getArrData(){
		return $this->arrData;
	}
	function setArrData($szArrData)	{
		$this->arrData = $szArrData;			
	}
	function getFileArrData(){
		return $this->arrFileData;
	}
	function setFileArrData($szArrData)	{
		$this->arrFileData = $szArrData;			
	}
	function getErr(){
		return $this->err;
	}
	function setErr($szError){
		$this->err .= " - <em>$szError</em>";
	}
	
	function login()
	{
		session_start();
		global $db;
		$arrData   = $this->getArrData();
		

//$que="SELECT * FROM " .TBL_SCHOOL. " WHERE email='".$arrData["email"]."' and code='".$arrData["code"]."' AND //password='".$arrData["password"]."' AND status='1'";
$que="SELECT * FROM " .TBL_SCHOOL. " INNER JOIN " .TBL_USERS. " WHERE ".TBL_USERS.".email='".$arrData["email"]."' and ".TBL_SCHOOL.".code='".$arrData["code"]."' AND ".TBL_USERS.".password='".$arrData["password"]."' AND ".TBL_SCHOOL.".status='1'";
		$rs = $db->query($que);
		if($rs->num_rows()>0)
		{
			$row = $rs->fetch_assoc();
			unset($_SESSION['dream']);
			$_SESSION['dream']['user_id'] 		= $row["id"];
			$_SESSION['dream']['name'] 		= $row["name"];
			$_SESSION['dream']['email'] 		= $row["email"];	
			$_SESSION['dream']['code']			= $row["code"];	
			$_SESSION['dream']['type']			= 'school'; 
			// Update the last login date
			$que="UPDATE " .TBL_SCHOOL. " set last_login = now() WHERE id=".$_SESSION['dream']['user_id'] ."";
			$rs = $db->query($que);
			// Update Last Login	
			return true;
		}
		else
		{
			return false;
		}	
	}	
function direct_login()
	{
		session_start();
		global $db;
		$arrData   = $this->getArrData();
		$que="SELECT * FROM " .TBL_SCHOOL. " WHERE email='".$arrData["email"]."'  AND password='".$arrData["password"]."' AND status='1'";


		$rs = $db->query($que);
		if($rs->num_rows()>0)
		{
			$row = $rs->fetch_assoc();
			unset($_SESSION['dream']);
			$_SESSION['dream']['user_id'] 		= $row["id"];
			$_SESSION['dream']['name'] 		= $row["name"];
			$_SESSION['dream']['email'] 		= $row["email"];	
			/*$_SESSION['dream']['code']			= $row["code"];	
			$_SESSION['dream']['type']			= 'school'; */
			$_SESSION['dream']['type']='school';
			// Update the last login date
			$que="UPDATE " .TBL_SCHOOL. " set last_login = now() WHERE id=".$_SESSION['dream']['user_id'] ."";
			$rs = $db->query($que);
			// Update Last Login	
			return true;
		}

                
else {

$queu="SELECT * FROM " .TBL_USERS. " WHERE email='".$arrData["email"]."' AND status=1 AND password='".$arrData["password"]."'";
        $rsu = $db->query($queu);
        if($rsu->num_rows()>0){
            $row = $rsu->fetch_assoc();
            $_SESSION['dream']['user_id'] = $row["id"];
            $_SESSION['dream']['name'] = $row["first_name"];
            $_SESSION['dream']['email'] = $row["email"];
	    $_SESSION['dream']['type']	= 'user';
			
            // Update the last login date
            $que="UPDATE " .TBL_USERS. " set last_login = now() WHERE id=".$row["id"]."";
            $rs = $db->query($que);
            // Update Last Login
            return true;
        }

              else
		{
			return false;
		}	

}


		
	}	

function checkUser($email,$id='') {
        global $db;
        $arrData   = $this->getArrData();
        $rs = $db->query("SELECT * FROM " .TBL_SCHOOL. " WHERE email='".$email."'  AND id!='".$id."' ");
        if($rs){
            $row  = $rs->fetch_assoc();
        }
        return $row;
    }

function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass.= $alphabet[$n];
        }
        return $pass; 
    }
	
	
	
	function loginWithCode()
	{
		session_start();
		global $db;
		$arrData   = $this->getArrData();
		$que="SELECT * FROM " .TBL_SCHOOL. " WHERE code='".$arrData["code"]."' AND status='1'";
		$rs = $db->query($que);
		if($rs->num_rows()>0)
		{
			$row = $rs->fetch_assoc();
                      //  $_SESSION['dream']['type']	= 'school';
			$_SESSION['dream']['code'] = $row["code"];
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function logout()
	{
		session_destroy();
		return true;
	}
	function insert(){
		global $db;
		$arrData				= $this->getArrData();
		$arrData["last_login"]	= date("Y-m-d H:i:s");	
		$arrData["date_added"]	= date("Y-m-d H:i:s");	
        unset($arrData['submit']);
		$rs = $db->query("SELECT * FROM ".TBL_SCHOOL." WHERE email like '".$arrData['email']."'");
	   	if ( $rs->num_rows() > 0 )
		{
			$rec = $rs->fetch_array();
			return "emailexist";
	    }
		else
		{
			$rs = $db->query($db->InsertQuery(TBL_SCHOOL,$arrData));
			if(is_object($rs))
			{	
				return "done";
			}
			else 
			{
				return false;
			}	
		}  
	}
	
	function update()
	{
		global $db;
		$arrData   = $this->getArrData();
		$id = $arrData['id'];
		unset($arrData['submit']);
		unset($arrData['id']);
		unset($arrData['edit']);
		$rs = $db->query($db->UpdateQuery(TBL_SCHOOL,$arrData,$id));
		if($rs)
			return true;
		else
			return false;	
	}

	function getRow($uId,$pw) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE id="'.$uId.'" AND password="'.$pw.'"');
        return $rs->fetch_array();
    }
	
	function DelRowContent($id)
	{	
		global $db;
		$rs = $db->query('DELETE FROM '.TBL_SCHOOL.' WHERE id='.$id);
		if($rs)
			return true;
		else
			return false;	
	}
	
	function GetRowContent($id)
	{	
		global $db;
		$rs = $db->GetRowById(TBL_SCHOOL,$id);
		return $rs->fetch_array();
	}
	
	function GetRowBycode($code) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_SCHOOL.' WHERE code="'.$code.'"');
        return $rs->fetch_array();
    }
	
	function getSearch($page=null,$record=null)
	{
		global $db;
		$resultrow=array();
		$i	= 0;
	    $rs = $db->SelectAll(TBL_SCHOOL,$page,$record);
		while($row = $rs->fetch_object())
		{
		  	$resultrow[$i++] = array('id'=>$row->id,
		  							 'name'=>$row->usename);  
		}
		if($resultrow)
		   	return $resultrow;
		else 
		   	return $row;
	}
	
	function ViewAll($page=null,$record=null)
	{
		global $db;
		$resultrow=array();
		$i	= 0;
	    $rs = $db->SelectAll(TBL_SCHOOL,$page,$record);
		while($row = $rs->fetch_array())
		{
		  	$resultrow[$i++] = $row;  
		}
		if($resultrow)
		   	return $resultrow;
		else 
		   	return $row;
	}
	
	function update_pwd() {
        global $db;
        $arrData = $this->getArrData();
        $id = $arrData['id'];
        unset($arrData['submit']);
        unset($arrData['submit1']);
        unset($arrData['oldPassword']);
        unset($arrData['Submit']);
        unset($arrData['id']);
        unset($arrData['edit']);
        unset($arrData['password4']);
        $rs = $db->query($db->UpdateQuery(TBL_USERS, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }

	function searchuser()
	{
		global $db;
		$resultrow	=	array();
        $arrData   = $this->getArrData();
		$i			=	0;
		$rs 		= 	$db->query("SELECT * FROM ".TBL_SCHOOL." WHERE username='".$arrData['username']."'");
		while($row = $rs->fetch_array())
		{
		  	$resultrow[$i++] = $row;  
		}
		if($resultrow)
		   	return $resultrow;
		else 
		   	return $row;
	}
	
	function searchusername()
	{
		global $db;
		$resultrow	=	array();
        $arrData   = $this->getArrData();
		$i			=	0;
		$rs 		= 	$db->query("SELECT * FROM ".TBL_SCHOOL." WHERE username='".$arrData['username']."'");
		while($row = $rs->fetch_array())
		{
		  	$resultrow[$i++] = $row;  
		}
		if($resultrow)
		   	return $resultrow;
		else 
		   	return $row;
	}
	
	function SelectAll()
	{
		global $db;
		$resultrow	=	array();
		$i			=	0;
	    $rs 		= 	$db->SelectAll(TBL_SCHOOL);
		/*return $rs;*/
		while($row = $rs->fetch_array())
		{
		  	$resultrow[$i++] = $row;  
		}
		if($resultrow)
		   	return $resultrow;
		else 
		   	return $row;
	}
	
	function maxid(){
		global $db;
		$i			=	0;
		$rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_SCHOOL);
		//$resultrow	=	array();
		while($row 	= 	$rs->fetch_array())
		{
		  	$result =$row;  
		}
		return $result['id'];
	}
	
	function changepassword()
	{
	    global $db;
		$resultrow=array();
		$data=array();
		$i	= 0;
		$arrData   = $this->getArrData();
		unset($arrData['Submit']);
		$sql = "SELECT * FROM ".TBL_SCHOOL." WHERE password='".$arrData["old_password"]."' and username like '" . $_SESSION["username"]. "'" ;
		$rs = $db->query($sql);
		if($rs->num_rows()>0)
		{
			$row = $rs->fetch_assoc();		
			$data['email']		= $row['email'];
			$data['password']	= $arrData["password"];
			$data['first_name']	= $row['first_name'];
			$data['last_name']	= $row['last_name'];
			$data['username']	= $row['username'];
			if ($this->updateuser($data))
			{
			 	//$this->emailpassword($data);
			 	return true;
			}
		}else
		 return false;
	} 
	
	function updateuser($data) {
		global $db;
		$sql = "UPDATE ".TBL_SCHOOL." SET password = '" . $data["password"]. "' WHERE username like '" . $data["username"]. "'" ;
		$rs = $db->query($sql);
		if($rs) {
			return true;
		} else {
			return false;
		}
	}
	
	function ForgotPassword($email) {
        global $db;
        $rs = $db->query("SELECT `password` FROM ".TBL_SCHOOL." WHERE `email`='$email'");
        return $rs->fetch_array();
    }
	
	// function forgotpassword()
	// {
	    // global $db;
		// $resultrow=array();
		// $data=array();
		// $i	= 0;
		// $arrData   = $this->getArrData();
		// unset($arrData['Submit']);
		// $sql = "SELECT * FROM ".TBL_SCHOOL." WHERE email='".$arrData["email"]."'";
		// $rs = $db->query($sql);
		// if($rs->num_rows()>0)
		// {
			// $row = $rs->fetch_assoc();
			// $data		= $row;
			// if($this->getpassword($data))
			// return true;
		// }
		// else
		 // return false;
	// } 
	
	function getpassword($data)
	{
		$objEmail = & load_class('Email');
		// Email to user.
		$objEmail->to		= $data['email'];
		$objEmail->bcc		= "nidhinbaby111@gmail.com";
		$objEmail->subject	= "Login Credentials - Journal 'Suvidya - Journal of Philosophy and Religion'";
		$objEmail->messageDearLine	= "Dear ";
		if($data["pref"] != "") {
			$objEmail->messageDearLine .= $data["pref"];
		}
		$objEmail->messageDearLine .= $data['first_name'] . " " . $data['last_name'] . ",";
		$objEmail->messageBody	.= 'Please find your login credentials to Journals as per your request.';
		$objEmail->messageBody	.= '<br>';
		$objEmail->messageBody	.= '&nbsp;&nbsp;&nbsp;&nbsp; User name:<b> '.$data['username'].'</b>';
		$objEmail->messageBody	.= '<br>';
		$objEmail->messageBody	.= '&nbsp;&nbsp;&nbsp;&nbsp; Password: <b> '.$data['password'].'</b>';
		$objEmail->sendTheEmail();
		return true;
	}
	
	function updatePassword($data) {
        global $db;
        $sql = "UPDATE " . TBL_SCHOOL . " SET password = '" . $data . "' WHERE username='admin'";
        $rs = $db->query($sql);
        if ($rs) {
            return true;
        } else {
            return false;
        }
    }		
	
	function generatePassword($length=9, $strength=0) {
		$vowels = 'aeuy';
		$consonants = 'bdghjmnpqrstvz';
		if ($strength & 1) {
			$consonants .= 'BDGHJLMNPQRSTVWXZ';
		}
		if ($strength & 2) {
			$vowels .= "AEUY";
		}
		if ($strength & 4) {
			$consonants .= '23456789';
		}
		if ($strength & 8) {
			$consonants .= '@#$%';
		}
		$password = '';
		$alt = time() % 2;
		for ($i = 0; $i < $length; $i++) {
			if ($alt == 1) {
				$password .= $consonants[(rand() % strlen($consonants))];
				$alt = 0;
			} else {
				$password .= $vowels[(rand() % strlen($vowels))];
				$alt = 1;
			}
		}
		return $password;
	}
}	// class user end
?>