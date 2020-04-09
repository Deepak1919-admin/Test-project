<?php
ob_start();
include 'header.php';
$objOrder = load_class('Order');
$objOrderDetails=load_class('OrderDetails');

$objCorporate = load_class('Corporate');
$objSchool = load_class('School');
$objUsers = load_class('Users');
$GetAllSchool = $objSchool ->SelectAll();
$ObjProduct= load_class('Product');
$getallProduct = $ObjProduct->SelectAll();

$pagename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
if (isset($_REQUEST['hidDelete']) && $_REQUEST['hidDelete'] != '') {
    $ObjProduct->DelRowContent($_REQUEST['hidDelete']);
    header("location:$pagename");
}
if (isset($_POST['change_disp_pos'])) {
    $ObjProduct->ChangePosition($_POST['cur_disp_pos'], $_POST['change_disp_pos']);
}
// $getallProduct = $ObjProduct->SelectAll();
// $getCount = count($getallProduct);
?>

<?php 
/*if($_POST['submit'])
{
$objOrder->setArrData($_POST);
$GetAllOrders=$objOrder->FilterSoldOrder();
}
else
{
//$GetAllOrders = $objOrder->getLatest();
}*/

?>


<div class="page-content">

    <!-- begin PAGE TITLE ROW -->
    <div class="row">
        <div class="col-lg-12">
            <div class="page-title">
                <h1>View Product </h1>

                <ol class="breadcrumb">
                    <li><i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active"><a href="<?php echo currenturl() ?>">View Orders</a></li>
                </ol>
<form name="fform" action="" id="fform" method="post">
<div class="col-sm-12">

<div class="col-sm-3">
<input class="form-control datepicker" type="text"  name="f_date" id="f_date" placeholder="From Date">
</div>

<div class="col-sm-3">
<input class="form-control datepicker" type="text"  name="t_date" id="t_date" placeholder="To Date">
</div>


<div class="col-sm-3">
<input type="submit" class="btn btn-default btnfilter"  name="submit" id="submit" value="Filter">
</div>


</div>

</form>
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
                        <h4>View Product</h4>
                    </div>
                    <div class="clearfix"></div>
                </div>



                <div class="portlet-body">
                    <div class="table-responsive">
                            <table id="example-table" class="table table-striped table-bordered table-hover table-green">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    
                                    <th>Product Sold</th>
                                    
                                </tr>
                                </thead>
                                <tbody id="sld">
                                
                                </tbody>
                            </table>

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

<link href="css/jquery-ui.css" rel="stylesheet">

<script type="text/javascript" src="js/jquery-ui.js"></script>

<script>
inload();
$("#fform").validate({
             rules:
                    {	
                    
                    	 f_date1:
                        {
                            required: true
                        }, 
                        t_date1:
                        {
                            required: true,
                            email:true
                        } 
                        
                        
    },
errorPlacement: function(error,element) {
            element.attr('placeholder',error.text());
        },
         submitHandler: function()
          {
             dataString = $('#fform').serialize();        
                
             $.ajax({
                type: "POST",
                url: "inventoryfilter.php",              
                data: dataString,                               
                success: function(msd)
                {  
                // alert(msd);
            document.getElementById('sld').innerHTML=msd;
    
                 }
             })
          }      
          
});

function inload()
{
 $.ajax({
                type: "POST",
                url: "invntry_onload.php",              
                                          
                success: function(msg)
                {  
                // alert(msg);
            document.getElementById('sld').innerHTML=msg;
    
                 }
             })
}

    function delportfolio(id, thisform)
    {
        var agree = confirm("Are you sure you want to delete this Product?");
        if (agree) {
            document.getElementById("hidDelete").value = id;
            thisform.submit();
        } else {
            return false;
        }
    }

$(document).ready( function () {
  $('#example-table').dataTable({
    "bSort": false
  });
});

$("#f_date").datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });

$("#t_date").datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });

$("#p_date").datepicker({
        dateFormat:"yy-mm-dd",
        changeMonth: true,
        changeYear: true

    });
</script>