<?php
include("header_inner.php");
$school_dt = $objSchool->GetRowBycode($_SESSION['dream']['code']);
$school_id = $school_dt['id'];
$school_gal = $objSchoolGal->GetRowContentByPid($school_id);
?>
		<div class="detail-ban"><img src="multimedia/school/<?php echo $school_dt['banner']; ?>"></div>
		<div class="container">
			<form class="form-horizontal" method="POST" action="" id="form1" enctype="multipart/form-data">
				<div class="prfl-text">
					<?php echo $school_dt['description']; ?>
				</div>
				<div class="prfl-head"><img src="multimedia/school/<?php echo $school_dt['banner2']; ?>"></div>
			</form>
		</div>
		<div class="gallery-bg">
			<div class="pro-head">Our Gallery</div>
				<div class="container">
					<div class="clearfix">
					<?php 
						if($school_gal){ $k=0;
							for($i=0;$i<count($school_gal);$i++){ 
								if($k==3){ $k=0; echo '</div><div class="clearfix">'; }
								echo '<div class="col-sm-4">
										<div class="gal-in">
											<a href="javascript:void(0);"><img src="multimedia/school_gal/'.$school_gal[$i]['image'].'"><a/>
										</div>
									</div>';
							}
						}
					?>
					</div>
				</div>
		</div>
<?php include("footer_inner.php"); ?>