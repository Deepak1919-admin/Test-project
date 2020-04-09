<?php
include 'header.php';
//$page='add_menu';
//Create the Class Objects
$ObjHelp = load_class('Help');
$GetHelp=$ObjHelp->SelectAll();
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

    $ObjHelp->setArrData($_POST);
    if (isset($_POST['id']) && $_POST['id']) {
        $res = $ObjHelp->update($_POST['id']);
        $_SESSION['msg'] = "<div class='alert alert-success'>
                    <button data-dismiss='alert' class='close' type='button'>x</button>
                    <strong>Well done!</strong> Content modified successfully.
                </div>";
        $log = "1";
    } else {
        $res = $ObjHelp->insert();
        if ($res == 'done') {
            $_SESSION['msg'] = "<div class='alert alert-success'>
                        <button data-dismiss='alert' class='close' type='button'>x</button>
                        <strong>Well done!</strong> Content  added successfully.
                    </div>";
            $log = "1";
        } else {
            $_SESSION['msg'] = "<div class='alert alert-error'>
                        <button data-dismiss='alert' class='close' type='button'>�</button>
                        <strong>Oh snap!</strong>Content  not added.
                    </div>";
            $log = "1";
        }
    }
}

$row = array();
if (isset($getId)) {
    $row = $ObjHelp->GetRowContent($getId);
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
                    <small>Help</small>
                </h1>
                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                    </li>
                    <li><i class="fa fa-edit"></i>  <a href="vie_menu.php">Help</a>
                    </li>
                    <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Help</a></li>
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
                        <h4><?php echo ucfirst($action) ?> Help</a></h4>
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
                                    <label class="col-sm-2 control-label">Help Content</label>
                                    <div class="col-sm-10">

                                        <input type="hidden" name="description" id="bbb">
                                        <div class="summernote"><?php disp_var($row['description']); ?></div>
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


    $(document).ready(function () {


        $('#form1').validate({
            ignore: [],
            rules: {
                range_from: {
                    required: true
                },
                range_to: {

                    required: true
                },
                price: {

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


 $('.summernote').summernote({

        height: 200

    });
</script>







