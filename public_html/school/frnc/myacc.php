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
			<div class="acc-title">Mon compte</div>
			<div class="row">
				<div class="col-sm-3 myacc-links">
					<ul class="nav nav-pills nav-stacked">
					  <li class="active"><a data-toggle="pill" href="#home"><i class="fa fa-home"></i> Mon compte</a></li>
					  <?php if($_SESSION['dream']['type'] == 'user'){ ?>
					  <li><a data-toggle="pill" href="#menu1"><i class="fa fa-user"></i> Modifier le profil</a></li>
					  <?php
					  }
					  ?>
					  <li><a data-toggle="pill" href="#menu2"><i class="fa fa-clock-o"></i> Historique des commandes</a></li>
					  <li><a data-toggle="pill" href="#menu3"><i class="fa fa-lock"></i> Changer le mot de passe</a></li>
					</ul>
				</div>

				<div class="col-sm-9 myacc-content">
				<?php if($_SESSION['msg']){

                echo $_SESSION['msg'];

               unset($_SESSION['msg']);

              }?>
					<div class="tab-content">
					  <div id="home" class="tab-pane fade in active ">
					    <h3>My Account Page</h3>
					    <table cellpadding="0" cellspacing="0" class="table table-bordered">
							<?php if($_SESSION['dream']['type'] == 'school'){ ?>
                            <tbody>
                                <tr>
                                    <td><b>Nom de l'�cole</b></td>
                                    <td><?php echo $getUser['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> Adresse e-mail</b></td>
                                    <td><?php echo $getUser['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>T�l�phone</b></td>
                                    <td><?php echo $getUser['phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> Adresse</b></td>
                                    <td><?php echo $getUser['address']; ?>   </td>
                                </tr>
								<tr>
                                    <td><b> La description</b></td>
                                    <td><?php echo $getUser['description']; ?>   </td>
                                </tr>
                            </tbody>
							<?php }
							if($_SESSION['dream']['type'] == 'corporate'){ ?>
                            <tbody>
                                <tr>
                                    <td><b>Nom de la SOCIETE</b></td>
                                    <td><?php echo $getUser['name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> Adresse e-mail</b></td>
                                    <td><?php echo $getUser['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>T�l�phone</b></td>
                                    <td><?php echo $getUser['phone']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> Adresse</b></td>
                                    <td><?php echo $getUser['address']; ?>   </td>
                                </tr>
								<tr>
                                    <td><b> La description</b></td>
                                    <td><?php echo $getUser['description'];?>   </td>
                                </tr>
                            </tbody>
							<?php }
							if($_SESSION['dream']['type'] == 'user'){ ?>
                            <tbody>
                                <tr>
                                    <td><b>Pr�nom</b></td>
                                    <td><?php echo $getUser['first_name']; ?></td>
                                </tr>
				<tr>
                                    <td><b>Nom de famille</b></td>
                                    <td><?php echo $getUser['last_name']; ?></td>
                                </tr>
                                <tr>
                                    <td><b> Adresse e-mail</b></td>
                                    <td><?php echo $getUser['email']; ?></td>
                                </tr>
                                <tr>
                                    <td><b>T�l�phone</b></td>
                                    <td><?php echo $getUser['phone']; ?></td>
                                </tr>
                            </tbody>
							<?php }?>
                        </table>
					  </div>
					  
					  
			    <div id="menu1" class="tab-pane fade">
				<h3>Modifier le profil</h3>
				<table cellpadding="0" cellspacing="0" class="table table-bordered">
				     <form class="form-horizontal" role="form" action="action/edit-account.php" method="post" id="EditregisterForm">
                                             <table cellpadding="0" cellspacing="0" class="table table-striped">
						<tr>
						    <td><b>Pr�nom:</b></td>
						    <td>
							<input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $getUser['first_name']; ?>" placeholder="Enter Pr�nom">
							<input type="hidden" name="id" value="<?php echo $_SESSION['dream']['user_id']; ?>">
						    </td>
						</tr>
						<tr>
						    <td><b>Nom de famille:</b></td>
						    <td>
							<input type="text" class="form-control" id="last_name" value="<?php echo $getUser['last_name']; ?>" placeholder="Enter Nom de famille" name="last_name">
						    </td>
						</tr>
						<tr>
						    <td><b> Adresse e-mail:</b></td>
						    <td>
							<input type="text" class="form-control" id="email" value="<?php echo $getUser['email']; ?>" name="email" placeholder="Enter email">
						    </td>
						</tr>
						<tr>
						    <td><b>T�l�phone:</b></td>
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
					    <h3>Ordre Histroy</h3>
						    <div class="o-box">
	                            <div class="o-head">
	                                <div class="o-num">SI No</div>
	                                <div class="o-pro">PRODUIT</div>
	                                <div class="o-tot">Total</div>
	                                <div class="o-dat">date</div>
	                                <div class="o-tran">num�ro de commande</div>
	                                <div class="o-st">statut</div>
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
					  	<div id="menu3" class="tab-pane fade">
					    	<h3>Changer le mot de passe</h3>
					    	<form action="action/change-password.php" method="post" class="form-horizontal" role="form">
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="pwd">ancien mot de passe:</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="passwordr" placeholder="Enter Old password" name="oldPassword" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="pwd">Mot de passe:</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="password3" placeholder="Enter  Password" name="password" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-4" for="pwd">Confirmez le mot de passe:</label>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control" id="password4" placeholder="Enter  Confirm Password" name="password4" required="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-4 col-sm-6">
                                        <input type="submit" class="btn btn-update" value="Update" name="edit">
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
<?php include("footer_inner.php");?>