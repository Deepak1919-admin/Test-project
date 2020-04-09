<?php

include 'header.php';

//$page='add_menu';

//Create the Class Objects

$objInnBanner = load_class('InnerBanner');
$objSchool = load_class('School');
$objMenu = load_class('Menu');

$msg = "";
$log = "";

$getId = $_GET['id'];
if ($getId) {
    $action = 'edit';
} else {
    $action = 'add';
}

$upload_dir = '../multimedia/Innerbanner/';  

if (isset($_POST['submit'])) {
    if (isset($_POST['id']) && $_POST['id']) {
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
            include('include/image.class.php');

            $img = new Zubrag_image;
            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;

            // maximum thumb side size

            $max_x = 1560;
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
                $_POST['image'] = $up_file_name;
            }
        }

        $objInnBanner->setArrData($_POST);
        $res = $objInnBanner->update($_POST['id']);

        $_SESSION['msg'] = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong> Banner modified successfully.
                </div>";
        $log = "1";
    } else {
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
            include('include/image.class.php');

            $img = new Zubrag_image;
            $save_to_file = true;
            $image_quality = 100;
            $image_type = -1;

            // maximum thumb side size

            $max_x = 1560;
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
                $_POST['image'] = $up_file_name;
            }
        }

        $objInnBanner->setArrData($_POST);
        $res = $objInnBanner->insert();
        if ($res == 'done') {

            $_SESSION['msg'] = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Banner added successfully.
                    </div>";
            $log = "1";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>×</button>
                        <strong>Oh snap!</strong> Banner not added.
                    </div>";
            $log = "1";
        }
    }
}

$row = array();

if (isset($getId)) {
    $row = $objInnBanner->GetRowContent($getId);
}
$getSubMenu = $objMenu->GetMenuByParentId('0');
$GetAllSchool = $objSchool->SelectAll();
?>
    <link href="css/summernote.css" rel="stylesheet">
    <link href="css/summernote-bs3.css" rel="stylesheet">

    <div class="page-content">

        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1><?php echo ucfirst($action) ?>
                        <small>Banner</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li><i class="fa fa-edit"></i>  <a href="view_banner.php">Banner</a>
                        </li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Banner</a></li>
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
                            <h4><?php echo ucfirst($action) ?> Category</a></h4>
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
									<label class="col-sm-2 control-label">School</label>
                                    <div class="col-sm-6" id="subdiv">
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
									<label class="col-sm-2 control-label">Select Menu</label>
									<div class="col-sm-6">
										<select name="menu_id" id="menu_id" class="form-control">
											<option value="">Select Menu</option>
										<?php if (!empty($getSubMenu)) {
                                            for ($i = 0; $i < count($getSubMenu); $i++) {
                                                if ($getSubMenu[$i]['id'] == $row['menu_id']) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }?>
                                                <option <?php echo $selected ?> value="<?php echo $getSubMenu[$i]['id'] ?>"><?php echo $getSubMenu[$i]['title'] ?></option>
                                                <?php
                                            }
                                        }?>
										</select>
									</div>
								</div>
								
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Banner Name</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="title" value="<?php disp_var($row['title']); ?>">

                                    </div>
                                </div>
								
                                <!--<div class="form-group">
                                    <label class="col-sm-2 control-label">Description</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="description" value="<?php disp_var($row['description']); ?>">
										<input type="hidden" name="description" id="bbb">
                                        <div class="summernote"><?php disp_var($row['description']); ?></div>

                                    </div>
                                </div>-->

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Image</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="" id="typeahead" name="image">( Image Size: 1560 X 500 - file formats : .png, .jpeg, .jpg, .gif )

                                    </div>
                                </div>

                                <?php

                                if (!empty($row['image']))
                                {
                                    ?>
                                    <div class="control-group">
                                        <label class="control-label" for="fileInput"></label>
                                        <div class="controls">
                                            <div style="width: 150px;margin-left:175px;right: 70px; top: 190px;"><img style="width: 100px" src="<?php echo "../multimedia/Innerbanner/" . $row['image'] ?>"></div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>


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
				school_id: {
					required: true
				},
				title: {
					required: true
				},
				menu_id: {
					required: true
				},
				image: {
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
</script>



