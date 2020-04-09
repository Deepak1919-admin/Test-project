<?php 
include('../init.php');
$id = $_POST['id'];
$objPdtPrice = load_class('ProductPrice');
$objSize = load_class('Size');
$objFabric= load_class('Fabric');
$objColor= load_class('Color');

$GetAllSize = $objSize->SelectAll();
$GetAllFabric = $objFabric->SelectAll();
$GetAllColor = $objColor->SelectAll();

$pdtPrice = $objPdtPrice->GetRowContent($id);

?>
<form class="form-horizontal" name="updt" id="updt" method="post" action="">
	<input type="hidden" name="id" value="<?php echo $id; ?>">
	<div class="form-group">
		<label class="control-label col-sm-4" for="username">Color:</label>
		<div class="col-sm-6">
			<select class="form-control" name="color_id" id="color_id">
				<option value="">Select Color</option>
			<?php for ($b = 0; $b < count($GetAllColor); $b++) {
					$select = "";
					if($GetAllColor[$b]['id'] == $pdtPrice['color_id']){
						$select = "selected";
					}?>
				<option <?php echo $select; ?> value="<?php echo $GetAllColor[$b]['id'] ?>"><?php echo $GetAllColor[$b]['title'] ?></option>
			<?php  }?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-4" for="username">Size:</label>
		<div class="col-sm-6">
			<select class="form-control" name="size_id" id="size_id">
				<option value="">Select Size</option>
			<?php for ($b = 0; $b < count($GetAllSize); $b++) {
					$select = "";
					if($GetAllSize[$b]['id'] == $pdtPrice['size_id']){
						$select = "selected";
					}?>
				<option <?php echo $select; ?> value="<?php echo $GetAllSize[$b]['id'] ?>"><?php echo $GetAllSize[$b]['title'] ?></option>
			<?php  }?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-4" for="username">Fabric:</label>
		<div class="col-sm-6">
			<select class="form-control" name="fabric_id" id="fabric_id">
				<option value="">Select Fabric</option>
			<?php for ($b = 0; $b < count($GetAllFabric); $b++) {
					$select = "";
					if($GetAllFabric[$b]['id'] == $pdtPrice['fabric_id']){
						$select = "selected";
					}?>
				<option <?php echo $select; ?> value="<?php echo $GetAllFabric[$b]['id'] ?>"><?php echo $GetAllFabric[$b]['title'] ?></option>
			<?php  }?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-4" for="stock">Stock:</label>
		<div class="col-sm-6">
			<input type="text" name="stock" id="stock" value="<?php echo $pdtPrice['stock']; ?>" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-4" for="price">Price:</label>
		<div class="col-sm-6">
			<input type="text" name="price" id="price" value="<?php echo $pdtPrice['price']; ?>" class="form-control">
		</div>
	</div>
	<div class="form-group">
		<label class="control-label col-sm-4" for="username"></label>
		<div class="col-sm-6">
			<input type="submit" name="update" class="login btn btn-primary loginmodal-submit" value="Submit">
		</div>
	</div>
</form>