<?php


class Country {


    var $name;


    var $settings;


    var $err;





    /// constructors





    function Country($err="") { 


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


        //$arrData["added_on"]	= date("Y-m-d H:i:s");


        unset($arrData['submit']);


        unset($arrData['Submit']);


        


            $rs = $db->query($db->InsertQuery(TBL_COUNTRY,$arrData));


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








        $id = $arrData['cid'];


        unset($arrData['submit']);


        unset($arrData['Submit']);


        unset($arrData['id']);


        unset($arrData['edit']);





        $rs = $db->query($db->SpUpdateQuery(TBL_COUNTRY,$arrData,$id,'cid'));


        if($rs)


            return true;


        else


            return false;


    }





    function DelRowContent($id) {


        global $db;


        $rs = $db->query('DELETE FROM '.TBL_COUNTRY.' WHERE id='.$id);


        if($rs)


            return true;


        else


            return false;


    }





    function GetRowContent($id) {


        global $db;


        //$rs = $db->GetRowById(TBL_COUNTRY,$id);


        $rs = $db->query("SELECT * FROM " . TBL_COUNTRY . " WHERE `id` = $id");


        return $rs->fetch_array();


    }





    function getSearchByPage($page=null,$record=null) {


        global $db;


        $resultrow=array();


        $i	= 0;


        $rs = $db->SelectAll(TBL_COUNTRY,$page,$record);


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


        $resultrow = array();


        $i = 0;


        $rs = $db->query("SELECT * FROM " . TBL_COUNTRY . " WHERE `title` LIKE '%$keyword%' OR `description` LIKE '%$keyword%'");


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


        $rs = $db->query("SELECT * FROM `" . TBL_COUNTRY . "` order by id desc");


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


        $rs = $db->SelectAll(TBL_COUNTRY,$page,$record);


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


        $rs 		= 	$db->SelectAll(TBL_COUNTRY);


        /*return $rs;*/


        while($row = $rs->fetch_array()) {


            $resultrow[$i++] = $row;


        }


        if($resultrow)


            return $resultrow;


        else


            return $row;


    }


     function SelectAllByOrder() {


         global $db;


        $resultrow = array();


        $i = 0;


        $rs = $db->query("SELECT * FROM `" . TBL_COUNTRY . "` ORDER BY display_order");


        while ($row = $rs->fetch_array()) {


            $resultrow[$i++] = $row;


        }


        if ($resultrow)


            return $resultrow;


        else


            return $row;


    }


       function SelectAllByOrderHome() {


         global $db;


        $resultrow = array();


        $i = 0;


        $rs = $db->query("SELECT * FROM `" . TBL_COUNTRY . "` WHERE `home` = '1' ORDER BY display_order");


        while ($row = $rs->fetch_array()) {


            $resultrow[$i++] = $row;


        }


        if ($resultrow)


            return $resultrow;


        else


            return $row;


    }











    function SelectActiveBanner() {


        global $db;


        $resultrow	=	array();


        $i			=	0;


        $rs 		= 	$db->query('SELECT * FROM '.TBL_COUNTRY.' where active = "1"');


        /*return $rs;*/


        while($row = $rs->fetch_array()) {


            $resultrow[$i++] = $row;


        }


        if($resultrow)


            return $resultrow;


        else


            return $row;


    }
function SelectcountryUK() {


        global $db;


        $resultrow  =   array();


        $i          =   0;


        $rs         =   $db->query('SELECT * FROM '.TBL_COUNTRY.' where id = "235"');

        return $rs->fetch_array();
        /*return $rs;*/


    }
function SelectcountryexceptUK() {


        global $db;


        $resultrow  =   array();


        $i          =   0;


        $rs         =   $db->query('SELECT * FROM '.TBL_COUNTRY.' where id != "235"');


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


        $rs 		= 	$db->query('SELECT * FROM '.TBL_COUNTRY.' where service_id = '.$id);


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


        $rs 		= 	$db->query('SELECT * FROM '.TBL_COUNTRY.' where imgpos = "'.$pos.'" AND active="1"');


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


        $rs 		= 	$db->query('SELECT MAX(id) as id FROM '.TBL_COUNTRY);





        while($row 	= 	$rs->fetch_array()) {


            $result =$row;


        }


        return $result['id'];


    }


    


    function ParrentCountry($country) 


    {


        global $db;


        $rs 		= 	$db->query('SELECT `title` FROM '.TBL_COUNTRY.' where cid = "'.$country.'"');


        $row 		= 	$rs->fetch_array();


        return $row;


    }


}	// class user end


?>