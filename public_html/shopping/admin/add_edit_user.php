<?php
ob_start();
include 'header.php';
$objUsers = load_class('Users');

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
if (isset($_POST['submit'])) 
{
	
	if (isset($_POST['id']) && $_POST['id']) 
	{
		$objUsers->setArrData($_POST);
		$res = $objUsers->update();
		$_SESSION['msg'] = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>x</button><strong>Well done!</strong> Corporate modified successfully.</div>";
       	$log = "1";
    } //empty id ennd here
    else 
    {
       	$objUsers->setArrData($_POST);
       	$res = $objUsers->insert();
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
	$row = $objUsers->GetRowContent($getId);
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
                        <li><i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a></li>
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
                            <h4><?php echo ucfirst($action) ?> User</a></h4>
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
                                    <label class="col-sm-2 control-label">First Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="First Name" class="form-control" name="first_name" value="<?php disp_var($row['first_name']); ?>">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Last Name</label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Last Name" class="form-control" name="last_name" value="<?php disp_var($row['last_name']); ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Email" class="form-control" name="email" value="<?php disp_var($row['email']); ?>">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-4">
                                        <input type="text" placeholder="Email" class="form-control" name="Password" value="<?php disp_var($row['password']); ?>">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="col-sm-6">
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



