<?php
include("header_inner.php");
//$getArticle = $objArticle->GetRowContentByMenu($_GET['mmid']);
include("banner.php");
?>	
<div class="content">
		<div class="container">
			<div class="page-content">
			<h2 class="page-title">tailles disponibles</h2>
				<?php echo $school_dt['size_french'];?>
			</div>
		</div>
	</div>
<?php include("footer_inner.php"); ?>