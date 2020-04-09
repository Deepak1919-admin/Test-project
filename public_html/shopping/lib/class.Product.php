<?php

class Product {

    var $name;
    var $settings;
    var $err;

    /// constructors

    function Product($err = "") {
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
	 unset($arrData['boy']);
	  unset($arrData['girl']);
		unset($arrData['gallery']);
		unset($arrData['partNo']);
		$rs = $db->query($db->InsertQuery(TBL_PRODUCT, $arrData));
		if (is_object($rs)) {
			return "done";
		} else {
			return false;
		} 
    }
	
	function insertgalleryimage() {
        global $db;
        $arrData = $this->getArrData();
        $arrData["date_added"]	= date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['parrent']);
        unset($arrData['category_id']);
		unset($arrData['title']);
    	unset($arrData['id']);
		unset($arrData['description']);
        unset($arrData['gender']);
        unset($arrData['sub_category_id']);
        unset($arrData['price']);
        unset($arrData['new_arrival']);
        unset($arrData['offer']);
        unset($arrData['image']);
        unset($arrData['top_men']);
        unset($arrData['top_women']);
		unset($arrData['offer_percentage']);
        unset($arrData['color_id']);
        unset($arrData['gallery']);
		unset($arrData['arb_title']);
		unset($arrData['arb_description']);
		unset($arrData['arb_washing']);
		unset($arrData['sku']);
		unset($arrData['washing']);
		unset($arrData['compactible_products']);
		unset($arrData['deletedimage']);
		unset($arrData['display_order_men']);
		unset($arrData['display_order_women']);
		unset($arrData['display_order_new']);
		unset($arrData['display_order_cat']);
		unset($arrData['display_only_cat']);
		unset($arrData['display_gender']);
		
        unset($arrData['sid']);unset($arrData['tid']);unset($arrData['mid']);
		$rs = $db->query($db->InsertQuery(TBL_PRODUCT_GALLERY,$arrData));
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
        unset($arrData['Submit']);
        unset($arrData['id']);
        unset($arrData['edit']);
		unset($arrData['deletedimage']);
		unset($arrData['gallery']);
		unset($arrData['partNo']);
		unset($arrData['stock']);
		unset($arrData['size']);
        unset($arrData['thumb']);
	unset($arrData['boy']);
	  unset($arrData['girl']);
		unset($arrData['color']);
		unset($arrData['proid']);
		unset($arrData['partNo']);
		//echo $db->UpdateQuery(TBL_PRODUCT, $arrData, $id);
        $rs = $db->query($db->UpdateQuery(TBL_PRODUCT, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }
	
    function updateproductgallery($id) {
        global $db;
        $arrData = $this->getArrData();
        $arrData["added_on"]	= date("Y-m-d H:i:s");
		$id = $arrData['proid'];
        unset($arrData['submit']);
		unset($arrData['proid']);
        unset($arrData['parrent']);
        unset($arrData['category_id']);
		unset($arrData['title']);
    	unset($arrData['id']);
		unset($arrData['description']);
        unset($arrData['gender']);
        unset($arrData['sub_category_id']);
        unset($arrData['price']);
        unset($arrData['new_arrival']);
        unset($arrData['offer']);
        unset($arrData['image']);
        unset($arrData['top_men']);
        unset($arrData['top_women']);
		unset($arrData['offer_percentage']);
        unset($arrData['color_id']);
        unset($arrData['gallery']);
		unset($arrData['arb_title']);
		unset($arrData['arb_description']);
		unset($arrData['arb_washing']);
		unset($arrData['sku']);
		unset($arrData['washing']);
		unset($arrData['compactible_products']);
		unset($arrData['deletedimage']);
		unset($arrData['display_order_men']);
		unset($arrData['display_order_women']);
		unset($arrData['display_order_new']);
		unset($arrData['display_order_cat']);
		unset($arrData['display_only_cat']);
		unset($arrData['display_gender']);
        unset($arrData['sid']);unset($arrData['tid']);unset($arrData['mid']);
        $rs = $db->query($db->UpdateQuery(TBL_PRODUCT_GALLERY, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }
    
    
    function setRecommend($id) {
        global $db;
        $rs = $db->query("UPDATE " . TBL_PRODUCT . " SET recommend_status=1 WHERE id='" . $id . "'");
        if ($rs)
            return true;
        else
            return false;
    }
  function GetRowGallery($id) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_GALLERY . " WHERE `product_id` = $id");
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
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_GALLERY . " WHERE `product_id` = $id GROUP BY color");
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
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_GALLERY . " WHERE `product_id` = $id AND color!=0 AND stock!=0 GROUP BY color");  /*GROUP BY color*/
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
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_GALLERY . " WHERE `product_id` = $id AND `size`=$size AND stock!=0"); /*GROUP BY color*/
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
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_GALLERY . " WHERE  `product_id` = $id AND color=".$cid." ORDER BY id=".$fid." DESC");
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
    
	function Colorgallerynew($id) {
        global $db;
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT_GALLERY . " WHERE  `product_id` = ".$id);
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
        $rs = $db->query('DELETE FROM ' . TBL_PRODUCT . ' WHERE id=' . $id);
        if ($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_PRODUCT, $id);
        return $rs->fetch_array();
    }

    function GetRowContentByUn($un) {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_PRODUCT . ' WHERE username="' . $un . '"');
        return $rs->fetch_array();
    }

    

    
    function GetRowContentByUnPw($un, $pw) {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_PRODUCT . ' WHERE username="' . $un . '" AND password="' . $pw . '"');
        return $rs->fetch_array();
    }
    
    function GetProductByCategory($id) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE category_id='".$id."'");
		
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` order by id desc");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE new_arrival=1 ORDER BY display_order_new");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE offer=1 order by id desc");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE top_men=1 ORDER BY display_order_men");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE top_women=1 ORDER BY display_order_women");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='men' ORDER BY display_gender");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='women' ORDER BY display_gender");
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
        $rs = $db->query("UPDATE `" . TBL_PRODUCT . "` SET display_order_men =CASE
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
        $rs = $db->query("UPDATE `" . TBL_PRODUCT . "` SET display_order_women =CASE
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
        $rs = $db->query("UPDATE `" . TBL_PRODUCT . "` SET display_order_new =CASE
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
		$rs = $db->query("UPDATE `" . TBL_PRODUCT . "` SET display_order_cat =$chngPos WHERE id=$id");
        if ($rs)
        return true;
        else
        return false;
    }
    
	function ChangePositionOnlyCategory($curPos,$chngPos,$id)
    {
        global $db;	
		$rs = $db->query("UPDATE `" . TBL_PRODUCT . "` SET display_only_cat =$chngPos WHERE id=$id");
        if ($rs)
        return true;
        else
        return false;
    }
    
	function ChangePositiongender($curPos,$chngPos,$id)
    {
        global $db;
		$rs = $db->query("UPDATE `" . TBL_PRODUCT . "` SET display_gender =$chngPos WHERE id=$id");
        if ($rs)
        return true;
        else
        return false;
    }
    
    
	function SelectAllKids() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='kids' ORDER BY display_gender");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='".$gender."' AND category_id='".$catid."' ORDER BY display_only_cat");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='".$gender."' ORDER BY display_gender");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='".$gender."' AND category_id='".$catid."' AND id!=".$id."  order by id desc");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE gender='".$gender."' AND category_id='".$catid."' AND sub_category_id='".$subcatid."' ORDER BY display_order_cat");
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
        $rs = $db->query('SELECT * FROM ' . TBL_PRODUCT . ' where login_status ="1"');
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE category_id='$catId' ORDER BY `id` DESC");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE category_id='$catId' AND `city`='$city' ORDER BY `id` DESC");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
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
        $rs = $db->query("SELECT * FROM `" . TBL_PRODUCT . "` WHERE `city`='" . $city . "' AND `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
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
        $rs = $db->SelectAll(TBL_PRODUCT, $page, $record);
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
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT . " WHERE gender='$keyword' OR title LIKE '%" . $keyword. "%'" );
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function getAdvancedSearchMin() {
        global $db;
        $resultrow = array();
		$arrData = $this->getArrData();
        $i = 0;
        $condition = '';
        if ($arrData['item'] == '' && $arrData['gender'] == '' && $arrData['grade'] == '' && $arrData['school_id'] == '' && $arrData['corp_id'] == '') {
			echo $query = "SELECT * FROM " . TBL_PRODUCT." ORDER BY `id` DESC";
        } else {
            if ($arrData['item'] != '') {
                $condition .= " AND item_id='" .$arrData['item']. "'";
            }
			
			if ($arrData['school_id'] != '') {
                $condition .= " AND school_id='" .$arrData['school_id']. "'";
            }
			
			if ($arrData['corp_id'] != '') {
                $condition .= " AND corporate='1'";
            }

            if ($arrData['grade'] != '') {
                //$condition .= " AND grade_id ='" . $arrData['grade'] . "'";
		 $condition .= " AND FIND_IN_SET(".$arrData['grade'].",grade_id)";
            }
            
            //if ($arrData['gender'] != '') {
            //   $condition.=" AND gender ='" . $arrData['gender'] . "'";
            //}
	     if ($arrData['gender'] != '') {
               $condition.=" AND gender LIKE'%" . $arrData['gender'] . "%'";
            }
			
            $condition = substr($condition, 5);
			$query= "SELECT * FROM " . TBL_PRODUCT . " WHERE  $condition ORDER BY `title` + 0";
        }
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
        $rs = $db->SelectAll(TBL_PRODUCT, $page, $record);
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
        $rs = $db->query("SELECT * FROM " . TBL_PRODUCT . " ORDER BY `id` DESC");
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
        $rs = $db->query("SELECT `password` FROM " . TBL_PRODUCT . " WHERE `username`='$userName' AND `email`='$email'");
        return $rs->fetch_array();
    }

    function maxid() {
        global $db;
        $i = 0;
        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_PRODUCT);

        while ($row = $rs->fetch_array()) {
            $result = $row;
        }
        return $result['id'];
    }

}

// class user end
?>