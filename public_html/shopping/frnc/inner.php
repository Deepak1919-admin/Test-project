<?php
include("header_inner.php");
$getArticle = $objArticle->GetRowContentByMenu($_GET['mmid']);
include("banner.php");
?>	
<div class="content">
		<div class="container">
			<div class="page-content">
			<h2 class="page-title"><?php echo $getArticle['title']; ?></h2>
				<?php echo $getArticle['editor'];?>
			</div>
		</div>
	</div>
<?php include("footer_inner.php"); ?>