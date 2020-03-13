<!DOCTYPE html>
<html lang="en">



<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
      
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
        
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
           
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
		
			<div id="usermgnt" class="tabcontent">
				<div class="main-content">
					<div class="section__content section__content--p30">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="overview-wrap"> 
										<h2 class="title-1">Add Info</h2>
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
							<div class="card-body">
									
									
										
							<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="personalinfo" role="tabpanel" aria-labelledby="personalinfo-tab">
											
								<div class="doctnowfrmds">
									<div class="card">
                             <form action="<?= base_url('user/adduser') ?>" method="POST" class="form-horizontal" id="myForm" enctype='multipart/form-data'>

										<div class="card-body card-block">
											   
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Name</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="name" name="name" placeholder="Enter User Name" class="form-control" data-validation="required" onkeypress="return onlyletter(event)" maxlength="50"> 
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="email-input" class=" form-control-label">Email ID</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="email" id="email" name="email" placeholder="Enter Email ID" class="form-control" onchange="checkemail()" data-validation="email required" data-validation-error-msg="Please provide valid Email ID">
														<span id="email_error" style="display: none;color: red;font-size: 14px;font-weight: bold">Email ID already exists.</span>
														<span id="email_suscess1" style="display: none;color: green;font-size: 14px;font-weight: bold">This is valid email id.</span>
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Phone Number</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="phone" name="phone" placeholder="Enter Phone Number" class="form-control" onkeypress="return numbersonly(event)" onchange="checkmobile()" data-validation="required length" data-validation-length="6-18" data-validation-error-msg="Please provide valid Mobile Number"> 
														<span id="mob_error" style="display: none;color: red;font-size: 14px;font-weight: bold">Mobile No  already exists.</span>
														<span id="mob_suscess1" style="display: none;color: green;font-size: 14px;font-weight: bold">This is valid mobile.</span>
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">DOB</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="datepicker" name="dob" placeholder="Enter Date of Birth" class="form-control datepicker" data-validation="required"> 
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label class=" form-control-label">Gender</label>
													</div>
													<div class="col col-md-9">
													   
															<div class="custom-control custom-radio custom-control-inline">
																  <input type="radio" class="custom-control-input" id="customRadio1" name="gen" value="m">
																  <label class="custom-control-label" for="customRadio1">Male</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
															  <input type="radio" class="custom-control-input" id="customRadio2" name="gen" value="f">
															  <label class="custom-control-label" for="customRadio2">Female</label>
															</div>
														
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Address</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="address" name="address" placeholder="Enter Address" class="form-control"> 
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Password</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="password" id="password" name="password" placeholder="Enter Password" class="form-control" data-validation="required"> 
													</div>
												</div>
												
													<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Profile</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="file" id="" name="profile"  class="form-control"> 
													</div>
												</div>
												
											
												
												
											
										</div>
										<div class="card-footer">
											<button type="submit" class="btn btn-primary btn-sm">
												<i class="fa fa-dot-circle-o"></i> Submit
											</button>
											<a href="<?= base_url('user')?> " class="btn btn-danger btn-sm">Cancel</a>
											<!--<button type="reset" class="btn btn-danger btn-sm" id="reset">-->
											<!--	<i class="fa fa-ban"></i> Reset-->
											<!--</button>-->
										</div>
									</div>
                                    </form>
								</div>
											
											
							</div>
						
											
							</div>


							</div>
                                <!-- END DATA TABLE-->
									</div>
							  
									</div>
								</div>
							</div>
						</div>
							  
					</div>
				</div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
			</div>
			
			
		
        </div>
		
    </div>
	

			
			
			
			
			
			
	<!-- Audio Uploads 4-->
	
			
			
		
			
			
			
			
			
		
			
			
		
			



</body>

</html>
<!-- end document-->
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
    </script>

    <script>
			function checkemail()
			{
			 var email = $("#email").val();
    
			 $.ajax({
                      type:"POST",
                      url: "<?= base_url('user/checkemail')?>",
                      data:{
                      	     email:email
                       },
                       success:function(response)
                       {
                       	//alert(response);
                       	if(response==1)
                       	{
                       		$("#email").val("");
                       		//alert("This Email Id already exists,Please try another.")
                       		$("#email_error").css("display", "block");
                       		$("#email_suscess").css("display", "none");
                       		 setTimeout(function() {
                         $('#email_error').fadeOut('fast');
                         }, 1000);
                       	}
                       	else
                       	{
                       		$("#email_suscess").css("display", "block");
                       		$("#email_error").css("display", "none");
                       		 setTimeout(function() {
                          $('#email_error').fadeOut('fast');
                           }, 1000);
                       	}
                       }
			 })
			}


			function checkmobile()
			{
			 var phone = $("#phone").val();
          // alert(phone);
			 $.ajax({
                      type:"POST",
                      url: "<?= base_url('user/checkmobile')?>",
                      data:{
                      	     phone:phone
                       },
                       success:function(response)
                       {
                       //	alert(response);
                       	if(response==1)
                       	{
                       		$("#phone").val("");
                       		//alert("This Email Id already exists,Please try another.")
                       		$("#mob_error").css("display", "block");
                       		$("#mob_suscess").css("display", "none");
                       		 setTimeout(function() {
                       $('#mob_error').fadeOut('fast');
                      }, 1000);
                       	}
                       	else
                       	{
                       		$("#mob_suscess").css("display", "block");
                       		$("#mob_error").css("display", "none");
                       		 setTimeout(function() {
                           $('#mob_error').fadeOut('fast');
                        }, 1000);
                       	}
                       }
			 })
			}
			
			
			


		</script>
	