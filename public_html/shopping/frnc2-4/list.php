<?php
include("header_inner.php");
if(isset($_SESSION['dream'])){
	if($_SESSION['dream']['type']=='school' || isset($_SESSION['dream']['code'])){
		$school_dt = $objSchool->GetRowBycode($_SESSION['dream']['code']);
		$_GET['school_id'] = $school_dt['id'];
	}else if($_SESSION['dream']['type']=='corporate'){
		$_GET['corp_id'] = $_SESSION['dream']['user_id'];
	}
}
$GetAllItem = $objItem->SelectAll();
$GetAllGrade = $objGrade->SelectAll();
$ObjProduct->setArrData($_GET);
$product = $ObjProduct->getAdvancedSearchMin();

include("banner.php");
?>
<div class="pro-head">Direct Purchase</div>
	<div class="container">
		<div class="list-con">
			<div class="col-sm-3">
				<div class="list-sec">
					<form name="sort_pro" id="sort_pro" method="GET">
						<div class="fil-head">Filtrer par</div>
						<div class="listing-sec">
							<div class="listing-title">Nom de l'article</div>
							<select class="list-select" name="item" id="item">
								<option value="">Select Item Name</option>
							<?php foreach($GetAllItem as $item){?>
								<option value="<?php echo $item['id']; ?>" ><?php echo $item['title_frnc']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="listing-sec">
							<div class="listing-title">Le genre</div>
							<select class="list-select" name="gender" id="gender">
								<option value="">Select gender</option>
								<option value="boy">Boy</option>
								<option value="girl">Girl</option>
							</select>
						</div>
						<div class="listing-sec">
							<div class="listing-title">Qualité</div>
							<select class="list-select" name="grade" id="grade">
								<option value="">Select Grade</option>
							<?php foreach($GetAllGrade as $grade){ ?>
								<option value="<?php echo $grade['id']; ?>" ><?php echo $grade['title']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="list-sec-bt"><input type="submit" name="submit" value="SUBMIT"></div>
					</form>
				</div>
			</div>
			<div class="col-sm-9">
				<div class="clearfix">
				<?php 
					if($product){ $k=0;
						for($i=0;$i<count($product);$i++){ 
							if($k==4){echo '</div></div> <div class="col-sm-9"><div class="clearfix">'; $k=0; }?>
							<div class="col-sm-3">
								<div class="list-sub-in">
									<a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5"><img src="../multimedia/product/<?php echo $product[$i]['image']; ?>"></a>
									<div class="inlist-sec">
										<div><a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5"><?php echo $product[$i]['title_frnc']; ?></a></div>
										<div>AED <?php echo $product[$i]['price']; ?> | <a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5">BUY NOW</a></div>
									</div>
								</div>
							</div>
				<?php 	}
					}else{
						echo '<div class="no-results"><p class="h2">Aucun résultat trouvé</p><p>Sil vous plaît essayer de modifier votre recherche et essayez à nouveau.</p></div>';
					}?>
				</div>
			</div>
			</div>
		</div>
<?php include("footer_inner.php"); ?>