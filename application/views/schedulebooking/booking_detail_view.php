
<!DOCTYPE html>
<html lang="en">



<body class="">
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
										<h2 class="title-1">Booking Management</h2>
										<!-- <a  href="userprofileedits.html" class="au-btn au-btn-icon au-btn--blue" >
											<i class="zmdi zmdi-plus"></i>Add New User</a> -->
									</div>
									<div class="col-md-12 tabdatabga">
								
									<h6>User Name: <label><?= ucwords($booking[0]->user) ?></label></h6>
									<div class="">
									    <?php 
									      if(!empty($booking)):
									       foreach($booking as $values): 
									           	    // echo $values->booking_id
									    ?>
										<div class="bookpaneldrn">
											<div class="doctpropics">
											    <?php if($values->image){?>
											    	<img src="<?= $values->image ?>" title="<?= ucwords($values->doctor) ?>">
											    <?php } else{?>
												<img src="<?= base_url('images/icon/avatar-big-01.jpg') ?>" title="No Image">
												<?php } ?>
											</div>
											
											<div class="doctinfors">
												<h6>Dr. <?= ucwords($values->doctor)?></h6>
												<div class="designationfrnow">
													<label>Speciality:</label>
													<p><?= ucfirst($values->specialty) ?></p>
												</div>
												
												<div class="clinicnamedrnow">
													<img src="<?= base_url('images/hosico.png')?>">
													<p><?= $values->clinic_name ?></p>
												</div>
												<?php
												   if($values->booking_status=='0')
												   {
												       $bookingStatus = "Pending";
												   }else if ($values->booking_status=='1')
												   {
												       $bookingStatus = "Accepted";
												   }else if($values->booking_status=='2'){
												       $bookingStatus = "Rejected";
												   }else if($values->booking_status=='3'){
												       $bookingStatus = "Payment Success";
												   }else if($values->booking_status=='4')
												   {
                                                     $bookingStatus = "End Session";
												   }
												?>
												<div class="clinicnamedrnow">
												  
													<p>Schedule Date <?= date('d-m-Y',strtotime($values->schedule_date))?></p>
												</div>
												
													<div class="clinicnamedrnow">
												  
													<p>Schedule Time <?= date('h:i A',strtotime($values->schedule_time))?></p>
												</div>
												
													
												
													<div class="clinicnamedrnow">
													
													<p><b>Booking Status</b> <?= $bookingStatus ?></p>
												</div>
												
											</div>
										
											
											<div class="actionablepartdrnw">
											    <a href="javascript:void(0)" class="btn greenbtn" onclick="acceptBook('<?= $values->booking_id ?>','<?= $values->booking_status?>')">Accept</a>
												<!--<button class="btn greenbtn" data-toggle="modal" data-target="#mediumModal">Accept</button>-->
												<!--<button class="btn redbtn" data-toggle="modal" data-target="#mediumModal2">Reject</button>-->
										<a href="javascript:void(0)" class="btn redbtn" onclick="rejectBook('<?= $values->booking_id ?>','<?= $values->booking_status?>')">Reject</a>

											 <?php if($values->booking_status=='3'){?>
												<button class="btn blackbtn" data-toggle="modal" data-target="#mediumModal45">Schedule</button>
												<?php } ?>
								<a href="javascript:void(0)" class="btn redbtn" onclick="paymentSuccess('<?= $values->booking_id ?>','<?= $values->booking_status?>')">Accept Payment</a>
				
											</div>
											
										</div>
										
									
											<?php endforeach; 
											else:
											    
											?>
											<p>No Records Found!</p>
											<?php endif;?>
									
										
									
										
										
										
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
	
	
	
	
	
	<div class="modal fade" id="mediumModal44" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="closingstfd">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body">
							<div class="rehectstatus">
								<div class="card">
								<div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="text-input" class=" form-control-label">Select Reason for Reject Request</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <select class="form-control">
														<option>Doctor is unavailable</option>
														<option>Location is Far</option>
													</select>
                                                </div>
                                            </div>
											
											
                                        </form>
                                    </div>
										
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mediumModal43" data-dismiss="modal">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-ban"></i> Cancel
                                        </button>
                                    </div>
								</div>
							</div>
							
						</div>
						
					</div>
				</div>
	</div>
	
	<div class="modal fade" id="mediumModal45" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="closingstfd">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body">
							<div class="rehectstatus">
								<div class="card">
								<div class="card-body card-block">
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="text-input" class=" form-control-label">Select Schedule Date</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                   <input type="date" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="text-input" class=" form-control-label">Enter Time</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                   <input type="time" class="form-control">
                                                </div>
                                            </div>
											
											
                                        </form>
                                    </div>
										
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#mediumModal46" data-dismiss="modal">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-ban"></i> Cancel
                                        </button>
                                    </div>
								</div>
							</div>
							
						</div>
						
					</div>
				</div>
	</div>
	
	
	
	
	
	<div class="modal fade" id="mediumModal46" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="closingstfd">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body acceptednotify">
							<h4>Booking Scheduled Successfully</h4>
							<p>User Will be Notified by App Notification</p>
							<button class="btn redbc" data-dismiss="modal" aria-label="Close">Ok</button>
						</div>
						
					</div>
				</div>
	</div>
	
			
 <div id="booking_msg" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      
 
	                      <div class="modal-body acceptednotify">
							<h4><span id="b_msg"></span> </h4>
							<button class="btn redbc" data-dismiss="modal" aria-label="Close">Ok</button>
				
      </div>
     
    </div>

  </div>
</div>
			
       <div id="reject_booking" class="modal"></div>
    <div id="formmodel" class="modal"></div>
    
    <div class="modal fade" id="mediumModal43" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="closingstfd">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body acceptednotify rejectedokl">
							<h4>Booking Rejected</h4>
							<p>User Will be Notified by App Notification</p>
							<button class="btn redbc" data-dismiss="modal" aria-label="Close">Ok</button>
						</div>
						
					</div>
				</div>
	</div>
	<!--payment success popup-->
	<div id="payment_success" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body acceptednotify">
		<h4>Payment Accepted Successfully.</h4>
	<button class="btn redbc" data-dismiss="modal" aria-label="Close">Ok</button>
 </div>
</div>

  </div>
</div>

<!--payment success popup-->

</body>

</html>
	
<script>
function paymentSuccess(id,bookin_status)
{
//alert(bookin_status);
  if(bookin_status==3)
  {
    // alert('hii');
         $("#b_msg").html("Payment Already Acepted");
         $("#booking_msg").modal('show');
  }else{
	$.ajax({
            type: 'POST',
            cache: false,
            url: '<?= base_url("homebooking/paymentStatus")?>',
            data:'id='+id,
            
            success: function (html) { 
            
        //   alert(html);exit();
            // if(html==1){
             // location.reload();
             window.setTimeout(function(){location.reload()},2000)

             // $("#payment_success").html(html);
              $("#payment_success").modal('show');
            
           //  }
            
         }
          });
}
}
</script>				
<script>
function rejectstatus()
{
//alert('hh');
   var booking_id=$("#booking_id").val();
    var reject_reason=$("#reject_reason").val();
	$.ajax({
            type: 'POST',
            cache: false,
            url: '<?= base_url("homebooking/updateRejectStatus")?>',
            data:{
                   reject_reason:reject_reason,
                   booking_id:booking_id
            },
            
            success: function (html) { 
            
           //alert(html);exit();
            // if(html==1){
             // location.reload();
             window.setTimeout(function(){location.reload()},2000)
              
             // $("#reject_booking").html(html);
                 $("#reject_booking").modal('hide');

              $("#mediumModal43").modal('show');
            
            // }
            
         }
          });

}
</script>
	
<script>
function acceptBook(id,bookin_status)
{
//alert(bookin_status);
  if(bookin_status==1)
  {
     // alert('hii');
         $("#b_msg").html("Booking Already Acepted");
         $("#booking_msg").modal('show');
  }else{
	$.ajax({
            type: 'POST',
            cache: false,
            url: '<?= base_url("homebooking/acceptBooking")?>',
            data:'id='+id,
            
            success: function (html) { 
            
           //alert(html);exit();
            // if(html==1){
             // location.reload();
             window.setTimeout(function(){location.reload()},2000)

              $("#formmodel").html(html);
              $("#formmodel").modal('show');
            
            // }
            
         }
          });
}
}
</script>

<script>
function rejectBook(id,bookin_status)
{
//alert(bookin_status);
  if(bookin_status==2)
  {
     // alert('hii');
         $("#b_msg").html("Booking Alrady Rejected"); 
         $("#booking_msg").modal('show');
  }else{
	$.ajax({
            type: 'POST',
            cache: false,
            url: '<?= base_url("homebooking/rejectBooking")?>',
            data:'id='+id,
            
            success: function (html) { 
            
           //alert(html);exit();
            // if(html==1){
             // location.reload();
            // window.setTimeout(function(){location.reload()},2000)
           //  window.setTimeout(function(){location.reload()},2000)
              $("#reject_booking").html(html);
              $("#reject_booking").modal('show');
            
            // }
            
         }
          });
}
}
</script>
<!-- end document-->
