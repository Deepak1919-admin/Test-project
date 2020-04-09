<?php

class SocialMedia {

    var $name;
    var $settings;
    var $err;

    /// constructors

    function SocialMedia($err = "") {
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
//        $arrData["date_added"] = date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['Submit']);
        
            $rs = $db->query($db->InsertQuery(TBL_SOCIAL_MEDIA, $arrData));
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
       
        $rs = $db->query($db->UpdateQuery(TBL_SOCIAL_MEDIA, $arrData, $id));
        if ($rs)
            return true;
        else
            return false;
    }

    function setRecommend($id) {
        global $db;
//        echo "UPDATE ".TBL_SOCIAL_MEDIA." SET recommend_status=1 WHERE id='".$id."'";
        $rs = $db->query("UPDATE " . TBL_SOCIAL_MEDIA . " SET recommend_status=1 WHERE id='" . $id . "'");
        if ($rs)
            return true;
        else
            return false;
    }

    function DelRowContent($id) {
        global $db;
        $rs = $db->query('DELETE FROM ' . TBL_SOCIAL_MEDIA . ' WHERE id=' . $id);
        if ($rs)
            return true;
        else
            return false;
    }

    function GetRowContent($id) {
        global $db;
        $rs = $db->GetRowById(TBL_SOCIAL_MEDIA, $id);
        return $rs->fetch_array();
    }

    function GetMainSocialMedia() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SOCIAL_MEDIA . "` WHERE parent_id='0'");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    function ChangePosition($curPos,$chngPos){
        global $db;
        $rs = $db->query("UPDATE menu SET display_order =CASE
                        WHEN display_order=$curPos THEN $chngPos
                        WHEN display_order=$chngPos THEN $curPos
                      END
                    WHERE (display_order=$curPos OR display_order=$chngPos)");
        if ($rs)
            return true;
        else
            return false;
    }


    function GetSocialMediaByParentId($id) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SOCIAL_MEDIA . "` WHERE id='$id'");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    function GetAllSocialMedias() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SOCIAL_MEDIA . "` WHERE id>0 ORDER BY id DESC");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    

    function GetHeaderSocialMedia() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SOCIAL_MEDIA . "` WHERE parent_id='0' AND header_view='1' ORDER BY display_order");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }
    
    function GetFooterSocialMedia() {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SOCIAL_MEDIA . "` WHERE footer_view='1'");
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    
    function getSearch($page = null, $record = null) {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_SOCIAL_MEDIA, $page, $record);
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
        $rs = $db->SelectAll(TBL_SOCIAL_MEDIA, $page, $record);
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
        $rs = $db->SelectAll(TBL_SOCIAL_MEDIA);
        /* return $rs; */
        while ($row = $rs->fetch_array()) {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
            return $resultrow;
        else
            return $row;
    }

    function maxid() {
        global $db;
        $i = 0;
        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_SOCIAL_MEDIA);

        while ($row = $rs->fetch_array()) {
            $result = $row;
        }
        return $result['id'];
    }

}

// class user end
?>