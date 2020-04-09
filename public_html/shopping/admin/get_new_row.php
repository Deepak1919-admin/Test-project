<?php
include('../init.php');
$countpro = $_POST['imagecount'];
$objSize = load_class('Size');
$objFabric= load_class('Fabric');
$objColor= load_class('Color');

$GetAllSize = $objSize->SelectAll();
$GetAllFabric = $objFabric->SelectAll();
$GetAllColor = $objColor->SelectAll();
?>

<table width="100%" border="0" id="pdfTable" style="vertical-align:top;" class="table">
	<tr>
		<td class="col-sm-3">
			<div class="control-group">
				<select class="col-sm-6 form-control" name="pdt[color_id][<?php echo $countpro; ?>]" id="color_id">
					<option value="">Select Color</option>
			<?php for ($b = 0; $b < count($GetAllColor); $b++) {?>
					<option value="<?php echo $GetAllColor[$b]['id'] ?>"><?php echo $GetAllColor[$b]['title'] ?></option>
			<?php  }?>
				</select>
			</div>
		</td>
		<td class="col-sm-2">
			<div class="control-group">
				<select class="col-sm-6 form-control" name="pdt[size_id][<?php echo $countpro; ?>]" id="size_id">
					<option value="">Select Size</option>
			<?php for ($j = 0; $j < count($GetAllSize); $j++) {?>
					<option value="<?php echo $GetAllSize[$j]['id'] ?>"><?php echo $GetAllSize[$j]['title'] ?></option>
			<?php  }?>
				</select>
			</div>
		</td>
		<td class="col-sm-2">
			<div class="control-group">
				<select class="col-sm-6 form-control" name="pdt[fabric_id][<?php echo $countpro; ?>]" id="fabric_id">
					<option value="">Select Fabric</option>
			<?php for ($j = 0; $j < count($GetAllFabric); $j++) {?>
					<option value="<?php echo $GetAllFabric[$j]['id'] ?>"><?php echo $GetAllFabric[$j]['title'] ?></option>
			<?php  } ?>
				</select>
			</div>
		</td>
		<td class="col-sm-2"> 
			<div class="control-group">
				<input type="text" name="pdt[stock][<?php echo $countpro; ?>]" id="stock" class="form-control">
			</div>
		</td>
		<td class="col-sm-2"> 
			<div class="control-group">
				<input type="text" name="pdt[price][<?php echo $countpro; ?>]" id="price" class="form-control">
			</div>
		</td>
		<td class="col-sm-1"> 
			<div class="control-group">
				<a class="plus pull-right" href="javascript:void(0);" style="text-decoration:none; font-size:12px;" onclick="removeprdtrow(this);"><img src="img/minus.png" width="15px"/></a>
			</div>
		</td>
	</tr>
</table>