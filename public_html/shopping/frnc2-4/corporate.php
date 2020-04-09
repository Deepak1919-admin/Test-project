<?php
include("header_inner.php");
$corp_id = $_SESSION['dream']['user_id'];
$corp_dt = $objCorporate->GetRowContent($corp_id);
?>
		<div class="detail-ban"><img src="multimedia/corporate/<?php echo $corp_dt['banner']; ?>"></div>
		<div class="container">
			<div class="prfl-head">Welocme to <?php echo $corp_dt['name']; ?></div>
			<div class="prfl-text">
				<?php echo $corp_dt['description']; ?>
			</div>
			<div class="prfl-head"><img src="images/grp-pic.png"></div>
		</div>
<?php include("footer_inner.php"); ?>