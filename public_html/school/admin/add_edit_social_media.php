<?php
include 'header.php';
//$page='add_menu';
//Create the Class Objects
$objSocialMedia = load_class('SocialMedia');
if (!isset($_SESSION['admin']))
	header("Location:index.php");

$msg = "";
$log = "";

$getId = '1';
if ($getId) {
    $action = 'edit';
} else {
    $action = 'add';
}

if (isset($_POST['submit'])) {

   $objSocialMedia->setArrData($_POST);
    if (isset($_POST['id']) && $_POST['id']) {
        $res = $objSocialMedia->update($_POST['id']);
        $_SESSION['msg'] = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong> Link modified successfully.
                </div>";
        $log = "1";
    } else {
        $res = $objSocialMedia->insert();
        if ($res == 'done') {
            $_SESSION['msg'] = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Link added successfully.
                    </div>";
            $log = "1";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>�</button>
                        <strong>Oh snap!</strong> Link not added.
                    </div>";
            $log = "1";
        }
    }
}

$row = array();
if (isset($getId)) {
    $row = $objSocialMedia->GetRowContent($getId);
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
                        <small>Social Media</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
                        <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Social Media</a></li>
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
                            <h4><?php echo ucfirst($action) ?> Social Media</a></h4>
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
                                    <label class="col-sm-2 control-label">Facebook</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="fb" value="<?php disp_var($row['fb']); ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Twitter</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="twitter" value="<?php disp_var($row['twitter']); ?>">

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Google Plus</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="google" value="<?php disp_var($row['google']); ?>">

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


        $(document).ready(function () {


            $('#form1').validate({
                ignore: [],
                rules: {
                    fb: {
                        required: true
                    },
                    tumblr: {

                        required: true
                    },
                    twitter: {

                        required: true
                    }

                },
                messages: {
                    fb: "<i class='fa fa-warning'></i> This field is required.",
                    tumblr: "<i class='fa fa-warning'></i> This field is required.",
                    twitter: "<i class='fa fa-warning'></i> This field is required."
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


        /*  $('#form1').submit(function () {


         if($(this).valid()) {
         alert('the form is valid');
         }
         });*/

        $('#form1').submit(function () {
            $('#bbb').val($('.summernote').code());
            if($('#form1').valid()) {
              setTimeout(function () {
       $(this).submit();
    }, 1000);
            }else{
                return false;
            }
        });
    </script>







