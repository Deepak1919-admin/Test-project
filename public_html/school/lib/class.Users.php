<?php
session_start();
class Users {
    var $name;
    var $settings;
    var $err;

    /// constructors

    function Users($err="") {
        global $db;
        $this->err =$err;
    }

    function getArrData() {
        return $this->arrData;
    }

    function setArrData($szArrData) {
        $this->arrData = $szArrData;
    }

    function getFileArrData() {
        return $this->arrFileData;
    }

    function setFileArrData($szArrData) {
        $this->arrFileData = $szArrData;
    }

    function getErr() {
        return $this->err;
    }

    function setErr($szError) {
        $this->err .= " - <em>$szError</em>";
    }

     function login(){
echo "33";exit;

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

	

	echo $que="SELECT * FROM " .TBL_USERS. " WHERE email='".$arrData["email"]."' AND status=1 AND password='".$arrData["password"]."'";  exit;
	
        $rs = $db->query($que);
        if($rs->num_rows()>0){
            $row = $rs->fetch_assoc();
            $_SESSION['dream']['user_id'] = $row["id"];
            $_SESSION['dream']['name'] = $row["first_name"];
            $_SESSION['dream']['email'] = $row["email"];
	    $_SESSION['dream']['type']	= 'user';
	    $_SESSION['dream']['code']="LFIGP";
			
            // Update the last login date
            $que="UPDATE " .TBL_USERS. " set last_login = now() WHERE id=".$row["id"]."";
            $rs = $db->query($que);
            // Update Last Login
            return true;
        }
        else {
            return false;
        }
    }
	
	
	function insert(){
		global $db;
		$arrData				= $this->getArrData();
		$arrData["date_added"]	= date("Y-m-d H:i:s");	
		unset($arrData['submit']);
		unset($arrData['Submit']);
		unset($arrData['con_password']);
		unset($arrData['register']);
		$rs = $db->query("SELECT * FROM ".TBL_USERS." WHERE email like '".$arrData['email']."'");
		if ( $rs->num_rows() > 0 )
		{
			$rec = $rs->fetch_array();
			return "Emailexist";
		}
		else
		{
			$rs = $db->query($db->InsertQuery(TBL_USERS,$arrData));
			if(is_object($rs)){
				//$uid=$db->insert_id();
				//$_SESSION['dream']['user_id'] = $uid;
				//$_SESSION['dream']['email'] = $arrData["email"];
				//$_SESSION['dream']['type']	= 'user';
				// Update the last login date
				//$que="UPDATE " .TBL_USERS. " set last_login = now() WHERE id=".$uid."";
				//$res = $db->query($que);
				return "done";
			}else{
				return false;
			}
		}
	}

    function update() {
        global $db;
        $arrData   = $this->getArrData();

        $id = $arrData['id'];
        unset($arrData['submit']);
        unset($arrData['Submit']);
        unset($arrData['id']);
        unset($arrData['edit']);
        unset($arrData['con_password']);

        $rs = $db->query($db->UpdateQuery(TBL_USERS,$arrData,$id));
        if($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM '.TBL_USERS.' WHERE id='.$id);
        if($rs)
            return true;
        else
            return false;
    }

	function checkUser($email,$id='') {
        global $db;
        $arrData   = $this->getArrData();

        $rs = $db->query("SELECT * FROM " .TBL_USERS. " WHERE email='".$email."'  AND id!='".$id."' ");
        if($rs){
            $row  = $rs->fetch_assoc();
        }
        return $row;
    }
	
    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_USERS,$id);
        return $rs->fetch_array();
    }
    
    function GetRowContentByUn($un) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE username="'.$un.'"');
        return $rs->fetch_array();
    }
	
	function GetRowContentByEmail($email) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE email="'.$email.'"');
        return $rs->fetch_array();
    }
	function getRow($uId,$pw) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE id="'.$uId.'" AND password="'.$pw.'"');
        return $rs->fetch_array();
    }
    function GetRowContentByUnPw($un,$pw) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE username="'.$un.'" AND password="'.$pw.'"');
        return $rs->fetch_array();
    }
	
	function SelectAllnotAdmin(){
		global $db;
		$i	= 0;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE id!=1');
		while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
	}
	
	function SelectAllActive(){
		global $db;
		$i	= 0;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE id!=1 and status=1 ');
		while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
	}
	
    function getSearch($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_USERS,$page,$record);
        while($row = $rs->fetch_object()) {
            $resultrow[$i++] = array('id'=>$row->id,
                    'name'=>$row->usename);
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function ViewAll($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_USERS,$page,$record);
        while($row = $rs->fetch_array()) {
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

    function SelectAll() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->SelectAll(TBL_USERS);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }
	
	function SelectAllNew() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_USERS.' where new = 1');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectCatBySer($id) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_USERS.' where service_id = '.$id);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
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
    
    function GetOnlineUser() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_USERS.' where login_status ="1"');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function ForgotPassword($email) {
        global $db;
        $rs = $db->query("SELECT `password` FROM ".TBL_USERS." WHERE `email`='$email'");
        return $rs->fetch_array();
    }

    function maxid() {
        global $db;
        $i			=	0;
        $rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_USERS);

        while($row 	= 	$rs->fetch_array()) {
            $result =$row;
        }
        return $result['id'];
    }
}	// class user end
?>