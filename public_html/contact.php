<?php include 'header.php'; ?>
	


	
	<div id="content-area">
	
		<div class="grid_6">
		
					
		
		<h4> Address</h4>		
				
		Dream Uniforms LLC <br />
	P.O.Box: 52345, Dubai, United Arab Emirates. <br />
	Tel. +971 4 3340494 Fax. +971 4 3370412 <br />
		Toll Free Number : 800 UNIFORMS <br />
	Email. enquiry@dreamuniforms.ae <br /> <br /><br />
	
								
				<h4> Enquiry Form </h4>
												
				<div id="contact-wrapper">
<div id="response" class='alert' style="diplay:none;color:green"></div>
				
				<form method="post" id="contactform" name="contactform">
					<div>
					    <label for="name"><strong>Name:</strong></label>
						<input type="text" size="50" name="contactname" id="contactname" value="" class="required" />
					</div>

					<div>
						<label for="email"><strong>Email:</strong></label>
						<input type="text" size="50" name="email" id="email" value="" class="required email" />
					</div>

					<div>
						<label for="subject"><strong>Subject:</strong></label>
						<input type="text" size="50" name="subject" id="subject" value="" />
					</div>

					<div>
						<label for="message"><strong>Message:</strong></label>
						<textarea rows="5" cols="50" name="message" id="message" class="required"></textarea>
					</div>
				    <input type="submit" value="Send" name="submit" />
				</form>
				</div>




		</div>
	
		<div class="grid_10">	
			<a href="http://maps.google.com/maps/ms?ie=UTF8&amp;hl=en&amp;source=embed&amp;msa=0&amp;msid=213612140968263837998.0004a494111dcb5de7748&amp;ll=25.238815,55.306978&amp;spn=0.012131,0.018604&amp;z=16" target="_blank" >
				<img src="images/location_google_map.png" alt="location_google_map" width="577" height="273" />	
					
			</a>

		</div>
	</div>
	
	<div class="clear"></div>
	
<script type="text/javascript">
		$(document).ready(function(){
                    $("#contactform").validate({
                        submitHandler: function(form) {
                            $.ajax({
                                url:'send_enquiry.php',
                                type:'POST',
                                data:$("#contactform").serialize(),
                                success:function(data){
                                    $("#response").fadeIn('slow').html('Enquiry Submitted Successfully').fadeOut(8500);
                                    document.getElementById('contactform').reset();
                                }
                            });
                        }
                    });
                });
	
</script>
	
		<?php include 'footer.php'; ?>