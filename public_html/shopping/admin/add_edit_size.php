<?php
include 'header.php';
$objSize = load_class('Size');

$msg = "";
$log = "";

$getId = $_GET['id'];
//$getId = '1';
if ($getId) {
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['submit'])) {

    if (isset($_POST['id']) && $_POST['id']) {
      
        $objSize->setArrData($_POST);
        $res = $objSize->update($_POST['id']);
        if($res){
        $msg = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong> Size modified successfully.
                </div>";
        $log = "1";
        }else{
            $msg = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>&#65533;</button>
                        <strong>Oh snap!</strong> Size not modified.
                    </div>";
            $log = "2";
        }
    } else {
        
        $objSize->setArrData($_POST);
        $res = $objSize->insert();
        if ($res == 'done') {
            $msg = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Size added successfully.
                    </div>";
            $log = "1";
        } else {
            $msg = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>&#65533;</button>
                        <strong>Oh snap!</strong> Size not added.
                    </div>";
            $log = "2";
        }
    }
}
$row = array();
if (isset($getId)) {
    $row = $objSize->GetRowContent($getId);
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
                        <small>Size</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Size</a></li>
                    </ol>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">

            <!-- Validation States -->
            <div class="col-lg-12">
				
                <?php if($msg != ""){ echo $msg; } ?>
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4><?php echo ucfirst($action) ?> Size</a></h4>
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
                                    <label class="col-sm-2 control-label">Size English</label>
                                    <div class="col-sm-4">
					<input type="text" placeholder="Size" class="form-control" name="title" value="<?php disp_var($row['title']); ?>"/>
                                    </div>
                                </div>
				
				<div class="form-group">
                                    <label class="col-sm-2 control-label">Size Arab</label>
                                    <div class="col-sm-4">
					<input type="text" placeholder="Size Arab" class="form-control" name="title_arab" value="<?php disp_var($row['title_arab']); ?>"/>
                                    </div>
                                </div>
				
				<div class="form-group">
                                    <label class="col-sm-2 control-label">Size French</label>
                                    <div class="col-sm-4">
					<input type="text" placeholder="Size French" class="form-control" name="title_franch" value="<?php disp_var($row['title_franch']); ?>"/>
                                    </div>
                                </div>
                                
				<div class="form-group ">
                                    <div class="col-sm-6">
										<input type="submit" name="submit" class="btn btn-default  pull-right" value="Submit">
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
			title: {
				required: true
			}
		},
		messages: {
			title: "<i class='fa fa-warning'></i> This field is required."
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
	$('#nature').val($('.summernote').code());
	$('#features').val($('.summernote1').code());
	if($('#form1').valid()) { 
		setTimeout(function () { $(this).submit(); }, 1000); 
	}else{
		return false;
	}
});

</script>



