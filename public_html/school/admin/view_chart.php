<?php
ob_start();
include 'header.php';
$objChart = load_class('Chart');
$objItem = load_class('Item');

$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {

    $objChart->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
if (isset($_POST['change_disp_pos'])) {
    $objChart->ChangePosition($_POST['cur_disp_pos'], $_POST['change_disp_pos']);
}
$GetAllChart = $objChart->SelectAll();
$getBannerCount = count($GetAllChart);
?>

    <div class="page-content">
        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1>View Size Chart

                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active"><a href="<?php echo currenturl() ?>">Size Chart</a></li>
                        <li class="active"><a href="<?php echo currenturl() ?>">View Size Chart</a></li>
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
                            <h4>View Size Chart</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <?php if(!empty($GetAllChart)){ ?>
                                <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Item</th>
                                        <th>Image</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php for ($i = 0; $i < count($GetAllChart); $i++) { 
											$GetAllItem = $objItem->GetRowContent($GetAllChart[$i]['item_id']);?>
                                        <tr class="odd gradx">
                                            <td><?php echo $GetAllChart[$i]['title'] ?></td>
                                            <td><?php echo $GetAllItem['title'] ?></td>
                                            <td class="center"><img src="<?php echo "../multimedia/chart/".$GetAllChart[$i]['image'] ?>" width="50"></td>
                                            <td class="center">
                                                <a  href="add_edit_chart.php?id=<?php echo $GetAllChart[$i]['id'] ?>"><i class="fa fa-edit"></i></a>
                                                <a  href="#" onclick="delportfolio('<?php echo $GetAllChart[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                    <?php } ?>
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





















========================================


<?php

ob_start();
include 'header.php';
$objChart = load_class('Banner');
$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {

    $objChart->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
$GetAllChart = $objChart->SelectAll();

?>

<!-- content starts -->
<div id="content" class="span10">
    <div>
        <ul class="breadcrumb">
            <li>
                <a href="home.php">Home</a> <span class="divider">/</span>
            </li>
            <li>
                <a href="<?php echo currenturl() ?>">View Banner</a>
            </li>
        </ul>
    </div>
    <div class="row-fluid sortable">		
        <div class="box span12">
            <div class="box-header well" data-original-title>
                <h2><i class="icon-list-alt"></i> Banner</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>
                    <a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
                </div>
            </div>
            <div class="box-content">
                <table class="table table-striped table-bordered bootstrap-datatable datatable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>   
                    <tbody>
                        <?php
                        if ($GetAllChart) {
                            for ($i = 0; $i < count($GetAllChart); $i++) { ?>
                                <tr>
                                    <td><?php echo $GetAllChart[$i]['title'] ?></td>
                                    <td class="center">
   								    	<?php if($GetAllChart[$i]['image']): ?>
   								    	<img src="<?php echo"../multimedia/banner/".$GetAllChart[$i]['image']?>" height="75" width="75">
   								    	<?php else: echo '<i>Not Avilable</i>'; endif; ?>
   								    </td>
                                    <td class="center">
                                        <div style="float: left">
                                            <a class="btn btn-success" href="add_edit_banner.php?id=<?php echo $GetAllChart[$i]['id'] ?>">
                                                <i class="icon-zoom-in icon-white"></i> View  </a>
                                            <a class="btn btn-info" href="add_edit_banner.php?id=<?php echo $GetAllChart[$i]['id'] ?>">
                                                <i class="icon-edit icon-white"></i>  Edit </a>
                                            <a class="btn btn-danger" href="#" onclick="delportfolio('<?php echo $GetAllChart[$i]['id']; ?>', document.frm1)">
                                                <i class="icon-trash icon-white"></i> Delete </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                        }?>
                    </tbody>
                </table> 
                <form name="frm1" action="">
                    <input type="hidden" id="hidDelete" name="hidDelete" value="" />
                </form>
            </div>
        </div><!--/span-->
    </div><!--/row-->
</div><!-- content ends --> <!--/#content.span10-->
<script>

function delportfolio(id, thisform){
	var agree = confirm("Are you sure you want to delete this news?");
	if (agree) {
		document.getElementById("hidDelete").value = id;
		thisform.submit();
	} else {
		return false;
	}
}
</script>
<?php include 'footer.php'; ?>