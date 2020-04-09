<?php

class News {

    var $name;
    var $settings;
    var $err;

    /// constructors

    function News($err = "") {
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

            $rs = $db->query($db->InsertQuery(TBL_NEWS, $arrData));
            if (is_object($rs)) {
                return "done";
            } else {
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
       
        $rs = $db->query($db->UpdateQuery(TBL_NEWS, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }

    function setRecommend($id) {
        global $db;
//        echo "UPDATE ".TBL_NEWS." SET recommend_status=1 WHERE id='".$id."'";
        $rs = $db->query("UPDATE " . TBL_NEWS . " SET recommend_status=1 WHERE id='" . $id . "'");
        if ($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM ' . TBL_NEWS . ' WHERE id=' . $id);
        if ($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_NEWS, $id);
        return $rs->fetch_array();
    }

    function GetRowContentByUn($un) {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_NEWS . ' WHERE username="' . $un . '"');
        return $rs->fetch_array();
    }

    function GetRowContentByUnPw($un, $pw) {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_NEWS . ' WHERE username="' . $un . '" AND password="' . $pw . '"');
        return $rs->fetch_array();
    }

    function GetRecommendedCompany() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_NEWS . "` WHERE recommend_status='1'");
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
        $rs = $db->query("SELECT * FROM `" . TBL_NEWS . "` order by id desc");
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
        $rs = $db->query('SELECT * FROM ' . TBL_NEWS . ' where login_status ="1"');
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
//        $rs = $db->query("SELECT c.* FROM `".TBL_NEWS."` c,`".TBL_ITEMS."` i WHERE i.category_id='$catId' AND i.comp_id=c.id ");
        $rs = $db->query("SELECT * FROM `" . TBL_NEWS . "` WHERE category_id='$catId' ORDER BY `id` DESC");
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
//        $rs = $db->query("SELECT c.* FROM `".TBL_NEWS."` c,`".TBL_ITEMS."` i WHERE i.category_id='$catId' AND i.comp_id=c.id AND c.`city`='$city'");
        $rs = $db->query("SELECT * FROM `" . TBL_NEWS . "` WHERE category_id='$catId' AND `city`='$city' ORDER BY `id` DESC");
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
        $rs = $db->query("SELECT * FROM `" . TBL_NEWS . "` WHERE `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
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
        $rs = $db->query("SELECT * FROM `" . TBL_NEWS . "` WHERE `city`='" . $city . "' AND `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
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
        $rs = $db->SelectAll(TBL_NEWS, $page, $record);
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
        $rs = $db->query("SELECT * FROM " . TBL_NEWS . " WHERE `title` LIKE '%$keyword%' OR `description` LIKE '%$keyword%'");
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
            $query = "SELECT * FROM " . TBL_NEWS." ORDER BY `id` DESC";
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
            $query= "SELECT * FROM " . TBL_NEWS . " WHERE  $condition ORDER BY `id` DESC";
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
        $rs = $db->SelectAll(TBL_NEWS, $page, $record);
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
        //$rs = $db->SelectAll(TBL_NEWS);
        $rs = $db->query("SELECT* FROM " . TBL_NEWS . " ORDER BY `news_date` DESC");

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
        $rs = $db->query("SELECT `password` FROM " . TBL_NEWS . " WHERE `username`='$userName' AND `email`='$email'");
        return $rs->fetch_array();
    }

    function maxid() {
        global $db;
        $i = 0;
        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_NEWS);

        while ($row = $rs->fetch_array()) {
            $result = $row;
        }
        return $result['id'];
    }

}

// class user end
?>