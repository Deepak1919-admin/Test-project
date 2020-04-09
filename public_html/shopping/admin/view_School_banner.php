<?php
ob_start();
include 'header.php';
$objInnBanner = load_class('InnerBanner');
$objSchool = load_class('School');
$objMenu = load_class('Menu');

$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {

    $objInnBanner->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
if (isset($_POST['change_disp_pos'])) {
    $objInnBanner->ChangePosition($_POST['cur_disp_pos'], $_POST['change_disp_pos']);
}
$GetAllBanner = $objInnBanner->SelectAll();
if(isset($_POST["submit"])){
	if($_POST["school_id"]!=""){
		$GetAllBanner = $objInnBanner->GetRowbySchool($_POST['school_id']);
	}
}
$getBannerCount = count($GetAllBanner);
$GetAllSchool = $objSchool->SelectAll();
?>

    <div class="page-content">
        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1>View Category

                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a></li>
                        <li class="active"><a href="<?php echo currenturl() ?>">Banner</a></li>
                        <li class="active"><a href="<?php echo currenturl() ?>">View Banner</a></li>
                    </ol>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- end PAGE TITLE ROW -->
        <!-- begin ADVANCED TABLES ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="portlet portlet-default">
                    <div class="portlet-heading">
                        <div class="portlet-title">
                            <h4>View Category</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
						<div class="panel panel-default clearfix">
							<form name="view_form" method="POST" action="view_School_banner.php" id="view_form" >
								<div class="panel-heading">View by School</div>
								<div class="panel-body">
									<div class="control-group" id="fields">
										<label class="control-label col-sm-2" for="field1">School </label>
										<div class="imagesClass form-group  col-xs-5">
											<select class="form-control" id="school_id" name="school_id">
												<option value="">Select school</option>
												<option value="0">Common</option>
												<?php foreach($GetAllSchool as $school){?>
												<option value="<?php echo $school['id']; ?>" ><?php echo $school['name']; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="imagesClass form-group  col-xs-5">
											<input type="submit" value="Submit" class="btn btn-default pull-right" name="submit" />
										</div>
									</div>
								</div>
							</form>
						</div>
                        <div class="table-responsive">
                            <?php if(!empty($GetAllBanner)){ ?>
                                <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>School </th>
                                        <th>Menu </th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    for ($i = 0; $i < count($GetAllBanner); $i++) {


                                        ?>
                                        <tr class="odd gradx">
                                            <td><?php echo $GetAllBanner[$i]['title'] ?></td>
                                            <td>
												<?php if($GetAllBanner[$i]['school_id']!=0){
														$schoolDt = $objSchool->GetRowContent($GetAllBanner[$i]['school_id']);
														echo $schoolDt['name'];
													}else {
														echo 'Common'; 
													}?>
											</td>
                                            <td><?php $menuDt = $objMenu->GetRowContent($GetAllBanner[$i]['menu_id']); 
												echo $menuDt['title']; ?>
											</td>
                                            <td class="center">
												<img src="<?php echo "../multimedia/Innerbanner/".$GetAllBanner[$i]['image'] ?>" width="50">
											</td>
                                            <td class="center">
                                                <a  href="add_edit_School_banner.php?id=<?php echo $GetAllBanner[$i]['id'] ?>"><i class="fa fa-edit"></i></a>
                                                <a  href="#" onclick="delportfolio('<?php echo $GetAllBanner[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php

                                    }
                                    ?>
                                    </tbody>
                                </table>
                            <?php }else{
                                echo '<tr class="odd gradx"><td colspan="5"><div class="alert alert-info">No results found</div></td></tr>';
                            } ?>
                            <form name="frm1" action="">
                                <input type="hidden" id="hidDelete" name="hidDelete" value="" />
                            </form>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.portlet-body -->
                </div>
                <!-- /.portlet -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
<?php include("footer.php"); ?>
<script>
function delportfolio(id, thisform)
{
	var agree = confirm("Are you sure you want to delete this Banner?");
	if (agree) {
		document.getElementById("hidDelete").value = id;
		thisform.submit();
	} else {
		return false;
	}
}
</script>