<?php
ob_start();
include 'header.php';
$objCorporate = load_class('Corporate');

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
$upload_dir = '../multimedia/corporate/';
if (isset($_POST['submit'])) 
{
	if(!isset($_POST['status'])){
		$_POST['status'] = 0;
	}
	
	// include image processing code
	include('include/image.class.php');
	$img = new Zubrag_image;
	unset($_POST['comPassword']);
	
	if (!empty($_FILES['image'])) {
		if (!is_dir($upload_dir)) {
			die("upload_files directory doesn't exist");
		}

		$temp_name = $_FILES['image']['tmp_name'];
		$file_name = $_FILES['image']['name'];
		$file_type = $_FILES['image']['type'];
		$file_size = $_FILES['image']['size'];
		$result = $_FILES['image']['error'];

		$real_name = strtolower($_FILES['image']['name']);

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
	if (isset($_POST['id']) && $_POST['id']) 
	{
		$objCorporate->setArrData($_POST);
		$res = $objCorporate->update();
		$_SESSION['msg'] = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>x</button><strong>Well done!</strong> Corporate modified successfully.</div>";
       	$log = "1";
    } //empty id ennd here
    else 
    {
       	$objCorporate->setArrData($_POST);
       	$res = $objCorporate->insert();
		if ($res == 'done') 
       	{
           	$_SESSION['msg'] = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>x</button><strong>Well done!</strong> Corporate added successfully.</div>";
           	$log = "1";				
        } 
       	else 
       	{
       	    $_SESSION['msg'] = "<div class='alert alert-error'><button data-dismiss='alert' class='close' type='button'>&#65533;</button><strong>Oh snap!</strong> Corporate not added.</div>";
			$log = "1";
		}
	}
}
$row = array();
if (isset($getId)) 
{
	$row = $objCorporate->GetRowContent($getId);
}
?>
    <link href="css/summernote.css" rel="stylesheet">
    <link href="css/summernote-bs3.css" rel="stylesheet">
	
    <div class="page-content">

        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1><?php echo ucfirst($action) ?>
                        <small>Corporate </small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Corporate</a></li>
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
                            <h4><?php echo ucfirst($action) ?> Corporate</a></h4>
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
                                    <label class="col-sm-2 control-label">Corporate Name</label>
                                    <div class="col-sm-4">
										<input type="text" placeholder="Corporate Name" class="form-control" name="name" value="<?php disp_var($row['name']); ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
										<input type="text" placeholder="Email" class="form-control" name="email" value="<?php disp_var($row['email']); ?>">
                                    </div>
                                </div>
								<!--<div class="form-group">
                                    <label class="col-sm-2 control-label">Telephone</label>
                                    <div class="col-sm-4">
										<input type="text" placeholder="Telephone" class="form-control" name="phone" value="<?php disp_var($row['phone']); ?>">
                                    </div>
                                </div>-->
								<div class="form-group">
									<label class="col-sm-2 control-label">Password</label>
									<div class="col-sm-4">
									<?php $readonly = ""; if(isset($getId)){ $readonly = "readonly";} ?>
										<input type="text" <?php echo $readonly; ?> placeholder="Password" class="form-control" id="password" name="password" value="<?php disp_var($row['password']); ?>">
                                    </div>
                                </div>
								<?php if(!$getId){?>
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
                                        <input type="file" class="" id="typeahead" name="image">( Image Size: 1570 X 500 - file formats : .png, .jpeg, .jpg, .gif )
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Active</label>
                                    <div class="col-sm-10">
										<input type="checkbox" id="status" name="status" <?php if ($row['status'] == '1') echo 'checked' ?> value="1" />
                                    </div>
                                </div>
								<div id="eng">
									<div class="form-group">
										<label class="col-sm-2 control-label">Description </label>
										<div class="col-sm-6">
											<input type="hidden" name="description" id="nature">
											<div class="summernote" id="textarea1"><?php disp_var($row['description']); ?></div>
										</div>
									</div>
								</div>
								<!--<div class="form-group">
                                    <label class="col-sm-2 control-label">Address</label>
                                    <div class="col-sm-6">
										<textarea name="address" class="form-control" id="address" rows="10"><?php disp_var($row['address']); ?></textarea>
                                    </div>
                                </div>-->
                                <div class="form-group ">
                                    <div class="col-sm-6">
                                        <input type="submit" name="submit" class="btn btn-default pull-right" value="Submit">
                                    </div>
                                </div>
								<?php
                                if (!empty($row['banner'])) {?>
                                    <div class="control-group">
                                        <label class="control-label" for="fileInput"></label>
                                        <div class="controls">
                                            <div style="width:200px;margin-left:175px;right: 70px; top: 190px;"><img style="width:200px" src="<?php echo "../multimedia/corporate/" . $row['banner'] ?>"></div>
                                        </div>
                                    </div>
								<?php }?>
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
			email: {
				required: true,
				email: true
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
	if($('#form1').valid()) { 
		setTimeout(function () { $(this).submit(); }, 1000); 
	}else{
		return false;
	}
});

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



