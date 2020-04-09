<?php
class SchoolGal
{
    var $name;
    var $settings;
    var $err;
    /// constructors
    function SchoolGal($err = "")
    {
        global $db;
        $this->err = $err;
    }
    
    function getArrData()
    {
        return $this->arrData;
    }
    
    function setArrData($szArrData)
    {
        $this->arrData = $szArrData;
    }
    
    function getFileArrData()
    {
        return $this->arrFileData;
    }
    
    function setFileArrData($szArrData)
    {
        $this->arrFileData = $szArrData;
    }
    
    function getErr()
    {
        return $this->err;
    }
    
    function setErr($szError)
    {
        $this->err .= " - <em>$szError</em>";
    }
    
    function insert()
    {
        global $db;
        $arrData = $this->getArrData();
        $arrData["date_added"] = date("Y-m-d H:i:s");
        unset($arrData['submit']);
        unset($arrData['Submit']);
        $rs = $db->query($db->InsertQuery(TBL_SCHOOL_GAL, $arrData));
        if (is_object($rs))
        {
            return "done";
        } else {
            return false;
        }
    }
    
    function update()
    {
        global $db;
        $arrData = $this->getArrData();
        $id = $arrData['id'];
        unset($arrData['submit']);
        unset($arrData['Submit']);
        unset($arrData['id']);
        unset($arrData['edit']);
        $rs = $db->query($db->UpdateQuery(TBL_SCHOOL_GAL, $arrData, $id));
        if ($rs)
        return true;
        else
        return false;
    }
    
    function setRecommend($id)
    {
        global $db;
        $rs = $db->query("UPDATE " . TBL_SCHOOL_GAL . " SET recommend_status=1 WHERE id='" . $id . "'");
        if ($rs)
        return true;
        else
        return false;
    }
    
    function DelRowContent($id)
    {
        global $db;
        $rs = $db->query('DELETE FROM ' . TBL_SCHOOL_GAL . ' WHERE id=' . $id);
        if ($rs)
        return true;
        else
        return false;
    }
    
    function GetRowContent($id)
    {
        global $db;
        $rs = $db->GetRowById(TBL_SCHOOL_GAL, $id);
        return $rs->fetch_array();
    }
    
	function GetStockSum($pid)
    {
        global $db;
        //echo 'SELECT SUM( stock ) AS stock FROM ' . TBL_SCHOOL_GAL . ' WHERE product_id="' . $pid . '"';
         $rs = $db->query('SELECT SUM( stock ) AS stock FROM ' . TBL_SCHOOL_GAL . ' WHERE product_id="' . $pid . '"');
        return $rs->fetch_array();
    }
    
    function GetRowContentByUn($un)
    {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_SCHOOL_GAL . ' WHERE username="' . $un . '"');
        return $rs->fetch_array();
    }
    
    function GetRowContentByUnPw($un, $pw)
    {
        global $db;
        $rs = $db->query('SELECT * FROM ' . TBL_SCHOOL_GAL . ' WHERE username="' . $un . '" AND password="' . $pw . '"');
        return $rs->fetch_array();
    }
    
    function GetRowContentByPid($id)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query('SELECT * FROM ' . TBL_SCHOOL_GAL . ' WHERE school_id="' . $id .'"');
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function getLatest()
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SCHOOL_GAL . "` order by id desc");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function GetOnlineUser()
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query('SELECT * FROM ' . TBL_SCHOOL_GAL . ' where login_status ="1"');
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function GetCompanyByCatId($catId)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SCHOOL_GAL . "` WHERE category_id='$catId' ORDER BY `id` DESC");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function GetCompanyByCatIdNCity($city, $catId)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SCHOOL_GAL . "` WHERE category_id='$catId' AND `city`='$city' ORDER BY `id` DESC");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function SelectByPropertyId($id)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SCHOOL_GAL . "` WHERE product_id='$id'");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    //
    //   function SelectSizeByPropertyId($id)
    //{
    //    global $db;
    //    $resultrow = array();
    //    $i = 0;
    //    $rs = $db->query("SELECT DISTINCT size FROM `" . TBL_SCHOOL_GAL . "` WHERE product_id='$id'");
    //    while ($row = $rs->fetch_array())
    //    {
    //        $resultrow[$i++] = $row;
    //    }
    //    if ($resultrow)
    //    return $resultrow;
    //    else
    //    return $row;
    //}
    
        
       function SelectSizeByPropertyId($id)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT  * FROM `" . TBL_SCHOOL_GAL . "` WHERE product_id='$id' AND stock!='0' GROUP BY size");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    } /*GROUP BY size*/
    
       function SelectStockByPropertyId($size)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT stock FROM `" . TBL_SCHOOL_GAL . "` WHERE size='$size'");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function GetCompanyByServiceNCity($servId, $city)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->query("SELECT * FROM `" . TBL_SCHOOL_GAL . "` WHERE `city`='" . $city . "' AND `service_ids` LIKE '%," . $servId . ",%' ORDER BY id DESC");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function getSearch($page = null, $record = null)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_SCHOOL_GAL, $page, $record);
        while ($row = $rs->fetch_object())
        {
            $resultrow[$i++] = array('id' => $row->id,'name' => $row->usename);
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function getAdvancedSearchMin($area, $city, $item, $catId)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $condition = '';
        if ($catId == '' && $item == '' && $city == '' && $area == '')
        {
            $query = "SELECT * FROM " . TBL_SCHOOL_GAL." ORDER BY `id` DESC";
        } else {
            if ($catId != '')
            {
                $condition .= " AND category_id='" . $catId . "'";
            }
            if ($item != '')
            {
                $condition .= " AND name LIKE '%" . $item . "%'";
            }
            if ($city != '')
            {
                $condition.=" AND city LIKE '%" . $city . "%'";
            }
            if ($area != '')
            {
                $condition.=" AND area LIKE '%" . $area . "%'";
            }
            $condition = substr($condition, 5);
            $query= "SELECT * FROM " . TBL_SCHOOL_GAL . " WHERE  $condition ORDER BY `id` DESC";
            }
            $rs = $db->query($query);
            while ($row = $rs->fetch_assoc())
            {
                $resultrow[$i++] = $row;
            }
            if ($resultrow)
            return $resultrow;
            else
            return $row;
    }
    
    function ViewAll($page = null, $record = null)
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_SCHOOL_GAL, $page, $record);
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
    
    function SelectAll()
    {
        global $db;
        $resultrow = array();
        $i = 0;
        $rs = $db->SelectAll(TBL_SCHOOL_GAL);
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
     function SelectAllPartno()
    {
        global $db;
        $resultrow = array();
        $i = 0;
       $rs = $db->query("SELECT `partNo` FROM " . TBL_SCHOOL_GAL . "");
        while ($row = $rs->fetch_array())
        {
            $resultrow[$i++] = $row;
        }
        if ($resultrow)
        return $resultrow;
        else
        return $row;
    }
     function GetRowMaxpartno()
    {
        global $db;
        $rs = $db->query('SELECT MAX(partNo) AS partNo FROM '. TBL_SCHOOL_GAL);
        return $rs->fetch_array();
    }
    
    function ForgotPassword($userName, $email)
    {
        global $db;
        $rs = $db->query("SELECT `password` FROM " . TBL_SCHOOL_GAL . " WHERE `username`='$userName' AND `email`='$email'");
        return $rs->fetch_array();
    }
    
    function maxid()
    {
        global $db;
        $i = 0;
        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_SCHOOL_GAL);
        while ($row = $rs->fetch_array())
        {
            $result = $row;
        }
        return $result['id'];
        }
}
// class user end
?>