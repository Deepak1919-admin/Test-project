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
<div class="pro-head">COMMENDER EN LINGE</div>
	<div class="container">
		<div class="list-con">
			<div class="col-sm-3">
				<div class="list-sec">
					<form name="sort_pro" id="sort_pro" method="GET">
						<div class="fil-head">Filtrer par</div>
						<div class="listing-sec">
							<div class="listing-title">Ecole</div>
							<select class="list-select" name="grade" id="grade">
								<option value="">Sélectionnez année</option>
							<?php foreach($GetAllGrade as $grade){
								if( $grade['id']==$_GET['grade'])
								{
									$selected="selected";
								}
								else{
									$select="";
								}
								?>
								<option value="<?php echo $grade['id']; ?>" <?php echo $selected;?>><?php echo $grade['titl_french']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="listing-sec">
							<div class="listing-title">Genre</div>
							<select class="list-select" name="gender" id="gender">
								<option value="">Sélectionnez le sexe</option>
								<option value="boy" <?php if($_GET['gender']=="boy"){ echo "selected";}?>>Garçon</option>
								<option value="girl" <?php if($_GET['gender']=="girl"){ echo "selected";}?>>Fille</option>
							</select>
						</div>
						<div class="listing-sec">
							<div class="listing-title">Nom de l'article</div>
							<select class="list-select" name="item" id="item">
								<option value="">Sélectionnez Nom de l'article</option>
							<?php foreach($GetAllItem as $item){
								if( $item['id']==$_GET['item'])
								{
									$select="selected";
								}
								else{
									$select="";
								}
								?>
								?>
								<option value="<?php echo $item['id']; ?>" <?php echo $select;?>><?php echo $item['title_frnc']; ?></option>
							<?php } ?>
							</select>
						</div>
						
						
						<div class="list-sec-bt"><input type="submit" name="submit" value="SOUMETTRE"></div>
					</form>
				</div>
			</div>
			<div class="col-sm-9">
				<div class="clearfix">
				<?php 
					if($product){ $k=0;
						for($i=0;$i<count($product);$i++){ 
							if($k==4){echo '</div></div> <div class="col-sm-9"><div class="clearfix">'; $k=0; }?>
							<div class="col-lg-3 col-md-4 col-xs-6 ls-item">
								<div class="list-sub-in">
									<a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5"><img src="../multimedia/product/<?php echo $product[$i]['image']; ?>"></a>
									<div class="inlist-sec">
										<div><a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5"><?php echo $product[$i]['title_frnc']; ?></a></div>
										<div><!--AED <?php echo $product[$i]['price']; ?> |--> <a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5">BUY NOW</a></div>
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