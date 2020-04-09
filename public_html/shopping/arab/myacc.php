<?php 
include("header_inner.php");

if($_SESSION['dream']['user_id']==""){
    header('location:logout.php');
}
if($_SESSION['dream']['type'] == 'user'){
	$getUser=$objUsers->GetRowContent($_SESSION['dream']['user_id']);
	$userName=$getUser['first_name'];
}
if($_SESSION['dream']['type'] == 'school'){
	$getUser=$objSchool->GetRowContent($_SESSION['dream']['user_id']);
	$userName=$getUser['name'];
}
if($_SESSION['dream']['type'] == 'corporate'){
	$getUser=$objCorporate->GetRowContent($_SESSION['dream']['user_id']);
	$userName=$getUser['name'];
}
$getOrder= $objOrder->SelectOrder($_SESSION['dream']['user_id'],$_SESSION['dream']['type']);
include("banner.php");
?>
	<div class="container">
		<div class="account-page">
			<div class="acc-title">حسابي</div>
			<div class="row">
				<div class="col-sm-3 myacc-links">
					<ul class="nav nav-pills nav-stacked">
					  <li class="active"><a data-toggle="pill" href="#home"><i class="fa fa-home"></i> حسابي</a></li>
					    <?php if($_SESSION['dream']['type'] == 'user'){ ?>
					  <li><a data-toggle="pill" href="#menu1"><i class="fa fa-user"></i> تعديل الملف الشخصي</a></li>
					  <?php
					  }
					  ?>
					  <li><a data-toggle="pill" href="#menu2"><i class="fa fa-clock-o"></i> تاريخ الطلب</a></li>
					  <!--<li><a data-toggle="pill" href="#menu3"><i class="fa fa-lock"></i> Change Password</a></li>-->
					</ul>
				</div>

				<div class="col-sm-9 myacc-content">
					<div class="tab-content">
					  <div id="home" class="tab-pane fade in active ">
					    <h3>حسابي الصفحة</h3>
					    <table cellpadding="0" cellspacing="0" class="table table-bordered">
							<?php if($_SESSION['dream']['type'] == 'school'){ ?>
                            <tbody>
                                <tr>
                                    <td><b>اسم المدرسة</b></td>
                                    <td><?php echo $getUser['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>عنوان البريد الإلكتروني</b></td>
                                    <td><?php echo $getUser['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>هاتف</b></td>
                                    <td><?php echo $getUser['phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> عنوان</b></td>
                                    <td><?php echo $getUser['address']; ?>   </td>
                                </tr>
								<tr>
                                    <td><b> وصف</b></td>
                                    <td><?php echo $getUser['description_arb']; ?>   </td>
                                </tr>
                            </tbody>
							<?php }
							if($_SESSION['dream']['type'] == 'corporate'){ ?>
                            <tbody>
                                <tr>
                                    <td><b>اسم الشركة</b></td>
                                    <td><?php echo $getUser['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>عنوان البريد الإلكتروني</b></td>
                                    <td><?php echo $getUser['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>هاتف</b></td>
                                    <td><?php echo $getUser['phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> عنوان</b></td>
                                    <td><?php echo $getUser['address']; ?>   </td>
                                </tr>
								<tr>
                                    <td><b> وصف</b></td>
                                    <td><?php echo $getUser['description_arb']; ?>   </td>
                                </tr>
                            </tbody>
							<?php }
							if($_SESSION['dream']['type'] == 'user'){ ?>
                            <tbody>
                                <tr>
                                    <td><b>اسم</b></td>
                                    <td><?php echo $getUser['first_name']; ?></td>
                                </tr>
				<tr>
                                    <td><b>الكنية</b></td>
                                    <td><?php echo $getUser['last_name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>عنوان البريد الإلكتروني</b></td>
                                    <td><?php echo $getUser['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>هاتف</b></td>
                                    <td><?php echo $getUser['phone']; ?></td>
                                </tr>
                            </tbody>
							<?php }?>
                        </table>
					  </div>
					  <div id="menu1" class="tab-pane fade">
				<h3>Edit Profile</h3>
				<table cellpadding="0" cellspacing="0" class="table table-bordered">
				     <form class="form-horizontal" role="form" action="action/edit-account.php" method="post" id="EditregisterForm">
                                             <table cellpadding="0" cellspacing="0" class="table table-striped">
						<tr>
						    <td><b>الاسم الاول:</b></td>
						    <td>
							<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $getUser['first_name']; ?>" placeholder="Enter First Name">
							<input type="hidden" name="id" value="<?php echo $_SESSION['dream']['user_id']; ?>">
						    </td>
						</tr>
						
						<tr>
						    <td><b>الكنية:</b></td>
						    <td>
							<input type="text" class="form-control" id="last_name" value="<?php echo $getUser['last_name']; ?>" placeholder="Enter Last Name" name="last_name">
						    </td>
						</tr>
						<tr>
						    <td><b>عنوان البريد الإلكتروني:</b></td>
						    <td>
							<input type="text" class="form-control" id="email" value="<?php echo $getUser['email']; ?>" name="email" placeholder="Enter email">
						    </td>
						</tr>
						<tr>
						    <td><b>هاتف:</b></td>
						    <td>
							<input type="text" class="form-control" id="" value="<?php echo $getUser['phone']; ?>" placeholder="Enter phone" name="phone">
						    </td>
						</tr>
						<tr>
							<td></td>
							<td>
							    <input type="submit" class="btn btn-update" value="Update" name="edit">
							</td>
						    </tr>
					     </table>
				     </form>
				</table>
				<tbody>
			    </div>
					 
					  <div id="menu2" class="tab-pane fade">
					    <h3>تاريخ الطلب</h3>
						    <div class="o-box">
	                            <div class="o-head">
	                                <div class="o-num">رقم سري</div>
	                                <div class="o-pro">المنتج</div>
	                                <div class="o-tot">مجموع</div>
	                                <div class="o-dat">تاريخ</div>
	                                <div class="o-tran">رقم التعريف الخاص بالطلب</div>
	                                <div class="o-st">الحالة</div>
	                            </div>
								<div class="o-content">
								<?php if($getOrder){
										for($i = 0; $i < count($getOrder) ; $i++){?>
									<div class="o-num"><?php echo $i+1;?></div>
									<div class="o-pro"><?php $pid=$getOrder[$i]['id'];
									$Det = $objOrderDetails->SelectOrderDetails($pid);
									for($k=0;$k<count($Det);$k++) {
										$oid = $Det[$k]['orderid'];
										$qn = $Det[$k]['quantity'];
										$pr = $Det[$k]['price'];
										$sz=$Det[$k]['size'];
										$oidarray = explode(",", $oid);
										$qnarray = explode(",", $qn);
										$prarray = explode(",", $pr);
										for ($j = 0; $j < count($oidarray); $j++) {
											$oid1 = $oidarray[$j];
											$price = number_format((float)$prarray[$j], 2, '.', '');
											echo $name = $Det[$k]['pname'] . " <br>(Qnt: " . $qnarray[$j] . ", AED " . $price . ",Size: " . $sz . " )<br> ";
										}
									}?><span class="pro-clear"></span></div>
									<div class="o-tot"><?php echo number_format((float)$getOrder[$i]['total'] , 2, '.', '');?></div>
									<div class="o-dat"><?php echo $getOrder[$i]['date'];?></div>
									<div class="o-tran"><?php echo $getOrder[$i]['transactionid'];?></div>
									<div class="o-st"><?php echo $getOrder[$i]['status'];?></div>
								<?php }
									}?>
								</div>
							</div>
					  	</div>
					  
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>
<?php include("footer_inner.php");?>