<?php
class Contactaddress {
    var $name;
    var $settings;
    var $err;

    /// constructors

    function Contactaddress($err="") {
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

    function login() {
        global $db;
        $arrData   = $this->getArrData();
        //$que="SELECT * FROM " .TBL_CONTACT. " WHERE username='".$arrData["username"]."' AND password='".$arrData["password"]."' AND status='active'";
        $que="SELECT * FROM " .TBL_CONTACT_ADDRESS. " WHERE username='".$arrData["username"]."' AND password='".$arrData["password"]."'";
        $rs = $db->query($que);
        if($rs->num_rows()>0) {
            $row = $rs->fetch_assoc();
            $_SESSION['user_id'] 		= $row["id"];
            $_SESSION['username'] 		= $row["username"];
//			$_SESSION['last_login'] 	= $row["last_login"];		
            // Create teh last welcom message
            $welcome_message			= "Welcome ";
            $welcome_message			.= $row["username"] . ", &nbsp;&nbsp;&nbsp;&nbsp;";

            if($row["last_login"] != "0000-00-00 00:00:00") {
                $welcome_message		.= "Last login: &nbsp;&nbsp;".date("l, M j, Y h i A",strtotime($row["last_login"]));
            }
            $_SESSION['welcome_message'] = $welcome_message;

            // Update the last login date
            $que="UPDATE " .TBL_CONTACT_ADDRESS. " set last_login = now() WHERE id=".$_SESSION['user_id'] ."";
            $rs = $db->query($que);
            // Update Last Login
            return true;
        }
        else {
            return false;
        }
    }

    function logout() {
        session_destroy();
        return true;
    }
    function insert() {
        global $db;
        $arrData = $this->getArrData();
        $arrData["added_on"] = date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['Submit']);
        unset($arrData['con_password']);       
            $rs = $db->query($db->InsertQuery(TBL_CONTACT_ADDRESS,$arrData));
            if(is_object($rs)) {
                return "done";
            }
            else {
                return false;
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
        $rs = $db->query($db->UpdateQuery(TBL_CONTACT_ADDRESS,$arrData,$id));
        if($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM '.TBL_CONTACT_ADDRESS.' WHERE id='.$id);
        if($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_CONTACT_ADDRESS,$id);
        return $rs->fetch_array();
    }

    function getSearch($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_CONTACT_ADDRESS,$page,$record);
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
        $rs = $db->SelectAll(TBL_CONTACT_ADDRESS,$page,$record);
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectAll() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->SelectAll(TBL_CONTACT_ADDRESS);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
      function SelectAllFooter() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_CONTACT_ADDRESS.' WHERE footer_view="1"');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }


    function maxid() {
        global $db;
        $i			=	0;
        $rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_CONTACT_ADDRESS);

        while($row 	= 	$rs->fetch_array()) {
            $result =$row;
        }
        return $result['id'];
    }
}	// class user end
?>