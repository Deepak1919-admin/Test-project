<?php
include 'header.php';
//Create the Class Objects
$objItem= load_class('Item');

$msg = "";
$log = "";
$getId = $_GET['id'];
if ($getId) {
	$action = 'edit';
	} else {
		$action = 'add';
	}
	
if (isset($_POST['submit'])){
    if (isset($_POST['id']) && $_POST['id']){
        $objItem->setArrData($_POST);
        $res = $objItem->update($_POST['id']);
		//empty end here
       	    $msg = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong> Item modified successfully.
                    </div>";
        $log = "1";       
    } //empty id ennd here
	else{
		$objItem->setArrData($_POST);
		$res = $objItem->insert();
		if ($res == 'done'){
			$msg = "<div class='alert alert-success'>
					<button data-dismiss='alert' class='close' type='button'>x</button>
					<strong>Well done!</strong>  Item added successfully.
					</div>";
			$log = "1";
		}else{
			$msg = "<div class='alert alert-error'>
					<button data-dismiss='alert' class='close' type='button'>�</button>
					<strong>Oh snap!</strong>Item not added.
					</div>";
			$log = "1";
		}
	}
}
$row = array();
if (isset($getId))
{
    $row = $objItem->GetRowContent($getId);	
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
                        <small>Item</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Item</a></li>
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
                            <h4><?php echo ucfirst($action) ?> Item</a></h4>
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
                                    <div class="col-sm-4">
										<input type="text" placeholder="Item" class="form-control" name="title" value="<?php disp_var($row['title']); ?>"/>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Item French</label>
                                    <div class="col-sm-4">
										<input type="text" placeholder="Item French" class="form-control" name="title_frnc" value="<?php disp_var($row['title_frnc']); ?>"/>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-2 control-label">Item Arabic</label>
                                    <div class="col-sm-4">
										<input type="text" placeholder="Item Arabic" class="form-control" name="title_arb" value="<?php disp_var($row['title_arb']); ?>"/>
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



