<?php

include 'header.php';

//$page='add_menu';
//Create the Class Objects
$objItem = load_class('Item');
$objChart = load_class('Chart');

$msg = "";
$log = "";

$getId = $_GET['id'];
if ($getId) {
    $action = 'edit';
} else {
    $action = 'add';
}

$upload_dir = '../multimedia/chart/';  

if (isset($_POST['submit'])) {
    if (isset($_POST['id']) && $_POST['id']) {
 include('include/image.class.php');

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

            // image type based on image file name extension:

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
			
            // include image processing code
           // include('include/image.class.php');

            $img = new Zubrag_image;
            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;

            // maximum thumb side size

            $max_x = 1600;
            $max_y = 800;

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
                $_POST['image'] = $up_file_name;
            }
        }
		
		if (!empty($_FILES['desc_image'])) {
            if (!is_dir($upload_dir)) {
                die("upload_files directory doesn't exist");
            }

            $temp_name = $_FILES['desc_image']['tmp_name'];
            $file_name = $_FILES['desc_image']['name'];
            $file_type = $_FILES['desc_image']['type'];
            $file_size = $_FILES['desc_image']['size'];
            $result = $_FILES['desc_image']['error'];

            $real_name = strtolower($_FILES['desc_image']['name']);

            // image type based on image file name extension:

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
                $up_file_name1 = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
                $file_path = $upload_dir . $up_file_name1;
            } while (file_exists($file_path));
            ini_set('memory_limit', '-1');
			
            // include image processing code
           // include('include/image.class.php');

            $img = new Zubrag_image;
            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;

            // maximum thumb side size

            $max_x = 1600;
            $max_y = 800;

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
                $img->GenerateThumbFile($temp_name, $upload_dir . $up_file_name1);
                $_POST['desc_image'] = $up_file_name1;
            }
        }

        $objChart->setArrData($_POST);
        $res = $objChart->update($_POST['id']);

        $_SESSION['msg'] = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong> Size Chart modified successfully.
                </div>";
        $log = "1";
    } else { 
include('include/image.class.php');
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
			
            // image type based on image file name extension:
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
            // include image processing code

            $img = new Zubrag_image;
            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;

            // maximum thumb side size

            $max_x = 1600;
            $max_y = 800;
			
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
                $_POST['image'] = $up_file_name;
            }
        }

		
		if (!empty($_FILES['desc_image'])) {
 
            if (!is_dir($upload_dir)) {
                die("upload_files directory doesn't exist");
            }

            $temp_name = $_FILES['desc_image']['tmp_name'];
            $file_name = $_FILES['desc_image']['name'];
            $file_type = $_FILES['desc_image']['type'];
            $file_size = $_FILES['desc_image']['size'];
            $result = $_FILES['desc_image']['error'];

            $real_name = strtolower($_FILES['desc_image']['name']);

            // image type based on image file name extension:

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
                $up_file_name1 = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
                $file_path = $upload_dir . $up_file_name1;
            } while (file_exists($file_path));
            ini_set('memory_limit', '-1');
			
            // include image processing code
           

            $img = new Zubrag_image;
            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;

            // maximum thumb side size

            $max_x = 1600;
            $max_y = 800;

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
                $img->GenerateThumbFile($temp_name, $upload_dir . $up_file_name1);
                $_POST['desc_image'] = $up_file_name1;
            }
        }
        $objChart->setArrData($_POST);

        $res = $objChart->insert();
        if ($res == 'done') {

            $_SESSION['msg'] = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Size Chart added successfully.
                    </div>";
            $log = "1";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>×</button>
                        <strong>Oh snap!</strong> Size Chart not added.
                    </div>";
            $log = "1";
        }
    }
}

$row = array();

if (isset($getId)) {
    $row = $objChart->GetRowContent($getId);
}
$GetAllItem = $objItem->SelectAll();

?>
    <link href="css/summernote.css" rel="stylesheet">
    <link href="css/summernote-bs3.css" rel="stylesheet">

    <div class="page-content">

        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1><?php echo ucfirst($action) ?>
                        <small>Size Chart</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li><i class="fa fa-edit"></i>  <a href="view_banner.php">Size Chart</a>
                        </li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Size Chart</a></li>
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
                            <h4><?php echo ucfirst($action) ?> Size Chart</a></h4>
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
                                    <div class="col-sm-6">
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
                                    <label class="col-sm-2 control-label">Size Chart Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="title" value="<?php disp_var($row['title']); ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-6">
                                        <!--<input type="text" class="form-control" name="description" value="<?php disp_var($row['description']); ?>">-->
										<input type="hidden" name="description" id="bbb">
                                        <div class="summernote" id="summernote"><?php disp_var($row['description']); ?></div>

                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Description French</label>
                                    <div class="col-sm-6">
										<input type="hidden" name="description_frn" id="ccc">
                                        <div class="summernote" id="summernote1"><?php disp_var($row['description_frn']); ?></div>

                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Description Arabic</label>
                                    <div class="col-sm-6">
										<input type="hidden" name="description_arb" id="ddd">
                                        <div class="summernote" id="summernote2"><?php disp_var($row['description_arb']); ?></div>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Size Chart Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="" id="typeahead" name="image">( Image Size: 1600 X 800 - file formats : .png, .jpeg, .jpg, .gif )

                                    </div>
                                </div>
<div class="form-group">
                                    <label class="col-sm-2 control-label">How To Measure Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="" id="typeahead1" name="desc_image">(  file formats : .png, .jpeg, .jpg, .gif )

                                    </div>
                                </div>

                                <?php
									if (!empty($row['image'])){ ?>
                                    <div class="control-group">
                                        <label class="control-label" for="fileInput">Size Chart Image</label>
                                        <div class="controls">
                                            <div style="width: 150px;margin-left:175px;right: 70px; top: 190px;"><img style="width: 100px" src="<?php echo "../multimedia/chart/" . $row['image'] ?>"></div>
                                        </div>
                                    </div>
                                <?php }?>
<?php if (!empty($row['desc_image'])){ ?>
                                    <div class="control-group">
                                        <label class="control-label" for="fileInput">How To Measure Image</label>
                                        <div class="controls">
                                            <div style="width: 150px;margin-left:175px;right: 70px; top: 190px;"><img style="width: 100px" src="<?php echo "../multimedia/chart/" . $row['desc_image'] ?>"></div>
                                        </div>
                                    </div>
                                <?php }?>



                                <div class="form-group ">

                                    <div class="col-sm-8">
                                        <input type="submit" name="submit" class="btn btn-default  pull-right" value="Submit">
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
				},
                messages: {
                    title: "<i class='fa fa-warning'></i> This field is required.",
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
$('.summernote').summernote({
	height: 200
});
</script>


