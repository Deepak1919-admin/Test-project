<?php
include 'header.php';
//$page='add_menu';
//Create the Class Objects
$objMenu = load_class('Menu');
$objArticles = load_class('Articles');
$msg = "";
$log = "";
$getId = $_GET['id'];
if ($getId) {
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['submit'])) {
    $content = $_POST['editor'];
    $getArticleByPage = $objArticles->GetRowContent($getId);
    $objArticles->setArrData($_POST);
    if (empty($getId)) {
        $insert = $objArticles->insert();
        if ($insert == 'done') {
            $_SESSION['msg']= "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Article added successfully.
                    </div>";
            $log = "1";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>&#65533;</button>
                        <strong>Oh snap!</strong> Article not added.
                    </div>";
            $log = "1";
        }
    } else {
        $id = $getArticleByPage['id'];
        $insert = $objArticles->update($id);
        if ($insert == 'done') {
            $_SESSION['msg'] = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Article modified successfully.
                    </div>";
            $log = "1";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>&#65533;</button>
                        <strong>Oh snap!</strong> Article not modified.
                    </div>";
            $log = "1";
        }
    }
}
$row = array();
$getMainMenu = $objMenu->GetMainMenu();
$getSubMenu = $objMenu->GetMenuByParentId('0');
if (isset($_POST['parent_id'])) {
    $getSubMenu = $objMenu->GetMenuByParentId($_POST['parent_id']);
} else {
    $getSubMenu = $objMenu->GetMenuByParentId('0');
}
if (isset($getId)) {
    $row = $objArticles->GetRowContent($getId);
    $getArticleMenuDetails = $objMenu->GetRowContent($row['menu_id']);
    if($getArticleMenuDetails['parent_id']=='0'){
        $getSubMenu = $objMenu->GetMenuByParentId($getArticleMenuDetails['id']);
        $mainMenuId = $getArticleMenuDetails['id'];
        $subMenuId = $getArticleMenuDetails['id'];
    }else{
        $getSubMenu = $objMenu->GetMenuByParentId($getArticleMenuDetails['parent_id']);
        $mainMenuId = $getArticleMenuDetails['parent_id'];
        $subMenuId = $getArticleMenuDetails['id'];
    }
}
?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<link href="css/summernote.css" rel="stylesheet">
    <link href="css/summernote-bs3.css" rel="stylesheet">

            <div class="page-content">

                <!-- begin PAGE TITLE ROW -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1><?php echo ucfirst($action) ?> 
                                <small>Articles</small>
                            </h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                                </li>
                                <li><i class="fa fa-edit"></i>  <a href="vie_menu.php">Articles</a>
                                </li>
                                <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Article</a></li>
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
                                    <h4><?php echo ucfirst($action) ?> Menu</a></h4>
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
                                            <label class="col-sm-2 control-label">Select Parent Menu</label>
                                            <div class="col-sm-10">
                                                <select  class="form-control" name="parent_id" onChange="showSubMenu(this.value)">
                                    <option value="0">Parent Menu</option>
                                    
                                    <?php
                                    if (!empty($getMainMenu)) {
                                        for ($i = 0; $i < count($getMainMenu); $i++) {
                                            if ($getMainMenu[$i]['id'] == $mainMenuId) {
                                                $selected = 'selected';
                                            } else {
                                                $selected = '';
                                            }
                                            ?>
                                            <option <?php echo $selected ?> value="<?php echo $getMainMenu[$i]['id'] ?>"><?php echo $getMainMenu[$i]['title'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                                <!-- <span class="help-block"><i class="fa fa-check"></i> Success!</span> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Select Sub Menu</label>
                                            <div class="col-sm-10">
                                               <select name="menu_id" id="menu_id" class="form-control">
                                        <?php
                                        if (!empty($getSubMenu)) {
                                            for ($i = 0; $i < count($getSubMenu); $i++) {
                                                if ($getSubMenu[$i]['id'] == $subMenuId) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                ?>
                                                <option <?php echo $selected ?> value="<?php echo $getSubMenu[$i]['id'] ?>"><?php echo $getSubMenu[$i]['title'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                                <!-- <span class="help-block"><i class="fa fa-exclamation-circle"></i> Warning!</span> -->
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                 <input type="text" class="form-control" id="typeahead" name="title" value="<?php disp_var($row['title']); ?>">

                                            </div>
                                        </div>
 
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Article</label>
                                            <div class="col-sm-10">
												<textarea class="ckeditor" name="editor"><?php disp_var($row['editor']); ?></textarea>
												<!--<input type="hidden" name="editor" id="bbb">
												<div class="summernote"><?php disp_var($row['editor']); ?></div>-->
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>
 
                                    
                                        <div class="form-group ">
                                        
                                            <div class="col-sm-12">
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
function showSubMenu(parent_id)
{
	if (parent_id == "")
	{
		document.getElementById("menu_id").innerHTML = "";
		return;
	}
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			document.getElementById("menu_id").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "getSubMenu.php?parent_id=" + parent_id, true);
	xmlhttp.send();
}

$(document).ready(function () {
    $('#form1').validate({
		ignore: [],
		rules: { 
			title: {
				required: true
			},
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
$('#form1').submit(function () {
		$('#bbb').val($('.summernote').code());
		if($('#form1').valid()) {
			setTimeout(function () { $(this).submit(); }, 1000);
        }else{
            return false;
        }
	});
</script>
<script>
	$(document).ready(function() {
        $('.summernote').summernote({
            height: 200,
            onImageUpload: function(files, editor, welEditable) {
                sendFile(files[0], editor, welEditable);
            }
        });
		function sendFile(file, editor, welEditable) {
			data = new FormData();
			data.append("file", file);
			$.ajax({
				data: data,
				type: "POST",
				url: "uploader.php",
				cache: false,
				contentType: false,
				processData: false,
				success: function(url) {
					editor.insertImage(welEditable, url);
				}
			});
		}
	});
</script>