<?php
include 'header.php';
$objItem= load_class('Item');
$objSize = load_class('Size');
$objFabric= load_class('Fabric');
$objColor= load_class('Color');
$ObjProduct= load_class('Product');
$objPdtPrice = load_class('ProductPrice');
$ObjProductGallery = load_class('ProductGallery');
$objGrade= load_class('Grade');
$objSchool = load_class('School');

$GetAllItem = $objItem->SelectAll();
$GetAllSize = $objSize->SelectAll();
$GetAllFabric = $objFabric->SelectAll();
$GetAllColor = $objColor->SelectAll();
$GetAllGrade = $objGrade->SelectAll();
$GetAllSchool = $objSchool->SelectAll();

//Create the Class Objects
$msg = "";
$log = "";
$getId = $_GET['id'];

if ($getId) {
    $action = 'edit';
} else {
	$action = 'add';
}

$upload_img_dir ="../multimedia/product/";
$upload_img_dir_gal ="../multimedia/product_gal/";

if(isset($_POST['update'])){
	$objPdtPrice->setArrData($_POST);
	$res = $objPdtPrice->update();
	if ($res == 'done'){
		$_SESSION['msg'] = "<div class='alert alert-success'>
						<button data-dismiss='alert' class='close' type='button'>x</button>
						<strong>Well done!</strong>  Product Stock added successfully.
					</div>";
		$log = "1";
	} else {
		$_SESSION['msg'] = "<div class='alert alert-error'>
						<button data-dismiss='alert' class='close' type='button'>�</button>
						<strong>Oh snap!</strong>Product Stock not added.
					</div>";
		$log = "1";
	} 
}

if (isset($_POST['submit'])){
    $grade="";
    for($i=0;$i<count($_POST['grade']);$i++)
    {
	$grade.=$_POST['grade'][$i].",";
    }
    $_POST['grade_id']=$grade;
    unset($_POST['grade']);

    $_POST['gender']=$_POST['boy'].",".$_POST['girl'];
	$price['pdt'] = $_POST['pdt'];
	unset($_POST['pdt']);
	$imagecount = $_POST['imagecount'];
	unset($_POST['imagecount']);
    if(isset($_POST['deletedpdt'])){

        foreach ($_POST['deletedpdt'] as $key=>$val){
            $res = $objPdtPrice->DelRowContent($key);

        }
    }
	if(isset($_POST['rlated_p'])){
		$_POST['related'] = implode("/",$_POST['rlated_p']);
	}
	unset($_POST['rlated_p']);
	if(!isset($_POST['corporate'])){
		$_POST['corporate']="0";
	}
    if (isset($_POST['id']) && $_POST['id'])
	{
		include('include/image.class.php');
		$img = new Zubrag_image;
        if (!empty($_FILES['thumb'])) {
            if (!is_dir($upload_img_dir)) {
                die("upload_files directory doesn't exist");
            }

            $temp_name = $_FILES['thumb']['tmp_name'];
            $file_name = $_FILES['thumb']['name'];
            $file_type = $_FILES['thumb']['type'];
            $file_size = $_FILES['thumb']['size'];
            $result = $_FILES['thumb']['error'];

            $real_name = strtolower($_FILES['thumb']['name']);
            
            // image type based on image file name extension:
            if (strstr($real_name, ".png")) {
                $image_type = "png";
            } else if (strstr($real_name, ".jpeg")) {
                $image_type = "jpeg";
            } else if (strstr($real_name, ".jpg")) {
                $image_type = "jpg";
            } else if (strstr($real_name, ".gif")) {
                $image_type = "gif";
            } else {
				
            }

            do {
                $up_file_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type; 
                $file_path = $upload_img_dir . $up_file_name;
            } while (file_exists($file_path));

            ini_set('memory_limit', '-1');

            // include image processing code

            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;


            // maximum thumb side size
            $max_x = 325;
            $max_y = 325;
			
            // cut image before resizing. Set to 0 to skip this.
            $cut_x = 0;
            $cut_y = 0;

            //upload image
            if (($temp_name == "")) {
                $log = 2;
                $msg = "You must fill all fields!";
            } else if (file_exists($file_path)) {
                $log = 2;
                $msg = "File name already exist";
            } else {
                // initialize
                $img->max_x = $max_x;
                $img->max_y = $max_y;
                $img->cut_x = $cut_x;
                $img->cut_y = $cut_y;
                $img->quality = $image_quality;
                $img->save_to_file = $save_to_file;
                $img->image_type = $image_type;

                //generate thumbnail
                $img->GenerateThumbFile($temp_name, $upload_img_dir . $up_file_name);

                $_POST['image'] = $up_file_name;
            }
        }
        
        $ObjProduct->setArrData($_POST);
        $res = $ObjProduct->update($_POST['id']);
        $Insert_id=$_POST['id'];
		//======insert pdt_price table=====================
		for($k1=0;$k1<=$imagecount;$k1++) {
			if ($price['pdt']['size_id'][$k1] != "") {
				$pdtarray = array();
				$pdtarray['product_id'] = $Insert_id;
				$pdtarray['size_id'] = $price['pdt']['size_id'][$k1];
				$pdtarray['color_id'] = $price['pdt']['color_id'][$k1];
				$pdtarray['fabric_id'] = $price['pdt']['fabric_id'][$k1];
				$pdtarray['price'] = $price['pdt']['price'][$k1];
				$pdtarray['stock'] = $price['pdt']['stock'][$k1];
				$y = $objPdtPrice->setArrData($pdtarray);
				$respdt = $objPdtPrice->insert();
			}
		}

		if (!empty($_FILES['image'])) {
            
			for($k = 0;$k < count($_FILES['image']['name']); $k++) {
                if (!is_dir($upload_img_dir_gal)){
                    die("upload_img_dir directory doesn't exist");
                }
                $temp_name = $_FILES['image']['tmp_name'][$k];
                $file_name = $_FILES['image']['name'][$k];
                $file_type = $_FILES['image']['type'][$k];
                $file_size = $_FILES['image']['size'][$k];
                $result = $_FILES['image']['error'][$k];
                $real_name = strtolower($_FILES['image']['name'][$k]);
                // image type based on image file name extension:
                if (strstr($real_name, ".png")) 
                {
                    $image_type = "png";
                }
                else if (strstr($real_name, ".jpeg")) 
                {
                    $image_type = "jpeg";
                } 
                else if (strstr($real_name, ".jpg")) 
                {
                    $image_type = "jpg";
                } 
                else if (strstr($real_name, ".gif")) 
                {
                 $image_type = "gif";
                } 
                else 
                {
                }
                do 
                {
                    $up_img_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
                    $file_path = $upload_img_dir_gal . $up_img_name;
                } 
                while (file_exists($file_path));
                ini_set('memory_limit', '-1');
                // include image processing code
                $save_to_file = true;
                $image_quality = 300;
                $image_type = -1;
                // maximum thumb side size
				
                $max_x = 500;
                $max_y = 500;
				
                // cut image before resizing. Set to 0 to skip this.
                $cut_x = 0;
                $cut_y = 0;
    
                //upload image
                if (($temp_name == "")) 
                {
                    $log = 2;
                    $msg = "You must fill all fields!";
                } 
                else if (file_exists($file_path)) 
                {
                    $log = 2;
                    $msg = "File name already exist";
                } 
                else 
                {
                    // initialize
                    $img->max_x = $max_x;
                    $img->max_y = $max_y;
                    $img->cut_x = $cut_x;
                    $img->cut_y = $cut_y;
                    $img->quality = $image_quality;
                    $img->save_to_file = $save_to_file;
                   $img->image_type = $image_type;
                   // generate thumbnail
                    $img->GenerateThumbFile($temp_name, $upload_img_dir_gal . $up_img_name);
                    $imagearray['thumb'] = $up_img_name;
                    $imagearray['product_id']=$Insert_id;
                    $ObjProductGallery->setArrData($imagearray);
                    $imageout = $ObjProductGallery->insert();
                     
				}
			}
		}
        //empty end here
            $_SESSION['msg'] = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong>  Product modified successfully.
                    </div>";
        $log = "1";       
	} //empty id ennd here
	else
	{
		include('include/image.class.php');

		$img = new Zubrag_image;
        if (!empty($_FILES['thumb'])) {
			if (!is_dir($upload_img_dir)) {
				die("upload_files directory doesn't exist");
			}

			$temp_name = $_FILES['thumb']['tmp_name'];
			$file_name = $_FILES['thumb']['name'];
			$file_type = $_FILES['thumb']['type'];
			$file_size = $_FILES['thumb']['size'];
			$result = $_FILES['thumb']['error'];

			$real_name = strtolower($_FILES['thumb']['name']);
				
			// image type based on image file name extension:
			if (strstr($real_name, ".png")) {
				$image_type = "png";
			} else if (strstr($real_name, ".jpeg")) {
				$image_type = "jpeg";
			} else if (strstr($real_name, ".jpg")) {
				$image_type = "jpg";
			} else if (strstr($real_name, ".gif")) {
				$image_type = "gif";
			} else {
				//echo "<script>alert('Unsupported image type')</script>";
			}
			do {
				$up_file_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
				$file_path = $upload_img_dir . $up_file_name;
			} while (file_exists($file_path));

			ini_set('memory_limit', '-1');

			// include image processing code

			$save_to_file = true;
			$image_quality = 100;
			$image_type = -1;


			// maximum thumb side size
			$max_x = 325;
			$max_y = 325;

			// cut image before resizing. Set to 0 to skip this.
			$cut_x = 0;
			$cut_y = 0;

			//upload image
			if (($temp_name == "")) {
				$log = 2;
				$msg = "You must fill all fields!";
			} else if (file_exists($file_path)) {
				$log = 2;
				$msg = "File name already exist";
			} else {
                // initialize
				$img->max_x = $max_x;
				$img->max_y = $max_y;
				$img->cut_x = $cut_x;
				$img->cut_y = $cut_y;
				$img->quality = $image_quality;
				$img->save_to_file = $save_to_file;
				$img->image_type = $image_type;

					// generate thumbnail
				$img->GenerateThumbFile($temp_name, $upload_img_dir . $up_file_name);

				$_POST['image'] = $up_file_name;
			}
		}
        
		$ObjProduct->setArrData($_POST);
		$res = $ObjProduct->insert();
		$Insert_id=mysql_insert_id();
//======insert pdt_price table=====================
		for($k1=0;$k1<=$imagecount;$k1++) {
			if ($price['pdt']['size_id'][$k1] != "") {
				$pdtarray = array();
				$pdtarray['product_id'] = $Insert_id;
				$pdtarray['size_id'] = $price['pdt']['size_id'][$k1];
				$pdtarray['color_id'] = $price['pdt']['color_id'][$k1];
				$pdtarray['fabric_id'] = $price['pdt']['fabric_id'][$k1];
				$pdtarray['price'] = $price['pdt']['price'][$k1];
				$pdtarray['stock'] = $price['pdt']['stock'][$k1];
				$y = $objPdtPrice->setArrData($pdtarray);
				$respdt = $objPdtPrice->insert();
			}
		}
		
		if (!empty($_FILES['image'])) {
			for($k = 0;$k < count($_FILES['image']['name']); $k++) {
				if (!is_dir($upload_img_dir_gal)) {
					die("upload_img_dir directory doesn't exist");
				}
				$temp_name = $_FILES['image']['tmp_name'][$k];
				$file_name = $_FILES['image']['name'][$k];
				$file_type = $_FILES['image']['type'][$k];
				$file_size = $_FILES['image']['size'][$k];
				$result = $_FILES['image']['error'][$k];
				$real_name = strtolower($_FILES['image']['name'][$k]);
				// image type based on image file name extension:
				if (strstr($real_name, ".png")) 
				{
					$image_type = "png";
				}
				else if (strstr($real_name, ".jpeg")) 
				{
					$image_type = "jpeg";
				} 
				else if (strstr($real_name, ".jpg")) 
				{
					$image_type = "jpg";
				} 
				else if (strstr($real_name, ".gif")) 
				{
					$image_type = "gif";
				} 
				else 
				{
				}
				do 
				{
					$up_img_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
					$file_path = $upload_img_dir_gal . $up_img_name;
				} 
				while (file_exists($file_path));
				ini_set('memory_limit', '-1');
				// include image processing code
				$save_to_file = true;
				$image_quality = 300;
				$image_type = -1;
				// maximum thumb side size
					
				$max_x = 500;
				$max_y = 500;
					// cut image before resizing. Set to 0 to skip this.
				$cut_x = 0;
				$cut_y = 0;
				//upload image
				if (($temp_name == "")) 
				{
					$log = 2;
					$msg = "You must fill all fields!";
				} 
				else if (file_exists($file_path)) 
				{
					$log = 2;
					$msg = "File name already exist";
				} 
				else
				{
					// initialize
					$img->max_x = $max_x;
					$img->max_y = $max_y;
					$img->cut_x = $cut_x;
					$img->cut_y = $cut_y;
					$img->quality = $image_quality;
					$img->save_to_file = $save_to_file;
					$img->image_type = $image_type;
					// generate thumbnail
					$img->GenerateThumbFile($temp_name, $upload_img_dir_gal . $up_img_name);
					$imagearray['thumb'] = $up_img_name;
					$imagearray['product_id']=$Insert_id;
					$ObjProductGallery->setArrData($imagearray);
					$imageout = $ObjProductGallery->insert();
				}
			}
		}

		if ($res == 'done')
		{
			$_SESSION['msg'] = "<div class='alert alert-success'>
                            <button data-dismiss='alert' class='close' type='button'>x</button>
                            <strong>Well done!</strong>  Product added successfully.
                        </div>";
			$log = "1";
		}
		else
		{
			$_SESSION['msg'] = "<div class='alert alert-error'>
                            <button data-dismiss='alert' class='close' type='button'>�</button>
                            <strong>Oh snap!</strong>Product not added.
                        </div>";
			$log = "1";
		}  
	}
}
$row = array();
    
if (isset($getId))
{
	$row = $ObjProduct->GetRowContent($getId);
	$row2 = $ObjProductGallery->GetRowContentByPid($getId);
	$row3 = $objPdtPrice->GetRowContentBypid($getId);
	
	$rowgraidid=explode(',', $row['grade_id']);
}
$getallProduct = $ObjProduct->SelectAll();
	//$row4 = $ObjProduct->SelectAllMain();
?>

<link href="css/summernote.css" rel="stylesheet">
<link href="css/summernote-bs3.css" rel="stylesheet">
<div class="page-content">
<!-- begin PAGE TITLE ROW -->
	<div class="row">
		<div class="col-lg-12">
			<div class="page-title">
				<h1><?php echo ucfirst($action) ?> 
					<small>Product</small>
				</h1>
				<ol class="breadcrumb">
					<li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
					<li><i class="fa fa-edit"></i>  <a href="view_product.php">Product</a></li>
					<li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Product</a></li>
				</ol>
			</div>
		</div>
		<!-- /.col-lg-12 -->
	</div>
	<div class="row">
	<!-- Validation States -->
		<div class="col-lg-12">
			<?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>
				<div class="portlet portlet-default">
					<div class="portlet-heading">
						<div class="portlet-title">
							<h4><?php echo ucfirst($action) ?> Product</a></h4>
						</div>
						<div class="portlet-widgets">
							<a data-toggle="collapse" data-parent="#accordion" href="#validationStates"><i class="fa fa-chevron-down"></i></a>
						</div>
						<div class="clearfix"></div>
					</div>
					<div id="validationStates" class="panel-collapse collapse in">
						<div class="portlet-body">
							<form class="form-horizontal" method="POST" action="" id="form1" enctype="multipart/form-data">
								<input type="hidden" name="id" value="<?php echo $getId ?>">
								<div class="form-group">
									<label class="col-sm-2 control-label">Item</label>
                                    <div class="col-sm-10">
										<select class="form-control" id="item_id" name="item_id" >
											<option value="">Select</option>
                                            <?php foreach($GetAllItem as $item){ 
													if($row['item_id']==$item['id']){
														$sele="selected";
                                                    }else{
                                                        $sele="";
                                                    }?>
											<option value="<?php echo $item['id']; ?>" <?php echo $sele; ?>><?php echo $item['title']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
										
								<div class="form-group">
									<label class="col-sm-2 control-label">School</label>
                                    <div class="col-sm-10" id="subdiv">
										<select class="form-control" id="school_id" name="school_id">
											<option value="0">Common</option>
                                            <?php foreach($GetAllSchool as $school){ 
                                                    if($row['school_id']==$school['id']){
                                                        $sele="selected";
                                                    }else{
                                                        $sele="";
                                                    }?>
											<option value="<?php echo $school['id']; ?>" <?php echo $sele; ?>><?php echo $school['name']; ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-sm-2 control-label">Grade</label>
                                    <div class="col-sm-10" id="subdiv">
										<!--<select class="form-control" id="grade_id" name="grade_id">
											<option value="">Select</option>-->
                                            <?php foreach($GetAllGrade as $grade){
						if (in_array($grade['id'],$rowgraidid))
						    {
							$checked="checked";
						    }
						    else
						    {
							$checked="";
						    }
                                                    //if($row['grade_id']==$grade['id']){
                                                    //    $sele="selected";
                                                    //}else{
                                                    //    $sele="";
                                                    //}?>
											<!--<option value="<?php echo $grade['id']; ?>" <?php echo $sele; ?>><?php echo $grade['title']; ?></option>-->
											<input type="checkbox" name="grade[]" value="<?php echo $grade['id']; ?>" <?php echo $checked;?>> <?php echo $grade['title']; ?>&nbsp;&nbsp;&nbsp;
											<?php } ?>
										<!--</select>-->
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Gender</label>
									<div class="col-sm-10" id="subdiv">
										<!--<select class="form-control" id="gender" name="gender">
											<option value="">Select</option>
											<option value="boy" <?php  if($row['gender']=='boy'){ echo "selected"; } ?>>Boy</option>
											<option value="girl" <?php  if($row['gender']=='girl'){ echo "selected"; } ?>>Girl</option>
										</select>-->
										<?php
										$box3=explode(",",$row['gender']);
										
										if($box3[0]=="boy")
										{
										    $selectboy="checked";
										}
										else{
										    $selectboy="";
										}
										if($box3[1]=="girl")
										{
										    $selectgirl="checked";
										}
										else{
										    $selectgirl="";
										}
										?>
										<div style="display:inline-block; margin:0px 2px;"><span style="margin:0px 8px;">Boy</span><input type="checkbox" name="boy" value="boy" class="" <?php echo $selectboy;?>></div>
										   <div style="display:inline-block;margin:0px 2px;"><span style="margin:0px 8px;">Girl</span><input type="checkbox" name="girl" value="girl" class="" <?php echo $selectgirl;?>></div>
									</div>
								</div>
								<div class="clearfix">
									<div class="form-group">
										<label class="col-sm-2 control-label">Product Name</label>
                                        <div class="col-sm-10">
											<input type="text" class="form-control" name="title" value="<?php disp_var($row['title']); ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Product Name french</label>
                                        <div class="col-sm-10">
											<input type="text" class="form-control" name="title_frnc" value="<?php disp_var($row['title_frnc']); ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Product Name Arabic</label>
                                        <div class="col-sm-10">
											<input type="text" class="form-control" name="title_arb" value="<?php disp_var($row['title_arb']); ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Product Code</label>
                                        <div class="col-sm-10">
											<input type="text" class="form-control" name="product_code" value="<?php disp_var($row['product_code']); ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Product Price</label>
                                        <div class="col-sm-10">
											<input type="text" class="form-control" name="price" value="<?php disp_var($row['price']); ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Description</label>
                                        <div class="col-sm-10">
											<input type="hidden" name="description" id="bbb" value="">
											<div class="summernote" id="summernote"><?php echo $row['description']; ?></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Description French</label>
                                        <div class="col-sm-10">
											<input type="hidden" name="description_fnch" id="ccc" value="">
											<div class="summernote" id="summernote1"><?php echo $row['description_fnch']; ?></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Description Arabic</label>
                                        <div class="col-sm-10">
											<input type="hidden" name="description_arb" id="ddd" value="">
											<div class="summernote" id="summernote2"><?php echo $row['description_arb']; ?></div>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-2 control-label">Image (325W * 325H)</label>
                                        <div class="col-sm-10">
											<input type="file" class="" id="" name="thumb">
										</div>
									</div>
									<?php if($row['image']!=""){?>
												<div>
													<img src="../multimedia/product/<?php echo $row['image']; ?>" width="75">
												</div><br>
										<?php }?>  
									<div class="form-group">
										<label class="col-sm-2 control-label">Corporate</label>
										<div class="col-sm-10">
											<input type="checkbox" class="" id="corporate" name="corporate" value="1" <?php if($row['corporate']=='1'){ echo "checked"; } ?>>
										</div>
									</div>
									<div class="panel panel-default clearfix">
										<div class="panel-heading">Size And Stock</div>
										<div class="panel-body">
											<div class="">
                                            <?php  $i=0; ?>
												<div id="imagediv" class="table-responsive">
													<table width="100%" border="0" id="pdfTable" style="vertical-align:top;" class="table">
														<tr>
															<td class="col-sm-3">
																<div class="control-group"><label>Color</label>
																	<div class="">
																		<select class="col-sm-6 form-control" name="pdt[color_id][0]" id="color_id">
																			<option value="">Select Color</option>
																	<?php for ($b = 0; $b < count($GetAllColor); $b++) {?>
																			<option value="<?php echo $GetAllColor[$b]['id'] ?>"><?php echo $GetAllColor[$b]['title'] ?></option>
																	<?php  }?>
																		</select>
																	</div>
																</div>
															</td>
															<td class="col-sm-2">
																<div class="control-group"><label>Size</label>
																	<div class="">
																		<select class="col-sm-6 form-control" name="pdt[size_id][0]" id="size_id">
																			<option value="">Select Size</option>
																	<?php for ($j = 0; $j < count($GetAllSize); $j++) { ?>
																			<option value="<?php echo $GetAllSize[$j]['id'] ?>"><?php echo $GetAllSize[$j]['title'] ?></option>
																	<?php  } ?>
																		</select>
																	</div>
																</div>
															</td>
															<td class="col-sm-2">
																<div class="control-group"><label>Fabric</label>
																	<div class="">
																		<select class="col-sm-6 form-control" name="pdt[fabric_id][0]" id="fabric_id">
																			<option value="">Select Fabric</option>
																	<?php for ($j = 0; $j < count($GetAllFabric); $j++) {?>
																			<option value="<?php echo $GetAllFabric[$j]['id'] ?>"><?php echo $GetAllFabric[$j]['title'] ?></option>
																	<?php  }?>
																		</select>
																	</div>
																</div>
															</td>
															<td class="col-sm-2"> 
																<div class="control-group">
																	<label>Stock</label>
																	<div class="">
																		<input type="text" name="pdt[stock][0]" id="stock" class="form-control">
																	</div>
																</div>
															</td>
															<td class="col-sm-2"> 
																<div class="control-group">
																	<label>Price </label>
																	<div class="">
																		<input type="text" name="pdt[price][0]" id="price" class="form-control">
																	</div>
																</div>
															</td>
															<td class="col-sm-1"> 
																<div class="control-group">
																	<label>  </label>
																	<a href="javascript:void(0);" class="plus pull-right" onclick="addprdtrow();" ><img src="img/add.png" /></a>
																</div>
															</td>
														</tr>
													</table>
												</div>
												<input type="hidden"  id="imagecount" name="imagecount"  value="<?php echo $i ?>">
					<?php if($getId){?>
						<div id="deletedpdt">
							<table id="example-table1" class="table table-striped table-bordered table-hover table-green">
								<thead>
									<tr>
										<th>Color</th>
										<th>Size</th>
                                        <th>Fabric</th>
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php for($i=0;$i<count($row3);$i++){?>
										<tr>
											<td>
												<?php 
													$getColor = $objColor->GetRowContent($row3[$i]['color_id']);
													echo $getColor['title'];
												?>
											</th>
											<td>
												<?php 
													$getSize = $objSize->GetRowContent($row3[$i]['size_id']);
													echo $getSize['title'];
												?>
											</th>
											<td>
												<?php 
													$getFabric = $objFabric->GetRowContent($row3[$i]['fabric_id']);
													echo $getFabric['title'];
												?>
											</th>
											<td><?php echo $row3[$i]['stock']; ?></th>
											<td><?php echo $row3[$i]['price']; ?></th>
											<td>
												<a  href="javascript:void(0);" data-toggle="modal" data-target="#update-modal" onclick="updateStk(<?php echo $row3[$i]['id']; ?>);"><i class="fa fa-edit"></i></a>
												&nbsp;&nbsp;|&nbsp;&nbsp;												
												<a  href="javascript:void(0);" onclick="delStock('<?php echo $row3[$i]['id']; ?>')"> <i class="fa fa-times"></i></a>
											</td>
										</tr>
								<?php }?>
								</tbody>
							</table>
					<?php }?>
						</div>
					</div>
				</div>
			<div class="panel panel-default clearfix">
										<div class="panel-heading">Additional Images</div>
											<div class="panel-body">
												<div class="control-group" id="fields">
													<label class="control-label col-sm-2" for="field1">Images (500 W * 500 H)</label>
													<div class="imagesClass form-group  col-xs-10"> 
														<div class="entry2  input-group">
															<input class="" name="image[]" type="file" />
															<span class="input-group-btn">
																<button class="btn btn-success btn-add press" type="button">
																	<span class="glyphicon glyphicon-plus"></span>
																</button>
															</span>
														</div>
													</div>
												</div>
										<div class="control-group" id="fields">
										<?php
											if($getId!=""){
												if($row2!=""){
													foreach($row2 as $imgs){?>
													<div class="col-sm-2" for="">
														<div class="s_<?php echo $imgs['id']; ?>">
															<img src="../multimedia/product_gal/<?php echo $imgs['thumb']; ?>" width="100" height="75"/>&nbsp; &nbsp; &nbsp;
															<span>
																<a href="javascript:void(0);" onclick="deleteImg(this.id)" id="<?php echo $imgs['id']; ?>"><i class="fa fa-trash"></i></a>
															</span>
														</div></br>
													</div>
												<?php }
												}
											}?>
										</div> 
									</div>
								</div>						
								<div class="panel panel-default clearfix">
									<div class="panel-heading">Related Product</div>
									<div class="panel-body">
									<?php $rel_id = explode("/",$row['related']);
										for($m=0;$m<count($getallProduct);$m++){
											$chek = "";
											if(in_array($getallProduct[$m]["id"], $rel_id)){ $chek = 'checked'; }
											echo '<div class="control-group col-sm-4" id="fields">
													<input type="checkbox" '.$chek.' name="rlated_p[]" value="'.$getallProduct[$m]["id"].'">
													&nbsp;<label class="control-label" for="field1">'.$getallProduct[$m]["title"].'</label>
												</div>';
										  } ?>
									</div>
								</div>
										
							</div><br />
							
							<div class="form-group clearfix">
								<div class="col-sm-12">
									<input type="submit" name="submit" class="btn btn-default pull-right" value="Submit">
                                    <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
								</div>
							</div>              
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="update-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="loginmodal-container">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h3>Update Stock</h3><br>
				</div>
				<div class="modal-body" id="upade_data">
				</div>
				<div class="modal-footer">
					<div id="mail_alert"></div>
				</div>
            </div>
        </div>
    </div>
</div>
<?php include("footer.php"); ?>
<script src="js/summernote.min.js"></script>
<script>

function addprdtrow(){
	var imagecount=parseInt(document.getElementById('imagecount').value)+1;
	$('#imagecount').val(imagecount);
	dataString = "imagecount="+imagecount;
	$.ajax({
		type: "POST",
		url: "get_new_row.php",              
		data: dataString,                             
		success: function(msd)
		{  
			$('#imagediv').append(msd);
		}
	});
	// $("input:checkbox, input:radio, input:file").not('[data-no-uniform="true"],#uniform-is-ajax').uniform();
	// $('[data-rel="chosen"],[rel="chosen"]').chosen();
}

function removeprdtrow(elm){
	var tr = $(elm).closest('table');
	tr.remove();
}
</script>
         
<script type="text/javascript">
function delStock(id, delForm){
	$.ajax({
		type: "POST",
		url: "dlete_stok.php",              
		data: 'id='+id,                             
		success: function(msd) {  
			if(msd==1){
				location.reload();
			}
		}
	});
}
$(document).ready(function () {
	$('#form1').validate({
		ignore: [],
		rules: { 
			title: {
				required: true
			},
			editor: {
				required: true
			}
		},
		messages: {
			parent_id: "<i class='fa fa-warning'></i> This field is required.",
			title: "<i class='fa fa-warning'></i> This field is required.",
			editor: "<i class='fa fa-warning'></i> This field is required."
		},
		highlight: function(element) {
			$(element).closest('.form-group').addClass('has-error');
		},
		unhighlight: function(element) {
			$(element).closest('.form-group').removeClass('has-error');
			$(element).closest('.form-group').addClass('has-success');
		},
		errorElement: 'span',
		errorClass: 'help-block'
	});
});

$('.summernote').summernote({height: 200});
$('#form1').submit(function () {
	$('#bbb').val($('#summernote').code());
	$('#ccc').val($('#summernote1').code());
	$('#ddd').val($('#summernote2').code());
	if($('#form1').valid()) {
		setTimeout(function () {
			$(this).submit();
		}, 1000);
	}else{
		return false;
	}
});

$(document).on('click', '.press', function(e){
	e.preventDefault();
	var controlForm2 = $('.imagesClass'),
	currentEntry2 = $(this).parents('.entry2:first'),
	newEntry2 = $(currentEntry2.clone()).appendTo(controlForm2);
	newEntry2.find('input').val('');
	controlForm2.find('.entry2:not(:last) .press')
		.removeClass('press').addClass('btn-remove2')
		.removeClass('btn-success').addClass('btn-danger')
		.html('<span class="glyphicon glyphicon-minus"></span>');
}).on('click', '.btn-remove2', function(e){
	$(this).parents('.entry2:first').fadeOut();
	e.preventDefault();
	return false;
});

function updateStk(id){
	$.ajax({
		type: "POST",
		url: "update_stock.php",              
		data: 'id='+id,                             
		success: function(msd) {  
			$('#upade_data').html(msd);
		}
	});
}
$("#updt").validate({
	rules:{
		color_id:{
			required: true,
		},
		size_id:{
			required: true,
		},
		fabric_id:{
			required: true,
		},
		stock:{
			required: true,
		},
		price:{
			required: true,
		}
	},
	errorPlacement: function(error,element) {
		element.attr('placeholder',error.text());
	}
});
function deleteImg(gid){
	var agree = confirm("Are you sure you want to delete this Property Image?");
	if (agree) {
		$.ajax({
			type: "POST",
			url: "delete_img.php",              
			data: 'id='+gid,                               
			success: function(msd)
			{  
				if( msd == 1 ){
					$('.s_'+gid).fadeIn().fadeOut(1000);
				}
			}
		})
	}
}

</script>