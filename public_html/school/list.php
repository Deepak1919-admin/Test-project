<?php
include("header_inner.php");

if(isset($_SESSION['dream'])){
	if($_SESSION['dream']['type']=='school' || $_SESSION['dream']['type']=='user' || isset($_SESSION['dream']['code'])){
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
<div class="pro-head">ORDER ONLINE</div>
	<div class="container">
		<div class="list-con">
			<div class="col-sm-3">
				<div class="list-sec">
					<form name="sort_pro" id="sort_pro" method="GET">
						<div class="fil-head">Filter By</div>
						<div class="listing-sec">
							<div class="listing-title">Grade</div>
							<select class="list-select" name="grade" id="grade">
								<option value="">Select Grade</option>
							<?php foreach($GetAllGrade as $grade){
								if( $grade['id']==$_GET['grade'])
								{
									$selected="selected";
								}
								else{
									$select="";
								}
								?>
								<option value="<?php echo $grade['id']; ?>" <?php echo $selected;?>><?php echo $grade['title']; ?></option>
							<?php } ?>
							</select>
						</div>
						<div class="listing-sec">
							<div class="listing-title">Gender</div>
							<select class="list-select" name="gender" id="gender">
								<option value="">Select gender</option>
								<option value="boy" <?php if($_GET['gender']=="boy"){ echo "selected";}?>>Boy</option>
								<option value="girl" <?php if($_GET['gender']=="girl"){ echo "selected";}?>>Girl</option>
							</select>
						</div>
						<div class="listing-sec">
							<div class="listing-title">Item Name</div>
							<select class="list-select" name="item" id="item">
								<option value="">Select Item Name</option>
							<?php
							
							foreach($GetAllItem as $item){
								if( $item['id']==$_GET['item'])
								{
									$select="selected";
								}
								else{
									$select="";
								}
								?>
							
								<option value="<?php echo $item['id']; ?>" <?php echo $select;?>><?php echo $item['title']; ?></option>
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
							<div class="col-lg-3 col-md-4 col-xs-6 ls-item">
								<div class="list-sub-in">
									<a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5"><img src="multimedia/product/<?php echo $product[$i]['image']; ?>"></a>
									<div class="inlist-sec">
										<div><a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5"><?php echo $product[$i]['title']; ?></a></div>
										<div><!--AED <?php echo $product[$i]['price']; ?> | --><a href="detail.php?pid=<?php echo $product[$i]['id']; ?>&mmid=5">BUY NOW</a></div>
									</div>
								</div>
							</div>
				<?php 	}
					}else{
						echo '<div class="no-results"><p class="h2">No Results Found</p><p>Please try to modify your search and try again.</p></div>';
					}?>
				</div>
			</div>
			</div>
		</div>
<?php include("footer_inner.php"); 
if($_GET['submit']!=""){
?>
<script>
$( document ).ready(function() {
 $('html,body').animate({
        scrollTop: $(".pro-head").offset().top},
        'slow');
});
</script>
<?php } ?>