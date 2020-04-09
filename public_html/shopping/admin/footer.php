<!-- /.page-content -->
				<div class="copy">
					Developed by <a href="http://a2solution.com">A2 Solutions</a>
				</div>

        </div>
        <!-- /#page-wrapper -->
        <!-- end MAIN PAGE CONTENT -->

    </div>
    <!-- /#wrapper -->

    <!-- GLOBAL SCRIPTS -->
    <script src="js/jquery-2.1.3.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
	<script src="js/jquery.dataTables.js"></script>
    <script src="js/datatables-bs3.js"></script>
    <!-- Logout Notification Box -->
    <!-- /#logout -->
    <!-- PAGE LEVEL PLUGIN SCRIPTS -->
	<script>
		$(document).ready(function() {
			function setHeight() {
				windowHeight = $(window).innerHeight();
				$('#page-wrapper').css('min-height', windowHeight - 50);
			};			
			setHeight();
			$(window).resize(function() {
				setHeight();
			});
			$(document).ready(function() {
				$('#example-table').dataTable();
			});
		});
	</script>

</body>

</html>
