<?php
class OrderDetails {
    var $name;
    var $settings;
    var $err;

    /// constructors

    function OrderDetails($err="") {
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

    function insert() {
        global $db;
        $arrData = $this->getArrData();
        // $arrData["added_on"]	= date("Y-m-d H:i:s");
        $rs = $db->query($db->InsertQuery(TBL_ORDER_DETAILS,$arrData));
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

        $rs = $db->query($db->UpdateQuery(TBL_ORDER_DETAILS,$arrData,$id));
        if($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM '.TBL_ORDER_DETAILS.' WHERE id='.$id);
        if($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_ORDER_DETAILS,$id);
        return $rs->fetch_array();
    }
    function SelectOrderDetails($id) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where orderid="'.$id.'"');
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    function getSearchByPage($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_ORDER_DETAILS,$page,$record);
        while($row = $rs->fetch_object()) {
            $resultrow[$i++] = array('id'=>$row->id,
                'name'=>$row->usename);
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function getSearch($keyword) {
        global $db;
        //echo "SELECT * FROM " . TBL_ORDER_DETAILS . " WHERE `title` LIKE '%$keyword%' OR `description` LIKE '%$keyword%'";exit;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM " . TBL_ORDER_DETAILS . " WHERE `title` LIKE '%$keyword%' OR `description` LIKE '%$keyword%'");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function getLatest() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_ORDER_DETAILS . "` order by id desc");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
 function GetSoldPdt($pid) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where pid="'.$pid.'"');
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

function GetSoldPdtGroupBy($tdate,$fdate) {
        global $db;
        $resultrow = array();
        $i = 0; 
//echo "SELECT pid , SUM( quantity ) AS sum FROM ".TBL_ORDER_DETAILS." WHERE date_order <= '" . $tdate . "' AND date_order >=  '" . $fdate . "' GROUP BY pid";
       $rs = $db->query("SELECT pid , SUM( quantity ) AS sum FROM ".TBL_ORDER_DETAILS." WHERE date_order <= '" . $tdate . "' AND date_order >=  '" . $fdate . "' GROUP BY pid");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
function GetSoldPdtGroupByonly() {
        global $db;
        $resultrow = array();
        $i = 0; 
//echo "SELECT pid , SUM( quantity ) AS sum FROM ".TBL_ORDER_DETAILS." WHERE date_order <= '" . $tdate . "' AND date_order >=  '" . $fdate . "' GROUP BY pid";
       $rs = $db->query("SELECT pid , SUM( quantity ) AS sum FROM ".TBL_ORDER_DETAILS."  GROUP BY pid");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function ViewAll($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_ORDER_DETAILS,$page,$record);
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
        $rs 		= 	$db->SelectAll(TBL_ORDER_DETAILS);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectOrder($id) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where orderid='.$id.' ORDER BY `id` DESC');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }
    function SelectPaid() {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where status = "Paid"');
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where service_id = '.$id);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectProdByCat($id) {
        global $db;

        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where category_id = '.$id.' ORDER BY display_order');
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where imgpos = "'.$pos.'" AND active="1"');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }
function SelectQtySold($oid,$pid) {

        global $db;
        $resultrow	=	array();
        $i			=	0;
//echo 'SELECT * FROM '.TBL_ORDER_DETAILS.' where orderid= '.$oid.' AND pid ='.$pid;exit;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER_DETAILS.' where orderid= '.$oid.' AND pid ='.$pid);
        return $rs->fetch_array();
    }
    function maxid() {

        global $db;
        $i			=	0;
        $rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_ORDER_DETAILS);

        while($row 	= 	$rs->fetch_array()) {
            $result =$row;
        }
        return $result['id'];
    }

    function changeorderstatus($status,$id)
    {
        global $db;
        $rs 		= 	$db->query("UPDATE ".TBL_ORDER_DETAILS." SET order_status='$status' WHERE id='$id'");
        if($rs)
            return true;
        else
            return false;
    }
}	// class user end
?>