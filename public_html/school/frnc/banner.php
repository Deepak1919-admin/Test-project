<?php
$mmid=$_GET['mmid'];
if($_GET['mmid']){
	if(isset($_SESSION['dream']['code'])){
		$school_dt = $objSchool->GetRowBycode($_SESSION['dream']['code']);
		$school_id = $school_dt['id'];
		$menubanner = $objInnBanner->Selectbymidsid($mmid, $school_id);
	}else{
		$menubanner = $objInnBanner->Selectbymidsid($mmid, 0);
	}
	echo '<div class="detail-ban"><img src="../multimedia/Innerbanner/'.$menubanner['image'].'"></div>';
}else{
	echo '<div class="detail-ban"><img src="../multimedia/banner/'.$menubanner['image'].'"></div>';
}
?>