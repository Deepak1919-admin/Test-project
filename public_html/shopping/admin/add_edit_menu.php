<?php
include 'header.php';
//$page='add_menu';
//Create the Class Objects
$objMenu = load_class('Menu');
if (!isset($_SESSION['admin']))
    header("Location:index.php");
$msg = "";
$log = "";
$getId = $_GET['id'];
if ($getId) {
    $action = 'edit';
} else {
    $action = 'add';
}
if (isset($_POST['submit'])) {
$_POST['url'] = str_replace(' ', '', $_POST['url']);
    if ($_POST['parent_id'] == 0) {
        if ($_POST['display_order']) {
            $_POST['display_order'] = $_POST['display_order'];
        } else {
            $getMainMenu = $objMenu->GetMainMenu();
            if (!empty($getMainMenu)) {
                $getMainMenuCount = count($getMainMenu);
                $_POST['display_order'] = $getMainMenuCount + 1;
            } else {
                $_POST['display_order'] = 1;
            }
        }
    }
    if (empty($_POST['header_view'])) {
        $_POST['header_view'] = '0';
    }
    if (empty($_POST['footer_view'])) {
        $_POST['footer_view'] = '0';
    }
    $objMenu->setArrData($_POST);
    if (isset($_POST['id']) && $_POST['id']) {
        $res = $objMenu->update($_POST['id']);
        $_SESSION['msg'] = "<div class='alert alert-success'>
                  <strong>Well done!</strong> Menu Modified successfully
                </div>";

    } else {
        $res = $objMenu->insert();
        if ($res == 'done') {
            $_SESSION['msg'] = "<div class='alert alert-success'>
                  <strong>Well done!</strong> Menu Added successfully
                </div>";
 
        } else {
            $_SESSION['msg'] = "<div class='alert alert-danger'>
                  <strong>Not done!</strong> Something has gone wrong
                </div>";
      
        }
    }
}
$row = array();
$getMainMenu = $objMenu->GetMainMenu();
if (isset($getId)) {
    $row = $objMenu->GetRowContent($getId);
}
?>
            <div class="page-content">

                <!-- begin PAGE TITLE ROW -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1><?php echo ucfirst($action) ?> 
                                <small>Menu</small>
                            </h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                                </li>
                                <li><i class="fa fa-edit"></i>  <a href="view_menu.php">Menu</a>
                                </li>
                                <li class="active"> <a href="<?php echo currenturl() ?>"><?php echo ucfirst($action) ?> Menu</a></li>
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
                                    <form class="form-horizontal" method="POST" action="" id="form1" role="form">
 <input type="hidden" name="display_order" value="<?php disp_var($row['display_order']); ?>">
                                    <input type="hidden" name="id" value="<?php echo $getId ?>">
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Select Parent Menu</label>
                                            <div class="col-sm-10">
                                                <select  class="form-control" name="parent_id">
                                    <option value="">Parent Menu</option>
                                    <?php
                                    if (!empty($getMainMenu)) {
                                        for ($i = 0; $i < count($getMainMenu); $i++) {
                                            if ($getMainMenu[$i]['id'] == $row['parent_id']) {
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
                                            <label class="col-sm-2 control-label">Title</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="title" placeholder="Menu title" value="<?php disp_var($row['title']); ?>">
                                                <!-- <span class="help-block"><i class="fa fa-exclamation-circle"></i> Warning!</span> -->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Menu Type</label>
                                            <div class="col-sm-10">
                                                     <select   class="form-control" name="menu_type" id="" onchange="create(this.value)">
                                                        <option value="">Menu Type</option>
                                                        <option value="dynamic" <?php if($row['menu_type']=="dynamic"){ echo "selected='selected'";}?>>Default</option>
                                                        <option value="static" <?php if($row['menu_type']=="static"){ echo "selected='selected'";}?>>Custom</option>
                                                        
                                                    </select>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>
                   
   <div id='textCreate'>                                     
<div id='page' class="">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Choose Page</label>
                                            <div class="col-sm-8">
                                                     <select name='page' class="form-control">
<option value='o'>Select Page</option>
<option value='cart.php' <?php if($row['page']=="cart.php"){echo "selected='selected'";} ?>>Cart</option>
<option value='school.php' <?php if($row['page']=="school.php"){echo "selected='selected'";} ?>>School Profile</option>
<option value='corporate.php' <?php if($row['page']=="corporate.php"){echo "selected='selected'";} ?>>Corporate profile</option>
<option value='shop.php' <?php if($row['page']=="shop.php"){echo "selected='selected'";} ?>>Shop location</option>
<option value='size.php' <?php if($row['page']=="size.php"){echo "selected='selected'";} ?>>Unavailable sizes</option>
<option value='list.php' <?php if($row['page']=="list.php"){echo "selected='selected'";} ?>>Direct Purchase </option>
<option value='detail.php' <?php if($row['page']=="detail.php"){echo "selected='selected'";} ?>>Detail</option>
</select>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-4 control-label">Or Enter Url</label>
                                            <div class="col-sm-8">
                                                     <input type='text' class="form-control" name='url' value="<?php disp_var($row['url']);?>"/>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-sm-4 control-label">Choose Target Type</label>
                                            <div class="col-sm-8">
                                                   <select name='target' class="form-control" >
<option value='_self' <?php if($row['target']=="_self"){echo "selected='selected'"; } ?>>_self</option>
<option value='_blank'<?php if($row['target']=="_blank"){echo "selected='selected'"; } ?>>_blank</option>
<option value='_parent' <?php if($row['target']=="_parent"){echo "selected='selected'"; } ?>>_parent</option>
<option value='_top' <?php if($row['target']=="_top"){echo "selected='selected'"; } ?>>_top</option>
</select>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>
</div>
</div>




<div class="form-group">
                                                    <label class="col-sm-2 control-label"></label>
                                                    <div class="col-sm-10">
                                                        <label class="checkbox-inline">
                                                             <input type="checkbox" id="inlineCheckbox1" name="header_view" <?php if ($row['header_view'] == '1') echo 'checked' ?> value="1"> Show in Main Menu
                                                        </label>
                                                        <label class="checkbox-inline">
                                                           <input type="checkbox" id="inlineCheckbox2" name="footer_view" <?php if ($row['footer_view'] == '1') echo 'checked' ?> value="1"> Show in Footer Menu
                                                        </label>
          
                                                      
                                                    </div>
                                                </div>

 <div class="form-group">
                                            <label class="col-sm-2 control-label">Meta Title</label>
                                            <div class="col-sm-10">
                                                     <input type='text' class="form-control" placeholder="Meta title" name='meta_title' value="<?php disp_var($row['meta_title']);?>"/>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>
 <div class="form-group">
                                            <label class="col-sm-2 control-label">Meta Keyword</label>
                                            <div class="col-sm-10">
                                                     <textarea class="form-control" name="meta_keyword" id="textArea" placeholder="Meta Keyword"><?php disp_var($row['meta_keyword']);?></textarea>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Meta Description</label>
                                            <div class="col-sm-10">
                                                    <textarea class="form-control" name="meta_description" id="textArea" placeholder="Meta Description"><?php disp_var($row['meta_description']);?></textarea>
                                                <!-- <span class="help-block"><i class="fa fa-warning"></i> Error!</span> -->
                                            </div>
                                        </div>
                                         
                                        <div class="form-group ">
                                        
                                            <div class="col-sm-12">
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

           <script type="text/javascript">
function create(menu){
if(menu=="static"){
$('#textCreate').fadeIn();
 $('#url').prop('disabled', false);
   $('#page').prop('disabled', false);         
}
if(menu=="dynamic"){
$('#textCreate').fadeOut();
   $('#page').prop('disabled', 'disabled');    
    $('#url').prop('disabled', 'disabled');   
}
}
</script>
<script type="text/javascript">
    $('#form1').validate({
    rules: {

        title: {
            required: true
        },
        menu_type: {
            required: true
        }
    },
    messages: {
         title: "<i class='fa fa-warning'></i> This field is required.",
         menu_type: "<i class='fa fa-warning'></i> This field is required."
    },
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error');
         $(element).closest('.form-group').addClass('has-success');
    },
    errorElement: 'span',
    errorClass: 'help-block',
});

</script>