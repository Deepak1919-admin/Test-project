<?php
ob_start();
//$page='view_menu';
include 'header.php';
$objMenu = load_class('Menu');
$getMainMenu = $objMenu->GetMainMenu();
$getMainMenuCount = count($getMainMenu);
$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {
    $objMenu->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
if (isset($_POST['change_disp_pos'])) {
    $objMenu->ChangePosition($_POST['cur_disp_pos'], $_POST['change_disp_pos']);
}
$GetAllMenus = $objMenu->GetAllMenus();
?>
            <div class="page-content">
                <!-- begin PAGE TITLE ROW -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="page-title">
                            <h1>View Menu</h1>
                            <ol class="breadcrumb">
                                <li><i class="fa fa-dashboard"></i><a href="index.html">Dashboard</a></li>
                                <li class="active"><a href="<?php echo currenturl() ?>">Menu</a></li>
								<li class="active"><a href="<?php echo currenturl() ?>">View Menu</a></li>
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
                                    <h4>View Menu</h4>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-responsive">
                                    <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Parent Menu</th>
                                                <th>Header View</th>
                                                <th>Footer View</th>
                                                <th>Date registered</th>
                                                <th>Order</th>
                                                 <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php
                        if($GetAllMenus){
                        for ($i = 0; $i < count($GetAllMenus); $i++) {
                            if ($GetAllMenus[$i]['parent_id'] != '0') {
                                $getParentMenu = $objMenu->GetRowContent($GetAllMenus[$i]['parent_id']);
                                $parentMenu = $getParentMenu['title'];
                            } else {
                                $parentMenu = 'Parent Menu';
                            }
                            if ($GetAllMenus[$i]['header_view'] == '1') {
                                $header_view = '<span class="label label-success">Active</span>';
                            } else {
                                $header_view = '<span class="label label-warning">Inctive</span>';
                            }
                            if ($GetAllMenus[$i]['footer_view'] == '1') {
                                $footer_view = '<span class="label label-success">Active</span>';
                            } else {
                                $footer_view = '<span class="label label-warning">Inctive</span>';
                            }
                            ?>
                            <tr class="odd gradx">
                                <td><?php echo $GetAllMenus[$i]['title'] ?></td>
                                <td class="center"><?php echo $parentMenu ?></td>
                                <td class="center"><?php echo $header_view ?></td>
                                <td class="center"><?php echo $footer_view ?></td>
                                <td class="center"><?php echo date_format_list($GetAllMenus[$i]['date_added']) ?></td>
                                <td>
								<?php if($GetAllMenus[$i]['header_view']!=0){?>
                                    <form name="frmDisplay" method="post" style="width: 50px;float:left;margin:0 10px 0 0">
                                        <input type="hidden" name="cur_disp_pos" value="<?php echo $GetAllMenus[$i]['display_order'] ?>">
                                        <?php
                                        if ($GetAllMenus[$i]['parent_id'] == '0') {
                                            echo "<select clas='form-control' style='width:50px' name='change_disp_pos' onChange='this.form.submit()'>";
                                            for ($j = 1; $j <= $getMainMenuCount; $j++) {
                                                if ($GetAllMenus[$i]['display_order'] == $j) {
                                                    $selected = 'selected';
                                                } else {
                                                    $selected = '';
                                                }
                                                echo '<option ' . $selected . ' value="' . $j . '">' . $j . '</option>';
                                            }
                                            echo '</select>';
                                        }
                                        ?>
                                    </form>
								<?php }?>
                                </td>
								<td class="center">
									<a  href="add_edit_menu.php?id=<?php echo $GetAllMenus[$i]['id'] ?>"><i class="fa fa-edit"></i></a> 
									<a  href="#" onclick="delportfolio('<?php echo $GetAllMenus[$i]['id']; ?>', document.frm1)"> <i class="fa fa-times"></i></a>
								</td>
							</tr>
                            <?php
                        }
                        }
                        ?>
                                        </tbody>
                                    </table>
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