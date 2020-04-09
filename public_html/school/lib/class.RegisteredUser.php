<?php

class RegisteredUser {

    var $name;
    var $settings;
    var $err;

    /// constructors

    function RegisteredUser($err = "") {
        global $db;
        $this->err = $err;
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
     function getRow($uId,$pw) {
        global $db;
        $rs = $db->query('SELECT * FROM '.TBL_USERS.' WHERE id="'.$uId.'" AND password="'.$pw.'"');
        return $rs->fetch_array();
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

    function login()
    {
        global $db;
        $arrData   = $this->getArrData();
		
         $que="SELECT * FROM   " .TBL_USERS. "  WHERE email='".$arrData["email"]."' AND password='".$arrData["password"]."' AND status='1'";
        $rs = $db->query($que);
        if($rs->num_rows()>0)
        {
        
                
            $row = $rs->fetch_assoc();
            if($row['status']==1)
            {
                
                $_SESSION['user']['user_id']       = $row["id"];
		$_SESSION['user']['email']       = $row["email"];
		$_SESSION['user']['name']       = $row["fname"];
              
                $welcome_message            = "Welcome ";
                $welcome_message            .= $row["fname"] . " &nbsp;&nbsp;&nbsp;&nbsp;";
    
                /*if($row["last_login"] != "0000-00-00 00:00:00")
                {
                   // $welcome_message        .= "Last login: &nbsp;&nbsp;".date("l, M j, Y h i A",strtotime($row["last_login"]));
                }*/
                $_SESSION['user']['welcome_message'] = $welcome_message;
    
                // Update the last login date
                $que="UPDATE " .TBL_USERS. " set last_login = now()  WHERE id=".$_SESSION['user']['user_id'] ."";
                $rs = $db->query($que);
                // Update Last Login
                return 1;
            }
            else{
                return 3;
            }
        }
        else
        {
            return 2;
        }
    }

    function insert() {
        global $db;
        $arrData                = $this->getArrData();
        $arrData["created_on"]  = date("Y-m-d H:i:s");
         //$arrData["status"] = 1;
        //$arrData["status"]      = "active";
        unset($arrData['register']);
        unset($arrData['Submit']);
        unset($arrData['con_password']);
        unset($arrData['password1']);
        $rs = $db->query("SELECT * FROM ".TBL_USERS." WHERE  email='".$arrData['email']."'");
        if ( $rs->num_rows() > 0) {
            $rec = $rs->fetch_array();
            if($rec["email"] == $arrData['email']) {
                return "nameexist";
            } else {
                return "nameexist";
            }
        }
        else {
            $rs = $db->query($db->InsertQuery(TBL_USERS,$arrData));
            if(is_object($rs)) {
                return "done";
            }
            else {
                return false;
            }
        }
    }

function SelectAllNew() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM " . TBL_USERS . " GROUP BY email  ORDER BY id DESC");
        /* return $rs; */
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
  
    function update() {
        global $db;
        $arrData = $this->getArrData();
        $id = $arrData['id'];
        unset($arrData['submit']);
        unset($arrData['submit1']);
        unset($arrData['Submit1']);
        unset($arrData['Submit']);
        unset($arrData['id']);
        unset($arrData['edit']);
        unset($arrData['con_password']);
         unset($arrData['cur_disp_pos']);
        $rs = $db->query($db->UpdateQuery(TBL_USERS, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM ' . TBL_USERS . ' WHERE id=' . $id);
        if ($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_USERS, $id);
        return $rs->fetch_array();
    }
  function ForgotPassword($email) {

        global $db;

        $rs = $db->query("SELECT `password` FROM ".TBL_USERS." WHERE  `email`='$email'");

        return $rs->fetch_array();

    }
	 function GetRowContentByUnPw($userid,$Password){
        global $db;
        $rs = $db->query("UPDATE ".TBL_USERS." SET password='".$Password."' WHERE id=$userid");
		
        if ($rs)
            return true;
        else
            return false;
    }
    function getSearch($page = null, $record = null) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_USERS, $page, $record);
        while ($row = $rs->fetch_object()) {
            $resultrow[$i++] = array('id' => $row->id,
                'name' => $row->usename);
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function ViewAll($page = null, $record = null) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_USERS, $page, $record);
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectAll() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_USERS);
        /* return $rs; */
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
 function ChangePosition($id,$chngPos){
        global $db;
        $rs = $db->query("UPDATE registeredusers SET status='$chngPos' WHERE id=$id");
		
        if ($rs)
            return true;
        else
            return false;
    }
    function maxid() {
        global $db;
        $i = 0;
        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_USERS);

        while ($row = $rs->fetch_array()) {
            $result = $row;
        }
        return $result['id'];
    }	
}

	
// class user end
?>