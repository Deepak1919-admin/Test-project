	<div class="footer">
		<div class="container">
			<div class="foot-text">
				<div class="foot-logo"><img src="images/foot-logo.png"></div>
				<div class="foot-links">
					<ul>
<?php for($i=0;$i<count($getFooterMenu);$i++){
echo '<li><a href="inner.php?mmid='.$getFooterMenu[$i]['id'].'">'.$getFooterMenu[$i]['title'].'</a></li>';
}?>
					</ul>
				</div>
				<div class="detail-copy">Copyright 2016. All Rights Reserved</div>
			</div>
		</div>
	</div>
		
		
		
	<script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.bxslider.min.js"></script>
	<script src="js/jquery.magnific-popup.js"></script>
	<script src="js/jquery.elevateZoom-3.0.8.min.js"></script>
    <script src="js/jquery.flexslider.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script type="text/javascript">
	
	$(window).load(function() {
		 $('#thumbslide').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			slideshow: false,
			itemWidth: 120,
			itemMargin: 4,
			asNavFor: '#bigslider'
		});

		$('#bigslider').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: false,
			directionNav: false,
			slideshow: false,
			sync: "#thumbslide",
			start: function(slider){
				$('body').removeClass('loading');
				$("#bigslider li.flex-active-slide img").addClass('zoomer');
				var imgo = $('.zoomer');  
			    imgo.elevateZoom({
					cursor: 'crosshair', borderSize: 1, zoomType: 'inner', scrollZoom : true
			  });
			}
		});
	  
		$('#thumbslide li').on('click', function() {
			$('.zoomContainer').remove();
			$("#bigslider li img").removeClass('zoomer');
			$("#bigslider li div").removeClass('zoomWrapper');
			 $("#bigslider li.flex-active-slide div").addClass('zoomWrapper');
			$("#bigslider li.flex-active-slide img").addClass('zoomer');
			var imgo = $('.zoomer');
			imgo.removeData('elevateZoom');
			imgo.removeData('zoomImage');
			imgo.elevateZoom({
				cursor: 'crosshair', borderSize: 1, zoomType: 'inner', scrollZoom : true
			});
		});
	  
	});
	  
</script>
	 
	</body>
</html>