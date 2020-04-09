<?php



class Articles {



    var $name;

    var $settings;

    var $err;



    /// constructors



    function Articles($err = "") {

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

        unset($arrData['parent_id']);

        unset($arrData['submenu']);

        unset($arrData['submit']);

        unset($arrData['Submit']);

        $rs = $db->query($db->InsertQuery(TBL_ARTICLE, $arrData));



        if (is_object($rs)) {

            return "done";

        } else {

            return false;

        }

    }



    function update($id) {

        global $db;

        $arrData = $this->getArrData();

        unset($arrData['parent_id']);

        unset($arrData['submit']);

        unset($arrData['Submit']);

        $rs = $db->query($db->UpdateQuery(TBL_ARTICLE, $arrData, $id));

        if ($rs)

            return true;

        else

            return false;

    }



    function DelRowContent($id) {

        global $db;

        $rs = $db->query('DELETE FROM ' . TBL_ARTICLE . ' WHERE id=' . $id);

        if ($rs)

            return true;

        else

            return false;

    }



    function GetRowContent($id) {

        global $db;

        $rs = $db->GetRowById(TBL_ARTICLE, $id);

        return $rs->fetch_array();

    }



    function GetRowContentByPageName($name) {

        global $db;

        $rs = $db->query("SELECT * FROM " . TBL_ARTICLE . " WHERE `title`='$name'");

        return $rs->fetch_array();

    }

	

	 function GetRowContentByMenu($mId) {

        global $db;

        $rs = $db->query("SELECT * FROM " . TBL_ARTICLE . " WHERE `menu_id`=".$mId);

        return $rs->fetch_array();

    }



    function getSearch($keyword) {

        global $db;

        $resultrow = array();

        $i = 0;

        $rs = $db->query("SELECT * FROM " . TBL_ARTICLE . " WHERE `title` LIKE '%$keyword%' OR `editor` LIKE '%$keyword%'");

        while ($row = $rs->fetch_array()) {

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

        $rs = $db->SelectAll(TBL_ARTICLE, $page, $record);

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

        $rs = $db->SelectAll(TBL_ARTICLE);

        /* return $rs; */

        while ($row = $rs->fetch_array()) {

            $resultrow[$i++] = $row;

        }

        if ($resultrow)

            return $resultrow;

        else

            return $row;

    }

function GetArticle() {

        global $db;

        $resultrow = array();

        $i = 0;

        $rs = $db->query("SELECT * FROM `" . TBL_ARTICLE . "` WHERE menu_id='10' ");

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

        $rs = $db->query('SELECT MAX(id) as id FROM ' . TBL_ARTICLE);



        while ($row = $rs->fetch_array()) {

            $result = $row;

        }

        return $result['id'];

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

    function getArticleInfo($article_id, $journal_id) {

        global $db;

        $sql_qry = "select * from " . TBL_ARTICLE . " where id =" . $article_id . " and journal_id =" . $journal_id . " ";

        $rs = $db->query($sql_qry);

        if ($rs->num_rows() > 0) {

            $records = $rs->fetch_array();

            return $records;

        } else {

            return false;

        }

    }



    function getArticlesByJournalId($journal_id) {

        global $db;

        $resultrow = array();



        $sql_qry = "select * from " . TBL_ARTICLE . " where journal_id =" . $journal_id . " Order By hits_count DESC , id";

        $rs = $db->query($sql_qry);



        while ($row = $rs->fetch_array()) {

            $resultrow[] = $row;

        }

        return $resultrow;

    }



    // Function to update hits

    function updateArticleHits($article_id) {

        global $db;

        $sql_qry = "UPDATE " . TBL_ARTICLE . " set hits_count = (hits_count + 1 ) where id =" . $article_id;

        $rs = $db->query($sql_qry);

        return true;

    }



}



// class Article end

?>