<?php
class Corporate {
	var $name;
	var $settings;
	var $err;
	/// constructors
	function Corporate($err=""){
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
function clean_string( $value)
{
  if ( get_magic_quotes_gpc() )
   {
     $value = stripslashes( $value );
   }
   // escape things properly
   return mysql_real_escape_string( $value);
}
$arrData["email"]=clean_string($arrData["email"]);
$arrData["password"]=clean_string($arrData["password"]);

		
		$que="SELECT * FROM " .TBL_CORPORATE. " WHERE email='".$arrData["email"]."' AND password='".$arrData["password"]."' AND status='1'"; 
		$rs = $db->query($que);
		if($rs->num_rows()>0)
		{
			$row = $rs->fetch_assoc();
			unset($_SESSION['dream']);
			$_SESSION['dream']['user_id'] 		= $row["id"];
			$_SESSION['dream']['name'] 		= $row["name"];
			$_SESSION['dream']['email'] 		= $row["email"];	
			$_SESSION['dream']['type']			= 'corporate';

			
			// Update the last login date
			$que="UPDATE " .TBL_CORPORATE. " set last_login = now() WHERE id=".$_SESSION['dream']['user_id'] ."";
			$rs = $db->query($que);
			// Update Last Login	
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
		$rs = $db->query("SELECT * FROM ".TBL_CORPORATE." WHERE email like '".$arrData['email']."'");
	   	if ( $rs->num_rows() > 0 )
		{
			return "emailexist";	
	    }
		else
		{
			$rs = $db->query($db->InsertQuery(TBL_CORPORATE,$arrData));
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
		unset($arrData['private_seller' ]);
		if(($arrData['phone1']!='') && ($arrData['phone2']!='') && ($arrData['phone3']!=''))
		 $arrData['contact_no']	=	$arrData['phone1'].'-'.$arrData['phone2'].'-'.$arrData['phone3'];
			unset($arrData['phone1'])	;
			unset($arrData['phone2'])	;
			unset($arrData['phone3'])	;
		$rs = $db->query($db->UpdateQuery(TBL_CORPORATE,$arrData,$id));
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
		$rs = $db->query('DELETE FROM '.TBL_CORPORATE.' WHERE id='.$id);
		if($rs)
			return true;
		else
			return false;	
	}
	
	function GetRowContent($id)
	{	
		global $db;
		$rs = $db->GetRowById(TBL_CORPORATE,$id);
		return $rs->fetch_array();
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
	
	function getSearch($page=null,$record=null)
	{
		global $db;
		$resultrow=array();
		$i	= 0;
	    $rs = $db->SelectAll(TBL_CORPORATE,$page,$record);
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
	    $rs = $db->SelectAll(TBL_CORPORATE,$page,$record);
		while($row = $rs->fetch_array())
		{
		  	$resultrow[$i++] = $row;  
		}
		if($resultrow)
		   	return $resultrow;
		else 
		   	return $row;
	}
	
	function searchuser()
	{
		global $db;
		$resultrow	=	array();
        $arrData   = $this->getArrData();
		$i			=	0;
		$rs 		= 	$db->query("SELECT * FROM ".TBL_CORPORATE." WHERE username='".$arrData['username']."'");
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
		$rs 		= 	$db->query("SELECT * FROM ".TBL_CORPORATE." WHERE username='".$arrData['username']."'");
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
	    $rs 		= 	$db->SelectAll(TBL_CORPORATE);
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
		$rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_CORPORATE);
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
		$sql = "SELECT * FROM ".TBL_CORPORATE." WHERE password='".$arrData["old_password"]."' and username like '" . $_SESSION["username"]. "'" ;
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
			 	return true;
			}
		}else
		 return false;
	} 
	function updateuser($data) {
		global $db;
		$sql = "UPDATE ".TBL_CORPORATE." SET password = '" . $data["password"]. "' WHERE username like '" . $data["username"]. "'" ;
		$rs = $db->query($sql);
		if($rs) {
			return true;
		} else {
			return false;
		}
	}
	
	function ForgotPassword($email) {
        global $db;
        $rs = $db->query("SELECT `password` FROM ".TBL_CORPORATE." WHERE `email`='$email'");
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
		// $sql = "SELECT * FROM ".TBL_CORPORATE." WHERE email='".$arrData["email"]."'";
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
        $sql = "UPDATE " . TBL_CORPORATE . " SET password = '" . $data . "' WHERE username='admin'";
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