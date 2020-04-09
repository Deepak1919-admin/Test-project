<?php
ob_start();
include 'header.php';
$objMenu = load_class('Menu');
$objArticles = load_class('Articles');
$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {
    $objArticles->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
$GetAllArticles = $objArticles->SelectAll();
?>

            <div class="page-content">

                <!-- begin PAGE TITLE ROW -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>View Articles
                                
                            </h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                                </li>
                                <li class="active"><a href="<?php echo currenturl() ?>">Articles</a></li>
                                 <li class="active"><a href="<?php echo currenturl() ?>">View Articles</a></li>
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
                                    <h4>View Articles</h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                <?php if(!empty($GetAllArticles)){ ?>
                                    <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Article</th>
                                                <th>Writer</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                                     
                        for ($i = 0; $i < count($GetAllArticles); $i++) {
                            $user = $ObjUser->GetRowContent($GetAllArticles[$i]['user_id']);
                            
                            ?>
                            <tr class="odd gradx">
                                 <td><?php echo $GetAllArticles[$i]['title'] ?></td>
                                
                                <td class="center"><?php echo getSubString($GetAllArticles[$i]['description'],0,50,NULL,NULL,NULL) ?></td>
                                <td class="center"><?php echo $user['fname'] ?></td>
                                <td class="center"><?php echo date_format_list($GetAllArticles[$i]['date_added']) ?></td>
                                                <td class="center">

                                                 <a  href="add_edit_article.php?id=<?php echo $GetAllArticles[$i]['id'] ?>"><i class="fa fa-edit"></i></a> 
                                                 <a  href="#" onclick="delportfolio('<?php echo $GetAllArticles[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
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
            var agree = confirm("Are you sure you want to delete this article?");
            if (agree) {
            document.getElementById("hidDelete").value = id;
            thisform.submit();
            } else {
            return false;
            }
            }
</script>