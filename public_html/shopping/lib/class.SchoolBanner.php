<?php
class SchoolBanner {    var $name;
    var $settings;
    var $err;
    /// constructors
    function SchoolBanner($err="") {
        global $db;
        $this->err =$err;    }
    function getArrData() {        return $this->arrData;    }
	function setArrData($szArrData) {        $this->arrData = $szArrData;    }
    function getFileArrData() {        return $this->arrFileData;    }
    function setFileArrData($szArrData) {
        $this->arrFileData = $szArrData;
    }

    function getErr() {
        return $this->err;
    }

    function setErr($szError) {
        $this->err .= " - <em>$szError</em>";
    }

    function insert() {
        global $db;
        $arrData = $this->getArrData();
        $arrData["added_on"]	= date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['Submit']);
        
            $rs = $db->query($db->InsertQuery(TBL_BANNER,$arrData));
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

        $rs = $db->query($db->UpdateQuery(TBL_BANNER,$arrData,$id));
        if($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM '.TBL_BANNER.' WHERE id='.$id);
        if($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_BANNER,$id);
        return $rs->fetch_array();
    }

    function getSearch($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_BANNER,$page,$record);
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
        $rs = $db->SelectAll(TBL_BANNER,$page,$record);
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
        $rs 		= 	$db->SelectAll(TBL_BANNER);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    function SelectCurrent($current) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_BANNER.' WHERE `menu_id` ='.$current.' AND active = "1"');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }


    function SelectActiveBanner() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_BANNER.' where active = "1"');
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_BANNER.' where service_id = '.$id);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }


function GetRowcontentbycid($id) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_BANNER.' where category_id = '.$id);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }


function GetAllHomeBanner() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_BANNER.' where category_id =0');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectBannerByPos($pos) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_BANNER.' where imgpos = "'.$pos.'" AND active="1"');
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
        $rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_BANNER);

        while($row 	= 	$rs->fetch_array()) {
            $result =$row;
        }
        return $result['id'];
    }
}	// class user end
?>