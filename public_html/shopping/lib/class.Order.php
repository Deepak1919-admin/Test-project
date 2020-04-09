<?php
class Order {
    var $name;
    var $settings;
    var $err;

    /// constructors

    function Order($err="") {
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
        unset($arrData['submit']);
        unset($arrData['Submit']);
         unset($arrData['checkout']);
		  unset($arrData['paynow']);
		   unset($arrData['paylater']);
		  unset($arrData['fname']);
		   unset($arrData['lname']); 
		   unset($arrData['email']);
		    unset($arrData['city']);
			unset($arrData['country']); 
			unset($arrData['state']);
			unset($arrData['pin']);
			unset($arrData['phone']);
			unset($arrData['address']);
			 unset($arrData['fname2']);
		   unset($arrData['lname2']); 
		   unset($arrData['email2']);
		    unset($arrData['city2']);
			unset($arrData['country2']); 
			unset($arrData['state2']);
			unset($arrData['pin2']);
			unset($arrData['address2']);
			unset($arrData['phone2']);
			unset($arrData['yes']);
            $rs = $db->query($db->InsertQuery(TBL_ORDER,$arrData));
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

        $rs = $db->query($db->UpdateQuery(TBL_ORDER,$arrData,$id));
        if($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM '.TBL_ORDER.' WHERE id='.$id);
        if($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_ORDER,$id);
        return $rs->fetch_array();
    }
function SelectUserDetails($id) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where userid="'.$id.'"');
        /*return $rs;*/
		return $rs->fetch_array();
    }
function GetRowContentOid($id) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where order_id="'.$id.'"');

		return $rs->fetch_array();
    }
    function getSearchByPage($page=null,$record=null) {
        global $db;
        $resultrow=array();
        $i	= 0;
        $rs = $db->SelectAll(TBL_ORDER,$page,$record);
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
		//echo "SELECT * FROM " . TBL_ORDER . " WHERE `title` LIKE '%$keyword%' OR `description` LIKE '%$keyword%'";exit;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM " . TBL_ORDER . " WHERE `title` LIKE '%$keyword%' OR `description` LIKE '%$keyword%'");
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
        $rs = $db->query("SELECT * FROM `" . TBL_ORDER . "` order by id desc");
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
        $rs = $db->SelectAll(TBL_ORDER,$page,$record);
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
        $rs 		= 	$db->SelectAll(TBL_ORDER);
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function SelectOrder($id,$usertyp) {
        global $db;
        $resultrow	=	array();
        $i			=	0;
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where userid='.$id.' and user_type="'.$usertyp.'" ORDER BY `id` DESC');
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where status = "Paid"');
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where service_id = '.$id);
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where category_id = '.$id.' ORDER BY display_order');
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
        $rs 		= 	$db->query('SELECT * FROM '.TBL_ORDER.' where imgpos = "'.$pos.'" AND active="1"');
        /*return $rs;*/
        while($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if($resultrow)
            return $resultrow;
        else
            return $row;
    }

function FilterOrder() {
        global $db;
  $arrData = $this->getArrData();
        $resultrow = array();
        $i = 0;
		$condition="SELECT * FROM " . TBL_ORDER . " WHERE 1 ";
        
  if ($arrData['receipt'] != '') {
   $condition .= " AND order_id='" . $arrData['receipt'] . "'";
  }

  if ($arrData['shipno'] != '') {
   $condition .= " AND shipment_no ='" . $arrData['shipno'] . "'";
  }
  
  if ($arrData['phno'] != '') {
	   $condition .= " AND ship_phone ='" . $arrData['phno'] . "'";
  }
  
  if ($arrData['p_date'] != '') {
$pdate=date("d/m/Y",strtotime($arrData['p_date']));
   $condition .= " AND date ='" . $pdate . "'";
  }
  if ($arrData['school_id'] != '') {
   $condition .= " AND user_type='school' AND userid ='" . $arrData['school_id'] . "'";
  }
  if ($arrData['f_date'] != '' && $arrData['t_date'] ) {
$tdate=date("d/m/Y",strtotime($arrData['t_date']));
$fdate=date("d/m/Y",strtotime($arrData['f_date']));

   $condition .= " AND date <= '" . $tdate . "' AND date >=  '" . $fdate . "'";
  }
$condition.=" ORDER BY id DESC"; 
	// echo $condition; 
        $rs = $db->query($condition);
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row; 
    } 

function FilterSoldOrder() {
        global $db;
  $arrData = $this->getArrData();
        $resultrow = array();
        $i = 0;
	$condition="SELECT * FROM " . TBL_ORDER . " WHERE 1=1 ";
      
  
  if ($arrData['f_date'] != '' && $arrData['t_date']!='' ) {
$tdate=date("d/m/Y",strtotime($arrData['t_date']));
$fdate=date("d/m/Y",strtotime($arrData['f_date']));

   $condition .= " AND date <= '" . $tdate . "' AND date >=  '" . $fdate . "'";
  }
	// echo $condition; 
        $rs = $db->query($condition);
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row; 
    } 
  function generateorderid() {
		
        global $db;
//echo "Select * from tblorder where id = (select max(id) from tblorder)";
        $i			=	0;
        $rs 		= 	$db->query("Select * from tblorder where id = (select max(id) from tblorder)");

       return $rs->fetch_array();
    }
    function maxid() {
		
        global $db;
        $i			=	0;
        $rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_ORDER);

        while($row 	= 	$rs->fetch_array()) {
            $result =$row;
        }
        return $result['id'];
    }
    
   function changeorderstatus($status,$id)
    {
	global $db;
	$rs 		= 	$db->query("UPDATE ".TBL_ORDER." SET order_status='$status' WHERE id='$id'");
        if($rs)
            return true;
        else
            return false;
    }
}	// class user end
?>