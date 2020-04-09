<?php
include 'header.php';
if($_POST['submit'] && $_POST['id']!=""){


if(isset($_POST['deletedimage'])){ 
                    
     foreach ($_POST['deletedimage'] as $key=>$val){
        
          $res = $ObjImages->DelRowContent($key);
          unlink("../multimedia/article/".$val."");
          
    }
}

if(isset($_POST['deletedVideo'])){ 
                    
     foreach ($_POST['deletedVideo'] as $key=>$val){
        
          $res = $ObjVideos->DelRowContent($key);
          
    }
}

if(isset($_POST['deletequiz'])){ 
                    
     foreach ($_POST['deletequiz'] as $key=>$val){
        
          $res = $ObjQuiz->DelRowContent($key);
          
    }
}
$upload_img_dir="../multimedia/article/";
$articlearray=array();
$quizarray=array();
$videoarray=array();
$imagearray=array();
$articlearray['id']=$_POST['id'];
$articlearray['title']=$_POST['title'];
$articlearray['description']=$_POST['description'];
$articlearray['folder_id']=$_POST['folder_id'];
$articlearray['user_id']=$_POST['user_id'];

$ObjArticles->setArrData($articlearray);
$res = $ObjArticles->update();
 if($res==1){
$inertId=$_POST['id'];
foreach($_POST['quiz'] as $quiz){
$quizarray['id']=$quiz['id'];
$quizarray['article_id']=$inertId;
$quizarray['question']=$quiz['question'];
$quizarray['option_1']=$quiz['option_1'];
$quizarray['option_2']=$quiz['option_2'];
$quizarray['option_3']=$quiz['option_3'];
$quizarray['option_4']=$quiz['option_4'];
$quizarray['answer']  =$quiz['answer'];
    if($quizarray['id']==""){
        $ObjQuiz->setArrData($quizarray);
        $quizout = $ObjQuiz->insert();
    }else{
        $ObjQuiz->setArrData($quizarray);
        $quizout = $ObjQuiz->update();
    }
}

    foreach($_POST['video'] as $vdeo){
        if($vdeo!=""){
        $videoarray['article_id']=$inertId;
        $videoarray['video']=$vdeo;
        $videoarray['user_id']=$_POST['user_id'];
        $ObjVideos->setArrData($videoarray);
        $videout = $ObjVideos->insert();
        }
    }


    if (!empty($_FILES['image'])) 
        {
            include('include/image.class.php');
            $img = new Zubrag_image;
            for($k = 0;$k < count($_FILES['image']['name']); $k++)
            {
                if (!is_dir($upload_img_dir)) 
                {
                    die("upload_img_dir directory doesn't exist");
                }
                $temp_name = $_FILES['image']['tmp_name'][$k];
                $file_name = $_FILES['image']['name'][$k];
                $file_type = $_FILES['image']['type'][$k];
                $file_size = $_FILES['image']['size'][$k];
                $result = $_FILES['image']['error'][$k];
                $real_name = strtolower($_FILES['image']['name'][$k]);
                // image type based on image file name extension:
                if (strstr($real_name, ".png")) 
                {
                    $image_type = "png";
                }
                else if (strstr($real_name, ".jpeg")) 
                {
                    $image_type = "jpeg";
                } 
                else if (strstr($real_name, ".jpg")) 
                {
                    $image_type = "jpg";
                } 
                else if (strstr($real_name, ".gif")) 
                {
                 $image_type = "gif";
                } 
                else 
                {
                }
                do 
                {
                    $up_img_name = "rh_" . mt_rand(10000, 99999) . "." . $image_type;
                    $file_path = $upload_img_dir . $up_img_name;
                } 
                while (file_exists($file_path));
                ini_set('memory_limit', '-1');
                // include image processing code
                $save_to_file = true;
                $image_quality = 300;
                $image_type = -1;
                // maximum thumb side size
//              if($imgPos=='top'){
                $max_x = 242;
                $max_y = 318;
//              }elseif($imgPos=='right'){
//              $max_x = 222;
//              $max_y = 528;
//              }
                // cut image before resizing. Set to 0 to skip this.
                $cut_x = 0;
                $cut_y = 0;
    
                //upload image
                if (($temp_name == "")) 
                {
                    $log = 2;
                    $msg = "You must fill all fields!";
                } 
                else if (file_exists($file_path)) 
                {
                    $log = 2;
                    $msg = "File name already exist";
                } 
                else 
                {
                    // initialize
                    $img->max_x = $max_x;
                    $img->max_y = $max_y;
                    $img->cut_x = $cut_x;
                    $img->cut_y = $cut_y;
                    $img->quality = $image_quality;
                    $img->save_to_file = $save_to_file;
                   $img->image_type = $image_type;
                   // generate thumbnail
                    $img->GenerateThumbFile($temp_name, $upload_img_dir . $up_img_name);
                    $imagearray['image'] = $up_img_name;
                    $imagearray['article_id']=$inertId;
                    $imagearray['user_id']=$_POST['user_id'];
                    $ObjImages->setArrData($imagearray);
                    $imageout = $ObjImages->insert();
                     
                 }
                }
            }
                    /*$updateEdit=array();
                    $updateEdit['article_id']=$inertId;
                    $updateEdit['editor_id']=$_POST['Editer_id'];
                    $ObjArticleEdit->setArrData($updateEdit);
                    $editout = $ObjArticleEdit->insert();
                    if($editout==1){
                        $_SESSION['msg']="<div class='alert alert-success'>
                  <strong>Well done!</strong> Article Edited successfully
                </div>";
                    }*/
 $_SESSION['msg']="<div class='alert alert-success'>
                  <strong>Well done!</strong> Article Edited successfully
                </div>";
 } 
    
}

$articles=$ObjArticles->GetRowContent($_GET['id']);
$images=$ObjImages->GetRowByArticleId($_GET['id']);
$videos=$ObjVideos->GetRowByArticleId($_GET['id']);
$quiz=$ObjQuiz->SelectAllByUsingArticleId($_GET['id']);
$allfolders=$ObjFolders->SelectByUserId($articles['user_id']);
?>

<link href="css/summernote.css" rel="stylesheet">
    <link href="css/summernote-bs3.css" rel="stylesheet">
    <link href="css/wizard.css" rel="stylesheet">
    <link href="css/magnific-popup.css" rel="stylesheet">

            <div class="page-content">

                <!-- begin PAGE TITLE ROW -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1><?php echo ucfirst($action) ?> 
                                <small>Articles</small>
                            </h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="home.php">Dashboard</a>
                                </li>
                                <li><i class="fa fa-edit"></i>  <a href="vie_articles.php">Articles</a>
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
                                    <h4><?php echo ucfirst($action) ?> Articles</a></h4>
                                </div>
                                <div class="portlet-widgets">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#validationStates"><i class="fa fa-chevron-down"></i></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                            <div id="validationStates" class="panel-collapse collapse in">
                                <div class="portlet-body">
                                    <div class="il-block">
                    <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']); } ?>
                        <div class="inner-title">
                            Write Your Own Article
                        </div>
                        
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="#step-1" type="button" class="btn btn-primary btn-circle"><i class="fa fa-book"></i></a>
                <p>Articles</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-question"></i></a>
                <p>Quiz</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-picture-o"></i></a>
                <p>Images</p>
            </div>
            <div class="stepwizard-step">
                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled"><i class="fa fa-video-camera"></i></a>
                <p>Videos</p>
            </div>
        </div>
    </div>
<form role="form" id="form1" action="" method="post" enctype="multipart/form-data">
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-12">
                
                <div class="form-group">
                                <label for="exampleInputEmail1">Article Title</label>
                                <input type="text" class="form-control" name="title" value="<?php echo $articles['title']; ?>" id="exampleInputEmail1" placeholder="Enter Title">
                                <input type="hidden"  name="user_id" value="<?php echo $articles['user_id']; ?> "  >
                                <input type="hidden"  name="id" value="<?php echo $_GET['id']; ?> " >
                                <!-- <input type="hidden"  name="Editer_id" value="<?php echo $_SESSION['mypage']['user_id']; ?> " > -->
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Article</label>
                                <input type="hidden" name="description" id="bbb" value="<?php echo $articles['description']; ?>">
                                <div class="summernote"><?php echo $articles['description']; ?></div>
                            </div>
                            
                            <div class="form-inline" >
                                <div class="form-group" id="appendbox">
                                    <label for="exampleInputFile">Folder</label>
                                    <input type="hidden" name="folder_id" value="<?php echo $articles['folder_id']; ?>">
                                     <select  class="form-control" name="folder_id" disabled="true">
                                            <option value="">Folder</option>
                                                <?php
                                                
                                                    if (!empty($allfolders)) {
                                                        for ($i = 0; $i < count($allfolders); $i++) {
                                                            if ($allfolders[$i]['id'] == $articles['folder_id']) {
                                                            $selected = 'selected';
                                                            } else {
                                                            $selected = '';
                                                            }
                                                    
                                                    echo '<option '.$selected.' value="'.$allfolders[$i]['id'].'">'.$allfolders[$i]['folder_name'].'</option>';
                                                    
                                                    }
                                                    }
                                                ?>
                                        </select>
                                  
                                   <!--  <span class="p-icon"><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></a></span> -->
                                </div>

                            </div>
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-2">
    <input type="hidden"  id="count" name="count" value="<?php echo count($quiz); ?>" >
        <div class="col-xs-12">
            <div class="col-md-12">
                <div id="deletequiz"></div>
                <div class="control-group" id="fields">
           
            <div class="controls4"> 
            
            <?php for($i=0;$i<count($quiz);$i++){ ?>
            <input type="hidden" name="quiz[<?php echo $i; ?>][id]" value="<?php echo $quiz[$i]['id']; ?>">
                    <div class="entry4 form-group">
                     <div class="form-group">
                                <label for="exampleInputEmail1">Question</label>
                                <input type="text" class="form-control clonedInput" rel="question" name="quiz[<?php echo $i; ?>][question]" value="<?php echo $quiz[$i]['question']; ?>" id="exampleInputEmail1" placeholder="Enter Question">
                                
                            </div>
                             <div class="form-group">
                                <label for="exampleInputEmail1">Option 1</label>
                                <input type="text" class="form-control clonedInput" rel="option_1" name="quiz[<?php echo $i; ?>][option_1]" value="<?php echo $quiz[$i]['option_1']; ?>" id="exampleInputEmail1" placeholder="Enter Option">
                            </div> 
                            <div class="form-group">
                                <label for="exampleInputEmail1">Option 2</label>
                                <input type="text" class="form-control clonedInput" rel="option_2" name="quiz[<?php echo $i; ?>][option_2]" value="<?php echo $quiz[$i]['option_2']; ?>" id="exampleInputEmail1" placeholder="Enter Option">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Option 3</label>
                                <input type="text" class="form-control clonedInput" rel="option_3" name="quiz[<?php echo $i; ?>][option_3]" value="<?php echo $quiz[$i]['option_3']; ?>" id="exampleInputEmail1" placeholder="Enter Option">
                            </div> 
                            <div class="form-group">
                                <label for="exampleInputEmail1">Option 4</label> 
                                <input type="text" class="form-control clonedInput" rel="option_4" name="quiz[<?php echo $i; ?>][option_4]" value="<?php echo $quiz[$i]['option_4']; ?>" id="exampleInputEmail1" placeholder="Enter Option">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Answer</label>
                                <input type="text" class="form-control clonedInput" rel="answer" name="quiz[<?php echo $i; ?>][answer]" value="<?php echo $quiz[$i]['answer']; ?>" id="exampleInputEmail1" placeholder="Enter Answer">
                            </div>
                            <?php if($i==(count($quiz)-1)){ ?>
                        <button class="btn btn-success btn-add4" type="button">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                        <?php } else{ ?>

                            <button class="btn btn-danger btn-remove4" id="<?php echo $quiz[$i]['id']; ?>" type="button">
                            <span class="glyphicon glyphicon-minus"></span>
                        </button>

                        <?php }
                        ?>
                    </div>
              <?php } ?>  
           
            </div>
        </div>
                <button class="btn btn-default prevBtn btn-lg pull-left" type="button" >Prev</button>
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-3">
        <div class="col-xs-12">
            <div class="col-md-12">
                
                <div class="control-group" id="fields">
                            <label class="control-label" for="field1">Images</label>
                            <div id="deletedimage"></div>
                            <div class="imagesClass form-group"> 
                               
                                    <div class="entry2  input-group col-xs-12">
                                        <input class="form-control" name="image[]" type="file" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-add press" type="button">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                              
                            </div>
                        </div>
                        <div class="row">
                        
                        <?php $c=0; foreach($images as $img) { ?>
                   <!--  <div class="col-xs-3">
                        <img src="multimedia/article/<?php echo $img['image']; ?>" class="img-responsive img-radio">
                        <button type="button" class="btn btn-danger btn-radio">DELETE</button>
                        
                    </div> -->

                    <div class="col-xs-3  remove_<?php echo $c; ?>" >
                    <div class="panel panel-warning">
                          
                            <div class="panel-body"> 
                                <img src="../multimedia/article/<?php echo $img['image']; ?>" class="img-rounded a-img">
                               </div>
                                <div class="panel-footer clearfix">
                            <a class="image-popup-vertical-fit btn btn-success" href="../multimedia/article/<?php echo $img['image']; ?>" class="btn btn-primary" >View</a>
                           <a href="javascript:void(0);" onclick="deleteImage(<?php echo $c; ?>,'<?php echo $img['id']; ?>','<?php echo $img['image']; ?>');"><i class="fa fa-trash" style="font-size:25px;margin:0 0 0 3px;display:block;float:right;color:#da4f49"></i></a> 
                            </div>
                    </div>
                    </div>
                    <?php $c++; } ?>

                    
                   
                    </div>
                <button class="btn btn-default prevBtn btn-lg pull-left" type="button" >Prev</button>
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-4">
        <div class="col-xs-12">
            <div class="col-md-12">
               
                <div class="control-group" id="fields">
                            <label class="control-label" for="field1">Videos</label>
                            <div id="deletedVideo"></div>
                            <div class="controls form-group"> 
                               
                                    <div class="entry input-group col-xs-12">
                                        <input class="form-control" name="video[]" type="text" placeholder="Yutube Video Link" />
                                        <span class="input-group-btn">
                                            <button class="btn btn-success btn-add" type="button">
                                                <span class="glyphicon glyphicon-plus"></span>
                                            </button>
                                        </span>
                                    </div>
                              
                            </div>
                        </div>

                        <div class="row">
                        
                        <?php $d=0; foreach($videos as $vdo) { 
                                list($li, $vid) = split('v=', $vdo['video']);
                            ?>
                   <!--  <div class="col-xs-3">
                        <img src="multimedia/article/<?php echo $img['image']; ?>" class="img-responsive img-radio">
                        <button type="button" class="btn btn-danger btn-radio">DELETE</button>
                        
                    </div> -->


                    <div class="panel panel-warning col-xs-3 remove_<?php echo $d; ?>">
                          
                            <div class="panel-body"> 
                               
            <img  src="http://img.youtube.com/vi/<?php echo $vid; ?>/default.jpg" />
     
                               </div>
                                <div class="panel-footer clearfix">
                            <a class="popup-youtube btn btn-primary" href="<?php echo $vdo['video']; ?>" >View</a>
                           <a href="javascript:void(0);" onclick="deleteVideo(<?php echo $d; ?>,'<?php echo $vdo['id']; ?>');"><i class="fa fa-trash" style="font-size:25px;margin:0 0 0 3px;display:block;float:right;color:#da4f49"></i></a> 
                            </div>
                    </div>
                    <?php $d++; } ?>

                    
                   
                    </div>
                <button class="btn btn-default prevBtn btn-lg pull-left" type="button" >Prev</button>
                <input type="submit" class="btn btn-primary btn-lg pull-right" name="submit" value="Submit">
            </div>
        </div>
    </div>
</form>

                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   

                </div>

				

            </div>
           <?php include("footer.php"); ?>
<script src="js/summernote.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/bootbox.js"></script>
    <script type="text/javascript">
        $('.summernote').summernote({
        height: 200
    });
    $('#folderForm').validate({
    ignore: [],
    rules: {
        folder_name: {
            required: true
        },
        permission: {
            required: true
        }
    },
    messages: {
         folder_name: "<i class='fa fa-warning'></i> This field is required."
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
    submitHandler: function()
          {
             dataString = $('#folderForm').serialize();        
                
             $.ajax({
                type: "POST",
                url: "action/create_folder.php",              
                data: dataString,                               
                success: function(msd)
                {  
                    $('#folderId').val('');
                    $('.close').click();
                $('#appendbox').html(msd);
     
        }
             });
            
          }
});

$(document).ready(function () {


    $('#form1').validate({
    ignore: [],
    rules: { 
        title: {
            required: true
        },
        description: {
           
            required: true
        },
        folder_id: {
           
            required: true
        },
        question: {
           
            required: true
        },
        option_1: {
           
            required: true
        },
        option_2: {
           
            required: true
        },
        option_3: {
           
            required: true
        },
        option_4: {
           
            required: true
        },
        answer: {
           
            required: true
        }
    },
    messages: {
         title: "<i class='fa fa-warning'></i> This field is required.",
         description: "<i class='fa fa-warning'></i> This field is required.",
         folder_id: "<i class='fa fa-warning'></i> This field is required.",
         question: "<i class='fa fa-warning'></i> This field is required.",
         option_1: "<i class='fa fa-warning'></i> This field is required.",
         option_2: "<i class='fa fa-warning'></i> This field is required.",
         option_3: "<i class='fa fa-warning'></i> This field is required.",
         option_4: "<i class='fa fa-warning'></i> This field is required.",
         answer: "<i class='fa fa-warning'></i> This field is required."
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

/*$('#form1').submit(function () {
    $('#bbb').val($('.summernote').code());
   if($('#form1').valid()) {
   
        }else{
            return false;
        }
 });*/

$(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        var controlForm = $('.controls'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });

    $(document).on('click', '.press', function(e)
    {

        e.preventDefault();

        var controlForm2 = $('.imagesClass'),
            currentEntry2 = $(this).parents('.entry2:first'),
            newEntry2 = $(currentEntry2.clone()).appendTo(controlForm2);

        newEntry2.find('input').val('');
        controlForm2.find('.entry2:not(:last) .press')
            .removeClass('press').addClass('btn-remove2')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove2', function(e)
    {
        $(this).parents('.entry2:first').fadeOut();

        e.preventDefault();
        return false;
    });

}); 


/*-----------Wizard------ */

$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn'),
            allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
		$('#bbb').val($('.summernote').code());
		var curStep = $(this).closest(".setup-content"),
			curStepBtn = curStep.attr("id"),
			nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
			curInputs = curStep.find("input[type='text'],input[type='hidden']"),
			isValid = true;     
		if($('#form1').valid())
			nextStepWizard.removeAttr('disabled').trigger('click');
    });

    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

        $(".form-group").removeClass("has-error");
        prevStepWizard.removeAttr('disabled').trigger('click');
    });

    $('div.setup-panel div a.btn-primary').trigger('click');
});

$(function()
{
    $(document).on('click', '.btn-add4', function(e)
    {
        e.preventDefault();
        var count=$('#count').val();
        var lcount=parseInt(count)+1;
        $('#count').val(lcount);
        var controlForm4 = $('.controls4:first'),
            currententry44 = $(this).parents('.entry4:first'),
            newentry44 = $(currententry44.clone()).appendTo(controlForm4);

        newentry44.find('input').val('');
      var $inputs = newentry44.find('.clonedInput');
        $inputs.each(function() {
                //Modify the name attribute by adding the index number at the end of it
               // var ss=$(this).attr("name").split("_");
                 var tt=$(this).attr("rel");
                $(this).attr("name",'quiz['+lcount+']['+tt+']');
                //Modify the id attribute by adding the index number at the end of it
                //$(this).attr("id",$(this).attr("id") + '['+lcount+']');
            });


        controlForm4.find('.entry4:not(:last) .btn-add4')
            .removeClass('btn-add4').addClass('btn-remove4')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove4', function(e)
    {
        var count=$('#count').val();
        var lcount=parseInt(count)-1;
        $('#count').val(lcount);
        var deletequiz=document.getElementById('deletedimage').innerHTML;
        deletequiz +='<input type="hidden" name="deletequiz['+this.id+']" value="" >';
        document.getElementById('deletequiz').innerHTML=deletequiz; 
        $(this).parents('.entry4:first').remove();

        e.preventDefault();
        return false;
    });
});

$('.image-popup-vertical-fit').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
            verticalFit: true
        }
        
    });
$(document).ready(function() {
     $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,

        fixedContentPos: false
    });
});


 function deleteImage(id,imgId,name) {

    bootbox.confirm("Are you Want to delete this image?", function(result) {

        $(".remove_"+id).fadeOut();
        var deletedimage=document.getElementById('deletedimage').innerHTML;
        deletedimage +='<input type="hidden" name="deletedimage['+imgId+']" value="'+name+'" >';
        document.getElementById('deletedimage').innerHTML=deletedimage; 

}); 
            
        }

        function deleteVideo(id,imgId) {

    bootbox.confirm("Are you Want to delete this video?", function(result) {

        $(".remove_"+id).fadeOut();
        var deletedVideo=document.getElementById('deletedVideo').innerHTML;
        deletedVideo +='<input type="hidden" name="deletedVideo['+imgId+']" value="" >';
        document.getElementById('deletedVideo').innerHTML=deletedVideo; 

}); 
            
        }

    </script>
    <style>
    .btn-radio {
    width: 100%;
}
.img-radio {
    opacity: 0.5;
    margin-bottom: 5px;
}

.space-20 {
    margin-top: 20px;
}
    </style>