<?php
include("header_inner.php");
$pid = $_GET['pid'];
$product_dt = $ObjProduct->GetRowContent($pid);
$product_gal = $ObjProductGallery->GetRowContentByPid($pid);
$proone_color=$objPdtPrice->GetRowContentByproductid($pid);
$pro_color = $objPdtPrice->ColorAll($pid);
$price=$objPdtPrice->GetRowContentByproductid($pid);
$size_data = $objPdtPrice->sizeOnCol($pro_color[0]['color_id'],$_GET['pid']);
$size_chart = $objChart->GetRowContent($product_dt['item_id']);
include("banner.php");
?>
	<div class="pro-head">Description du produit</div>
	<div class="container">
		<div class="fea-marg">
			<div class="clearfix">
				<div class="pro-left col-sm-7 col-xs-12">
					<div>
						<div id="bigslider" class="flexslider">
							<ul class="slides">
							<?php for($i=0;$i<count($product_gal);$i++){
								echo '<li><img src="../multimedia/product_gal/'.$product_gal[$i]['thumb'].'"></li>';
							}?>
							</ul>
						</div>
						<div id="thumbslide" class="flexslider">
							<ul class="slides">
							<?php for($i=0;$i<count($product_gal);$i++){
								echo '<li><img src="../multimedia/product_gal/'.$product_gal[$i]['thumb'].'"></li>';
							}?>
							</ul>
						</div>
					</div>
				</div>
				<form id="purchase" method="post" action="action/cartaction.php">
					<input type="hidden" name="pid" id="pid" value="<?php echo $_GET['pid']; ?>"/>
					<div class="col-sm-5 inner-right">
						<div class="detail-block match-col">
							<div class="pro-title"><?php echo $product_dt['title_frnc'] ?></div>
							<input name="pid" id="pid" type="hidden" value="<?php echo $pid; ?>"/>
							<div class="shoe-qty clearfix">
								<span class="shoe-title">Code produit</span>
								: <label class="pricy-tag"><?php echo $product_dt['product_code']; ?></label>
							</div>
							<!--<div class="shoe-color">
								<span class="shoe-title">Choisissez la couleur</span>
								: 
								<?php 
									for($i=0;$i<count($pro_color);$i++){ $activ = "";
										if($i==0){$activ = 'activ';}
										$color = $objColor->GetRowContent($pro_color[$i]['color_id']);
									echo '<span class="scolor shoe-'.$color['title'].' '.$activ.'" id="'.$color['id'].'" onclick="select_col('.$color['id'].','.$pid.',this)" ></span>';
									}
								?>
								<input type="hidden" name="color_id" id="color_id" value="<?php echo $pro_color[0]['color_id']; ?>"/>
							</div>-->
							<input type="hidden" name="color_id" id="color_id" value="<?php echo $proone_color['color_id']; ?>"/>
							<div class="shoe-size">
								<span class="shoe-title"></span>
								<input class="meas-bt" type="button" value="How to Measure" data-toggle="modal" data-target="#sizeDis-modal">
								<input class="sizec-bt" type="button" value="Size Chart" data-toggle="modal" data-target="#sizeChr-modal">
							</div>
							<div class="shoe-size">
								<span class="shoe-title">Taille</span>
								: <select class="s-select size-select" name="size_id" id="size_id" onchange="selectprice(this.value,'<?php echo $pid;?>')"><!--onchange="select_siz(this.value,'<?php echo $pid;?>')"-->
									<option value="">Select Taille</option>
									<?php 
										for($i=0;$i<count($size_data);$i++){
											$size = $objSize->GetRowContent($size_data[$i]['size_id']);
											echo '<option value="'.$size['id'].'">'.$size['title_franch'].'</option>';
										}?>
								</select>
							</div>
							<!--<div class="shoe-width">
								<span class="shoe-title">Fabric</span>
								: <select class="s-select width-select" name="fabric_id" id="fabric_id" onchange="select_pric(this.value,'<?php echo $pid;?>')" >
									<option value="">Select Fabric</option>
								</select>
							</div>-->
							<div class="shoe-qty clearfix">
								<span class="shoe-title">Prix</span>
								: <label class="pricy-tag" id="price_val" >AED <?php echo $price['price'];/*$product_dt['price'];*/ ?></label>
								<input type="hidden" name="p_id" id="p_id"/>
								<input type="hidden" name="price" id="price"/>
								<input type="hidden" name="pname" value="<?php echo $product_dt['title_frnc'];?>" >
								<input type="hidden" name="image" value="<?php echo $product_dt['image'];?>" >
							</div>
							<div class="shoe-qty clearfix">
								<span class="shoe-title">Quantité</span>
								: <input class="ip-qty" type="text" name="quantity" id="quantity" value="" />
								<input class="btn-qty fa-input" type="submit" name="cart" value="&#xf07a; &nbsp;Ajouter au panier" />
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="tab-box">
		    <div class="tab-links">
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#tab1" role="tab" data-toggle="tab" aria-expanded="false"><h4 class="text-uppercase">La description</h4></a></li>
					<li><a href="#tab2" role="tab" data-toggle="tab" aria-expanded="true"><h4 class="text-uppercase">Produits connexes</h4></a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						<?php echo $product_dt['description_fnch'] ?>		    
					</div>
					<div class="tab-pane" id="tab2">
					<?php if($product_dt['related']!=""){?>
					<div class="row">
						<?php $rel_id = explode("/",$product_dt['related']);$k=0;
							for($i=0;$i<count($rel_id);$i++){ 
							$pro = $ObjProduct->GetRowContent($rel_id[$i]);
								if($k==4){echo '</div> <div class="row">'; $k=0; }?>
									<div class="col-sm-2">
										<div class="list-sub-in">
											<img src="../multimedia/product/<?php echo $pro['image']; ?>">
											<div class="inlist-sec">
												<div><a href="detail.php?pid=<?php echo $pro['id']; ?>"><?php echo $pro['title_frnc']; ?></a></div>
												<div>AED <?php echo $pro['price']; ?> | <a href="">BUY NOW</a></div>
											</div>
										</div>
									</div>
								<?php }?>
							</div>
					<?php }else{
						echo '<div class="no-results"><p>Aucun produits ont été trouvés </p></div>';
					}?>					
					</div>
					<div class="tab-pane" id="tab3">
						<form id="review" method="post">
							<input type="hidden" value="153" name="id"/>
							<div class="total-reviews">
								<div></div>
								<div></div>
								<div align="right">-</div>
							</div>
						</form>
					</div>
				</div>
		    </div>
		</div>
	</div>
<?php include("footer_inner.php"); ?>
<!--------------------------- Size Description----------------------->
<div class="modal fade" id="sizeDis-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>Taille description</h4><br>
			</div>
			<div class="modal-body">
				<div class="loginmodal-container">
					<?php echo $size_chart['description_frn'];  ?>
				</div>
			</div>
		</div>
    </div>
</div>
<!-------------------------- Size Chart---------------------------->
<div class="modal fade" id="sizeChr-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4>Tableau des tailles</h4><br>
			</div>
			<div class="modal-body">
				<div class="loginmodal-container">
					<img src="../multimedia/chart/<?php echo $size_chart['image']; ?>"/>
				</div>
			</div>
		</div>
    </div>
</div>
<!------------------------ Size end -------------------------------->
<script>
$("#purchase").validate({
	rules:
	{
		size_id:
		{
			required: true
		},
		fabric_id:
		{
			required: true
		},
		quantity:
		{
			required: true,
			number: true
		},
	},
	errorPlacement: function(error,element) {
		//element.attr('placeholder',error.text());
	}
});

function select_col(cid,pid,em){
	$('.scolor').removeClass('activ');
	$.ajax({
		type: "POST",
		url: "action/size.php",
		data:'c_id='+cid+'&pid='+pid,
		success: function(url) {
			$("#color_id").val(cid);
			$("#size_id").html(url);
		}
	});
	$('#'+cid).addClass('activ');
}
function select_siz(sid, pid){
	cid = $("#color_id").val();
	$.ajax({
		type: "POST",
		url: "action/fabric.php",
		data:'c_id='+cid+'&pid='+pid+'&sid='+sid,
		success: function(url) {
			$("#fabric_id").html(url);
		}
	});
}
function select_pric(fid, pid){
	cid = $("#color_id").val();
	sid = $("#size_id").val();
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "action/price.php",
		data:'c_id='+cid+'&pid='+pid+'&sid='+sid+'&fid='+fid,
		success: function(url) {
			$("#p_id").val(url.price_id);
			$("#price").val(url.price);
			$("#price_val").html('AED '+url.price);
		}
	});
}

function selectprice(sid, pid)
{
	$.ajax({
		type: "POST",
		dataType: 'json',
		url: "action/price_new.php",
		data:'sid='+sid+'&pid='+pid,
		success: function(url) {
			$("#p_id").val(url.price_id);
			$("#price").val(url.price);
			$("#price_val").html('AED '+url.price);
		}
	});	
}
</script>