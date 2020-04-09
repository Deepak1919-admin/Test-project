<?php
ob_start();
include 'header.php';
$objSchool = load_class('School');
$objLanguage = load_class('Language');
$objSchoolGal = load_class('SchoolGal');

$msg = "";
$log = "";

$getId = $_GET['id'];
if ($getId) 
{
   	$action = 'edit';
} 
else 
{
   	$action = 'add';
}
$upload_dir = '../multimedia/school/';
$upload_img_dir_gal ="../multimedia/school_gal/";
if (isset($_POST['submit'])) 
{
	
	if(isset($_POST['lang'])){
		$_POST['language'] = implode("/",$_POST['lang']);
	}
	unset($_POST['lang']);
	
	if(!isset($_POST['status'])){
		$_POST['status'] = 0;
	}
	
	// include image processing code
	include('include/image.class.php');
	$img = new Zubrag_image;
	unset($_POST['comPassword']);
	
	if (!empty($_FILES['thumb'])) {
		if (!is_dir($upload_dir)) {
			die("upload_files directory doesn't exist");
		}

		$temp_name = $_FILES['thumb']['tmp_name'];
		$file_name = $_FILES['thumb']['name'];
		$file_type = $_FILES['thumb']['type'];
		$file_size = $_FILES['thumb']['size'];
		$result = $_FILES['thumb']['error'];

		$real_name = strtolower($_FILES['thumb']['name']);

		//image type based on image file name extension:

		if (strstr($real_name, ".png")) {
			$image_type = "png";
		} else if (strstr($real_name, ".jpeg")) {
			$image_type = "jpeg";
		} else if (strstr($real_name, ".jpg")) {
			$image_type = "jpg";
		} else if (strstr($real_name, ".gif")) {
			$image_type = "gif";
		} 

		do {
			$up_file_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
			$file_path = $upload_dir . $up_file_name;
		} while (file_exists($file_path));
		ini_set('memory_limit', '-1');
			
		$save_to_file = true;
		$image_quality = 100;
		$image_type = -1;

		// maximum thumb side size
	
		$max_x = 1570;
		$max_y = 500;

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
			$img->GenerateThumbFile($temp_name, $upload_dir . $up_file_name);
			$_POST['banner'] = $up_file_name;
		}
	}
	if (!empty($_FILES['thumb1'])) {
		if (!is_dir($upload_dir)) {
			die("upload_files directory doesn't exist");
		}

		$temp_name = $_FILES['thumb1']['tmp_name'];
		$file_name = $_FILES['thumb1']['name'];
		$file_type = $_FILES['thumb1']['type'];
		$file_size = $_FILES['thumb1']['size'];
		$result = $_FILES['thumb1']['error'];

		$real_name = strtolower($_FILES['thumb1']['name']);

		//image type based on image file name extension:

		if (strstr($real_name, ".png")) {
			$image_type = "png";
		} else if (strstr($real_name, ".jpeg")) {
			$image_type = "jpeg";
		} else if (strstr($real_name, ".jpg")) {
			$image_type = "jpg";
		} else if (strstr($real_name, ".gif")) {
			$image_type = "gif";
		} 

		do {
			$up_file_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
			$file_path = $upload_dir . $up_file_name;
		} while (file_exists($file_path));
		ini_set('memory_limit', '-1');
			
		$save_to_file = true;
		$image_quality = 100;
		$image_type = -1;

		// maximum thumb side size
	
		$max_x = 1060;
		$max_y = 375;

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
			$img->GenerateThumbFile($temp_name, $upload_dir . $up_file_name);
			$_POST['banner2'] = $up_file_name;
		}
	}
	if (isset($_POST['id']) && $_POST['id']) 
	{
		$objSchool->setArrData($_POST);
		$res = $objSchool->update($_POST['sid']);
		$Insert_id=$_POST['id'];
		
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
				
                $max_x = 9999;
                $max_y = 9999;
				
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
                    $imagearray['image'] = $up_img_name;
                    $imagearray['school_id']=$Insert_id;
                    $objSchoolGal->setArrData($imagearray);
                    $imageout = $objSchoolGal->insert();
                     
				}
			}
		}
		
		$_SESSION['msg'] = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>x</button><strong>Well done!</strong> School modified successfully.</div>";
       	$log = "1";
    } //empty id ennd here
    else 
    {
       	$objSchool->setArrData($_POST);
       	$res = $objSchool->insert();
		$Insert_id=mysql_insert_id();
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
				
                $max_x = 9999;
                $max_y = 9999;
				
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
                    $imagearray['image'] = $up_img_name;
                    $imagearray['school_id']=$Insert_id;
                    $objSchoolGal->setArrData($imagearray);
                    $imageout = $objSchoolGal->insert();
                     
				}
			}
		}
		if ($res == 'done') 
       	{
           	$_SESSION['msg'] = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>x</button><strong>Well done!</strong> School added successfully.</div>";
           	$log = "1";				
        } 
       	else 
       	{
       	    $_SESSION['msg'] = "<div class='alert alert-error'>
								<button data-dismiss='alert' class='close' type='button'>&#65533;</button><strong>Oh snap!</strong> School not added.
								</div>";
			$log = "1";
		}
	}
}
$row = array();
if (isset($getId)) 
{
	$row = $objSchool->GetRowContent($getId);
	$row2 = $objSchoolGal->GetRowContentByPid($getId);
}
$allLang = $objLanguage->SelectAll();
?>
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>		 
<script type="text/javascript">
    window.onload = function()
    {
	var sBasePath = document.location.href.substring(0, document.location.href.lastIndexOf('_samples'));
        var oFCKeditor = new FCKeditor('description');
	var oFCKeditordescription_arb = new FCKeditor('description_arb');
	var oFCKeditordescription_fnch= new FCKeditor('description_fnch');
	var oFCKeditorshop= new FCKeditor('shop');
	var oFCKeditorshop_franch= new FCKeditor('shop_franch');
	var oFCKeditorshop_arab= new FCKeditor('shop_arab');
	var oFCKeditorsizes= new FCKeditor('sizes');
	var oFCKeditorsize_french= new FCKeditor('size_french');
	var oFCKeditorsize_arab= new FCKeditor('size_arab');



       
        
        //oFCKeditor.BasePath	= sBasePath ;
        oFCKeditor.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditordescription_arb.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditordescription_fnch.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditorshop.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditorshop_franch.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditorshop_arab.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditorsizes.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditorsize_french.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';
	oFCKeditorsize_arab.BasePath = '<?php echo H_PATH; ?>admin/fckeditor/';

       
        oFCKeditor.ReplaceTextarea();
	oFCKeditordescription_arb.ReplaceTextarea();
	oFCKeditordescription_fnch.ReplaceTextarea();
	oFCKeditorshop.ReplaceTextarea();
	oFCKeditorshop_franch.ReplaceTextarea();
	oFCKeditorshop_arab.ReplaceTextarea();
	oFCKeditorsizes.ReplaceTextarea();
	oFCKeditorsize_french.ReplaceTextarea();
	oFCKeditorsize_arab.ReplaceTextarea(); 
    }

</script>
    <link href="css/summernote.css" rel="stylesheet">
    <link href="css/summernote-bs3.css" rel="stylesheet">
	
    <div class="page-content">

        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1><?php echo ucfirst($action) ?>
                        <small>School </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> School</a></li>
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
                            <h4><?php echo ucfirst($action) ?> School</a></h4>
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
					<label class="col-sm-2 control-label">School Name</label>
					<div class="col-sm-4">
						<input type="text" placeholder="School Name" class="form-control" name="name" value="<?php disp_var($row['name']); ?>">
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">School Language</label>
					<div class="col-sm-4">
					<?php for($i=0;$i<count($allLang); $i++)
					{ $chek ="";
					if($i==0)
					{
						$chek = "checked ";
					}?>
					&nbsp;
					<input type="checkbox" name="lang[]" <?php echo $chek; ?> value="<?php echo $allLang[$i]['id'];?>">&nbsp;&nbsp;<?php echo $allLang[$i]['name']; ?>
					<?php }?>
                                    </div>
                                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">School Code</label>
					<div class="col-sm-4">
						<input type="text" placeholder="School Code" class="form-control" id="code" name="code" value="<?php disp_var($row['code']); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-4">
						<input type="text" placeholder="Email" class="form-control" name="email" value="<?php disp_var($row['email']); ?>">
					</div>
                                </div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Multiple Email (separate with comas)</label>
					<div class="col-sm-4">
						<textarea name="mul_email"><?php echo $row['mul_email'];?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Password</label>
					<div class="col-sm-4">
						<?php
						$readonly = "";
						if(isset($getId))
						{ $readonly = "readonly";} ?>
						<input type="text" <?php echo $readonly; ?> placeholder="Password" class="form-control" id="password" name="password" value="<?php disp_var($row['password']); ?>">
					</div>
				</div>
				<?php if(!$getId)
				{?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Confirm Password</label>
					<div class="col-sm-4">
						<input type="Password" placeholder="confirm password" class="form-control" name="comPassword" value="">
					</div>
				</div>
				<?php }?>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Banner</label>
					<div class="col-sm-10">
						<input type="file" class="" id="typeahead" name="thumb">( Image Size: 1570 X 500 - file formats : .png, .jpeg, .jpg, .gif )
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Second Banner </label>
					<div class="col-sm-10">
                                        <input type="file" class="" id="typeahead" name="thumb1">( Image Size: 1060 X 375 - file formats : .png, .jpeg, .jpg, .gif )
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Active</label>
					<div class="col-sm-10">
						<input type="checkbox" id="status" name="status" <?php if ($row['status'] == '1') echo 'checked' ?> value="1" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description English </label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="description" id="nature">-->
						<!--<div class="summernote" id="textarea1"><?php disp_var($row['description']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="description" name="description"><?php disp_var($row['description']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description French</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="description_fnch" id="nature1">-->
						<!--<div class="summernote" id="textarea2"><?php disp_var($row['description_fnch']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="description_fnch" name="description_fnch"><?php disp_var($row['description_fnch']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Description Arabic</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="description_arb" id="nature2">-->
						<!--<div class="summernote" id="textarea3"><?php disp_var($row['description_arb']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="description_arb" name="description_arb"><?php disp_var($row['description_arb']); ?></textarea>
						
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Shop location page</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="shop" id="nature3">-->
						<!--<div class="summernote" id="textarea4"><?php disp_var($row['shop']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="shop" name="shop"><?php disp_var($row['shop']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Shop location page Franch</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="shop_franch" id="nature8">-->
						<!--<div class="summernote" id="textarea8"><?php disp_var($row['shop_franch']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="shop_franch" name="shop_franch"><?php disp_var($row['shop_franch']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Shop location page Arab</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="shop_arab" id="nature9">-->
						<!--<div class="summernote" id="textarea9"><?php disp_var($row['shop_arab']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="shop_arab" name="shop_arab"><?php disp_var($row['shop_arab']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Unavailable sizes</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="sizes" id="nature4">-->
						<!--<div class="summernote" id="textarea5"><?php disp_var($row['sizes']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="sizes" name="sizes"><?php disp_var($row['sizes']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Unavailable sizes French</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="size_french" id="nature5">-->
						<!--<div class="summernote" id="textarea6"><?php disp_var($row['size_french']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="size_french" name="size_french"><?php disp_var($row['size_french']); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Unavailable sizes Arab</label>
					<div class="col-sm-6">
						<!--<input type="hidden" name="size_arab" id="nature6">-->
						<!--<div class="summernote" id="textarea7"><?php disp_var($row['size_arab']); ?></div>-->
						<textarea style="width: 430px;height: 200px" id="size_arab" name="size_arab"><?php disp_var($row['size_arab']); ?></textarea>
					</div>
				</div>
				
				<?php
                                if (!empty($row['banner'])) {?>
                                    <div class="control-group">
                                        <label class="control-label" for="fileInput">Banner</label>
                                        <div class="controls">
                                            <div style="width:200px; margin-left:175px;right: 70px; top: 100px;"><img style="width: 200px" src="<?php echo "../multimedia/school/" . $row['banner'] ?>"></div>
                                        </div>
                                    </div>
									<div class="control-group">
                                        <label class="control-label" for="fileInput">Second Banner</label>
                                        <div class="controls">
                                            <div style="width:200px; margin-left:175px;right: 70px; top: 190px;"><img style="width: 200px" src="<?php echo "../multimedia/school/" . $row['banner2'] ?>"></div>
                                        </div>
                                    </div></br>
								<?php }?>
								<div class="panel panel-default clearfix">
										<div class="panel-heading">Additional Images</div>
											<div class="panel-body">
												<div class="control-group" id="fields">
													<label class="control-label col-sm-4" for="field1">Images (9999 W * 9999 H)</label>
													<div class="imagesClass form-group  col-xs-8"> 
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
															<img src="../multimedia/school_gal/<?php echo $imgs['image']; ?>" width="100" height="75"/>&nbsp; &nbsp; &nbsp;
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
								<div class="form-group clearfix">
									<div class="col-sm-12">
										<input type="submit" name="submit" class="btn btn-default pull-right" value="Submit">
									</div>
								</div> 
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include("footer.php"); ?>
<script src="js/summernote.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
	$('#form1').validate({
		ignore: [],
		rules: {
			name: {
				required: true
			},
			username: {
				required: true,
			},
			code: {
				required: true,
			},
			email: {
				required: true,
				email: "is Improperly Formatted"
			},
			phone: {
				required: true
			},
			password: {
				required: true
			},
			comPassword: {
				equalTo: "#password"
			}
		},
		messages: {
			name: "<i class='fa fa-warning'></i> This field is required.",
			code: "<i class='fa fa-warning'></i> This field is required.",
			username: {
				required:  " This field is required.",
				remote: "<i class='fa fa-warning'></i> Username Exist" 
			},	
			email: "<i class='fa fa-warning'></i> This field is required.",
			phone: "<i class='fa fa-warning'></i> This field is required.",
			password: "<i class='fa fa-warning'></i> This field is required.",
			comPassword: "<i class='fa fa-warning'></i> Password Incorrect."
			
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

$('#form1').submit(function () {
	$('#nature').val($('#textarea1').code());
	$('#nature1').val($('#textarea2').code());
	$('#nature2').val($('#textarea3').code());
	$('#nature3').val($('#textarea4').code());
	$('#nature4').val($('#textarea5').code());
	$('#nature5').val($('#textarea6').code());
	$('#nature6').val($('#textarea7').code());
	$('#nature8').val($('#textarea8').code());
	$('#nature9').val($('#textarea9').code());
	if($('#form1').valid()) { 
		setTimeout(function () { $(this).submit(); }, 1000); 
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
function deleteImg(gid){
	var agree = confirm("Are you sure you want to delete this Property Image?");
	if (agree) {
		$.ajax({
			type: "POST",
			url: "delete_school.php",              
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
$('.summernote').summernote({height: 200});
// $('input[name="lang[]"]').click(function() {
	// if($(this).val() == 1){
		// if($(this).prop('checked')==true){
			// $('#eng').html('<div class="form-group"><label class="col-sm-2 control-label"> Description English </label><div class="col-sm-6"><input type="hidden" name="description" id="nature"><div class="summernote" id="textarea1"></div></div></div>');
		// }else{
			// $('#eng').html('');
		// }
	// }else if($(this).val() == 2){
		// if($(this).prop('checked')==true){
			// $('#frnch').html('<div class="form-group"><label class="col-sm-2 control-label">Description French</label><div class="col-sm-6"><input type="hidden" name="description_fnch" id="nature1"><div class="summernote" id="textarea2"></div></div></div>');
		// }else{
			// $('#frnch').html('');
		// }
	// }
	// else if($(this).val() == 3){
		// if($(this).prop('checked')==true){
			// $('#offerprice').show();
		// }else{
			// $('#offerprice').hide();
		// }
	// }	
// });
</script>

<script>
    $(document).ready(function() {
        $('#textarea1').summernote({
            height: 200,
            onImageUpload: function(files) {
                sendFile(files[0]);
            }
        });
        function sendFile(file, editor, welEditable) {
            data = new FormData();
            data.append("file", file);//You can append as many data as you want. Check mozilla docs for this
            $.ajax({
                data: data,
                type: "POST",
                url: 'uploader.php',
                cache: false,
                contentType: false,
                processData: false,
                success: function(url) {
                    $('#textarea1').summernote('editor.insertImage', url);
                }
            });
        }
    }); 
</script>

