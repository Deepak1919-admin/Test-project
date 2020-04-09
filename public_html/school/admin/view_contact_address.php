<?php

ob_start();

//$page='view_menu';

include 'header.php';

$id=$_GET['id'];

$objContact = load_class('Contactaddress');

$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);

if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {

    $objContact->DelRowContent($_REQUEST['hidDelete']);

    header("location:$pagename");

}



$GetContactDetails = $objContact->SelectAll();

?>


    <div class="page-content">
        <!-- begin PAGE TITLE ROW -->
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                    <h1>View Address

                    </h1>
                    <ol class="breadcrumb">
                        <li><i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                        </li>
                        <li class="active"><a href="<?php echo currenturl() ?>">Address</a></li>
                        <li class="active"><a href="<?php echo currenturl() ?>">View Address</a></li>
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
                            <h4>View Address</h4>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-responsive">
                            <?php if(!empty($GetContactDetails)){ ?>
                                <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                    <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    for ($i = 0; $i < count($GetContactDetails); $i++) {


                                        ?>
                                        <tr class="odd gradx">
                                            <td><?php echo $GetContactDetails[$i]['email'] ?></td>
                                            <td><?php echo $GetContactDetails[$i]['address'] ?></td>

                                            <td class="center">
                                                <a  href="add_edit_contact_address.php?id=<?php echo $GetContactDetails[$i]['id'] ?>"><i class="fa fa-edit"></i></a>
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
            var agree = confirm("Are you sure you want to delete this Category?");
            if (agree) {
                document.getElementById("hidDelete").value = id;
                thisform.submit();
            } else {
                return false;
            }
        }
    </script>


