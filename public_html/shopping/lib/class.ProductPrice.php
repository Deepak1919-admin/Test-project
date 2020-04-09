<?php

class ProductPrice {

    var $name;
    var $settings;
    var $err;

    /// constructors

    function ProductPrice($err = "") {
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
        $arrData["date_added"] = date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['Submit']);
        unset($arrData['deletedimage']);
		unset($arrData['gallery']);
		unset($arrData['partNo']);
		$rs = $db->query($db->InsertQuery(TBL_PRODUCT_PRICE, $arrData));
		if (is_object($rs)) {
			return "done";
		} else {
			return false;
		}
    }
	
	function insertgalleryimage() {
        global $db;
        $arrData = $this->getArrData();
        $arrData["added_on"]	= date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['sid']);unset($arrData['tid']);unset($arrData['mid']);
        
            $rs = $db->query($db->InsertQuery(TBL_PRODUCT_PRICE,$arrData));
            if(is_object($rs)) {
                return "done";
            }
            else {
                return false;
            }
        
    }
    
    function update() {
        global $db;
        $arrData = $this->getArrData();
        $id = $arrData['id'];
        unset($arrData['submit']);
        unset($arrData['update']);
		unset($arrData['Submit']);
        unset($arrData['id']);
        unset($arrData['edit']);
		unset($arrData['deletedimage']);
		unset($arrData['gallery']);
		unset($arrData['partNo']);
        unset($arrData['thumb']);
		unset($arrData['partNo']);
		//echo $db->UpdateQuery(TBL_PRODUCT_PRICE, $arrData, $id);
        $rs = $db->query($db->UpdateQuery(TBL_PRODUCT_PRICE, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }

    
    function updateproductgallery($id) {
        global $db;
        $arrData = $this->getArrData();
        $arrData["added_on"]	= date("Y-m-d H:i:s");
        unset($arrData['submit']);
		unset($arrData['sid']);unset($arrData['tid']);unset($arrData['mid']);
        $rs = $db->query($db->UpdateQuery(TBL_PRODUCT_PRICE, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }
    
    
    function setRecommend($id) {
        global $db;
//        echo "UPDATE ".TBL_PRODUCT_PRICE." SET recommend_status=1 WHERE id='".$id."'";
        $rs = $db->query("UPDATE " . TBL_PRODUCT_PRICE . " SET recommend_status=1 WHERE id='" . $id . "'");
        if ($rs)
            return true;
        else
            return false;
    }
  function GetRowGallery($id) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE `product_id` = $id");
		$resultrow = array();
		$i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    function GetRowGalleryBydistentcolor($id) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE `product_id` = $id GROUP BY color");
		$resultrow = array();
		$i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

     function GetRowGalleryUsingColor($id) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE `product_id` = $id AND color!=0 AND stock!=0 GROUP BY color");  /*GROUP BY color*/
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
	function GetRowGalleryUsingSize($id,$size) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE `product_id` = $id AND `size`=$size AND stock!=0"); /*GROUP BY color*/
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

	function Colorgallery($id,$cid,$fid) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE  `product_id` = $id AND color=".$cid." ORDER BY id=".$fid." DESC");
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
	function ColorAll($id) {
        global $db;
        $rs = $db->query("SELECT DISTINCT color_id FROM " . TBL_PRODUCT_PRICE . " WHERE  `product_id` = ".$id);
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
	
	function sizeOnCol($cid, $pid){
		global $db;
        $rs = $db->query("SELECT DISTINCT size_id FROM " . TBL_PRODUCT_PRICE . " WHERE  `product_id` = ".$pid." and color_id=".$cid);
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
	}
	
	function fabricOnCol($cid, $pid, $sid){
		global $db;
        $rs = $db->query("SELECT DISTINCT fabric_id FROM " . TBL_PRODUCT_PRICE . " WHERE  `product_id` = ".$pid." and color_id=".$cid." and size_id=".$sid);
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
	}
	
	function priceOnCol($cid, $pid, $sid, $fid){
		global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE  `product_id` = ".$pid." and color_id=".$cid." and size_id=".$sid." and fabric_id=".$fid);
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
	}
	
	function priceOnsize($pid, $sid){
		global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE  `product_id` = ".$pid." and size_id=".$sid);
        $resultrow = array();
        $i=0;
         while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
	}
	
	
	
    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM ' . TBL_PRODUCT_PRICE . ' WHERE id=' . $id);
        if ($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_PRODUCT_PRICE, $id);
        return $rs->fetch_array();
    }

    function GetRowContentByUn($un) {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_PRODUCT_PRICE . ' WHERE username="' . $un . '"');
        return $rs->fetch_array();
    }

    

    
    function GetRowContentByproductid($pid) {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_PRODUCT_PRICE . ' WHERE product_id="' . $pid . '"');
        return $rs->fetch_array();
    }
    
    function GetRowContentBypid($id) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE product_id='".$id."'");
		
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` order by id desc");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
	function SelectAllNew() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE new_arrival=1 ORDER BY display_order_new");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    
    
    
    
		function SelectAllOffer() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE offer=1 order by id desc");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
	function SelectAllTopMen() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE top_men=1 ORDER BY display_order_men");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
	function SelectAllTopWomen() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE top_women=1 ORDER BY display_order_women");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
		function SelectAllMen() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='men' ORDER BY display_gender");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
			function SelectAllWomen() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='women' ORDER BY display_gender");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
        function ChangePositionMen($curPos,$chngPos)
    {
        global $db;
        $rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_order_men =CASE
                         WHEN display_order_men=$curPos THEN $chngPos
                         WHEN display_order_men=$chngPos THEN $curPos
                         END
                         WHERE (display_order_men=$curPos OR display_order_men=$chngPos)");
        if ($rs)
        return true;
        else
        return false;
    }
    
        function ChangePositionWomenen($curPos,$chngPos)
    {
        global $db;
        $rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_order_women =CASE
                         WHEN display_order_women=$curPos THEN $chngPos
                         WHEN display_order_women=$chngPos THEN $curPos
                         END
                         WHERE (display_order_women=$curPos OR display_order_women=$chngPos)");
        if ($rs)
        return true;
        else
        return false;
    }

        function ChangePositionnew($curPos,$chngPos)
    {
        global $db;
        $rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_order_new =CASE
                         WHEN display_order_new=$curPos THEN $chngPos
                         WHEN display_order_new=$chngPos THEN $curPos
                         END
                         WHERE (display_order_new=$curPos OR display_order_new=$chngPos)");
        if ($rs)
        return true;
        else
        return false;
    }
    
    
          function ChangePositionCategory($curPos,$chngPos,$id)
    {
        global $db;
        //$rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_order_cat =CASE
        //                 WHEN display_order_cat=$curPos THEN $chngPos
        //                 WHEN display_order_cat=$chngPos THEN $curPos
        //                 END
        //                 WHERE (display_order_cat=$curPos OR display_order_cat=$chngPos) AND id='$id'");
	 $rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_order_cat =$chngPos WHERE id=$id");
	
	
        if ($rs)
        return true;
        else
        return false;
    }
    
             function ChangePositionOnlyCategory($curPos,$chngPos,$id)
    {
        global $db;
        //$rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_only_cat =CASE
        //                 WHEN display_only_cat=$curPos THEN $chngPos
        //                 WHEN display_only_cat=$chngPos THEN $curPos
        //                 END
        //                 WHERE (display_only_cat=$curPos OR display_only_cat=$chngPos) AND id='$id'");
	
	$rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_only_cat =$chngPos WHERE id=$id");
        if ($rs)
        return true;
        else
        return false;
    }
    
                 function ChangePositiongender($curPos,$chngPos,$id)
    {
        global $db;
        //$rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_gender =CASE
        //                 WHEN display_gender=$curPos THEN $chngPos
        //                 WHEN display_gender=$chngPos THEN $curPos
        //                 END
        //                 WHERE (display_gender=$curPos OR display_gender=$chngPos)  AND id='$id'");
	$rs = $db->query("UPDATE `" . TBL_PRODUCT_PRICE . "` SET display_gender =$chngPos WHERE id=$id");
        if ($rs)
        return true;
        else
        return false;
    }
    
    
				function SelectAllKids() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='kids' ORDER BY display_gender");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
	function SelectAllByCat($gender,$catid) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='".$gender."' AND category_id='".$catid."' ORDER BY display_only_cat");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    function SelectAllgender($gender) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='".$gender."' ORDER BY display_gender");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
			function SelectAllRelated($gender,$catid,$id) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='".$gender."' AND category_id='".$catid."' AND id!=".$id."  order by id desc");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
   function SelectAllBySubCat($gender,$catid,$subcatid) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE gender='".$gender."' AND category_id='".$catid."' AND sub_category_id='".$subcatid."' ORDER BY display_order_cat");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
      

    
    function GetOnlineUser() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query('SELECT * FROM ' . TBL_PRODUCT_PRICE . ' where login_status ="1"');
        /* return $rs; */
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function GetCompanyByCatId($catId) {
        global $db;
        $resultrow = array();
        $i = 0;
//        $rs = $db->query("SELECT c.* FROM `".TBL_PRODUCT_PRICE."` c,`".TBL_ITEMS."` i WHERE i.category_id='$catId' AND i.comp_id=c.id ");
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE category_id='$catId' ORDER BY `id` DESC");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function GetCompanyByCatIdNCity($city, $catId) {
        global $db;
        $resultrow = array();
        $i = 0;
//        $rs = $db->query("SELECT c.* FROM `".TBL_PRODUCT_PRICE."` c,`".TBL_ITEMS."` i WHERE i.category_id='$catId' AND i.comp_id=c.id AND c.`city`='$city'");
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE category_id='$catId' AND `city`='$city' ORDER BY `id` DESC");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function GetCompanyByService($servId) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function GetCompanyByServiceNCity($servId, $city) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT_PRICE . "` WHERE `city`='" . $city . "' AND `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function getSearchByPage($page = null, $record = null) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_PRODUCT_PRICE, $page, $record);
        while ($row = $rs->fetch_object()) {
            $resultrow[$i++] = array('id' => $row->id,
                'name' => $row->usename);
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function getSearch($keyword) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE gender='$keyword' OR title LIKE '%" . $keyword. "%'" );
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function getAdvancedSearchMin($area, $city, $item, $catId) {
        global $db;
        $resultrow = array();
        $i = 0;
        $condition = '';

        if ($catId == '' && $item == '' && $city == '' && $area == '') {
            $query = "SELECT * FROM " . TBL_PRODUCT_PRICE." ORDER BY `id` DESC";
        } else {

            if ($catId != '') {
                $condition .= " AND category_id='" . $catId . "'";
            }

            if ($item != '') {
                $condition .= " AND name LIKE '%" . $item . "%'";
            }
//            if ($place != '') {
//                $condition .= " AND (city LIKE '%" . $place . "%' OR area LIKE '%" . $place . "%')";
//            }
            
            if ($city != '') {
                $condition.=" AND city LIKE '%" . $city . "%'";
            }
            if ($area != '') {
                $condition.=" AND area LIKE '%" . $area . "%'";
            }
            $condition = substr($condition, 5);
            $query= "SELECT * FROM " . TBL_PRODUCT_PRICE . " WHERE  $condition ORDER BY `id` DESC";
        }
//        echo $query;
        $rs = $db->query($query);
        while ($row = $rs->fetch_assoc()) {
            $resultrow[$i++] = $row;
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
        $rs = $db->SelectAll(TBL_PRODUCT_PRICE, $page, $record);
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
        //$rs = $db->SelectAll(TBL_PRODUCT_PRICE);
        $rs = $db->query("SELECT* FROM " . TBL_PRODUCT_PRICE . "");

        /* return $rs; */
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function ForgotPassword($userName, $email) {
        global $db;
        $rs = $db->query("SELECT `password` FROM " . TBL_PRODUCT_PRICE . " WHERE `username`='$userName' AND `email`='$email'");
        return $rs->fetch_array();
    }

    function maxid() {
        global $db;
        $i = 0;
        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_PRODUCT_PRICE);

        while ($row = $rs->fetch_array()) {
            $result = $row;
        }
        return $result['id'];
    }

}

// class user end
?>