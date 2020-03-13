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
                                        <h2 class="title-1">Booking Detail</h2>
                                        <!-- <a  href="userprofileedits.html" class="au-btn au-btn-icon au-btn--blue" >
											<i class="zmdi zmdi-plus"></i>Add New User</a> -->
                                    </div>
                                    <div class="col-md-12 tabdatabga">

                                    	<div class="Booking_User">
	                                        <h6>User Name: <label><?= ucwords($booking[0]->user) ?></label></h6>
	                                        <div class="">
	                                            <div class="bookpaneldrn">
	                                                <div class="doctpropics">
	                                                    <?php if($booking[0]->image){?>
                                                        <img src="<?= $booking[0]->image ?>" title="<?= ucwords($values->doctor) ?>">
                                                        <?php } else{?>
                                                            <img src="<?= base_url('images/icon/avatar-big-01.jpg') ?>" title="No Image">
                                                            <?php } ?>
	                                                </div>

	                                                <div class="doctinfors">
	                                                    <h6>Dr. <?= ucwords($booking[0]->doctor)?></h6>
	                                                    <div class="designationfrnow">
	                                                        <label>Speciality:</label>
	                                                        <?php 
														 		$speId = $booking[0]->specialty;
												    			$name = $this->user_model->fetchValue('specility','name',array('id'=>$speId)); 
													 			?>
	                                                            <p>
	                                                                <?= ucfirst($name) ?>
	                                                            </p>
	                                                    </div>

	                                                    <div class="clinicnamedrnow">
	                                                        <figure><img src="<?= base_url('assets/images/Clinic-Icon.png')?>"></figure>
	                                                        <label>Clinic Name</label>
	                                                        <p>
	                                                            <?= $booking[0]->clinic_name ?>
	                                                        </p>
	                                                    </div>

	                                                  <!--   <div class="clinicnamedrnow">
	                                                        <figure><img src="<?= base_url('assets/images/Timing-Icon.png')?>"></figure>
	                                                        <label>Timing</label>
	                                                        <p>30-45 Minutes</p>
	                                                    </div> -->

	                                                    <div class="clinicnamedrnow">
	                                                        <figure><img src="<?= base_url('assets/images/Visit-Icon.png')?>"></figure>
	                                                        <label>Reason for visit :</label>
	                                                        <p>
	                                                            <?= $booking[0]->reason_visit ?>
	                                                        </p>
	                                                    </div>

	                                                    <div class="clinicnamedrnow">
	                                                        <figure><img src="<?= base_url('assets/images/Address-Icon.png')?>"></figure>
	                                                        <label>Address Type: </label>
	                                                        <p>
	                                                            <?= $booking[0]->address_type ?>
	                                                        </p>
	                                                    </div>

	                                                    <div class="clinicnamedrnow">
	                                                        <figure><img src="<?= base_url('assets/images/Address-Icon.png')?>"></figure>
	                                                        <label>Address : </label>
	                                                        <p>
	                                                            <?= $booking[0]->address ?>
	                                                        </p>
	                                                    </div>
	                                                    <?php if($booking[0]->member_name){ ?>
                                                        <div class="clinicnamedrnow">
                                                            <figure><img src="<?= base_url('assets/images/User-Icon.png')?>"></figure>
                                                            <label>Member Name : </label>
                                                            <p>
                                                                <?php echo $booking[0]->member_name;  ?>
                                                            </p>
                                                        </div>
                                                        <?php } ?>

                                                        <div class="clinicnamedrnow">
                                                        	<figure><img src="<?= base_url('assets/images/Status-Icon.png')?>"></figure>
                                                            <label>Booking Status </label>
                                                            <p>
                                                                <?php 
																	if($booking[0]->booking_status=='0'){echo"Pending";} 
																	if($booking[0]->booking_status=='1'){echo"Accepted";}
																	if($booking[0]->booking_status=='2'){echo"Rejected";}
																	if($booking[0]->booking_status=='3'){echo"Payment";}
																?>
                                                            </p>
                                                        </div>

	                                                </div>

	                                                <!--	<div class="actionablepartdrnw">-->
	                                                <!--	    <a href="javascript:void(0)" class="btn greenbtn" onclick="acceptBook('<?= $values->booking_id ?>','<?= $values->booking_status?>')">Accept</a>-->
	                                                <!--<button class="btn greenbtn" data-toggle="modal" data-target="#mediumModal">Accept</button>-->
	                                                <!--<button class="btn redbtn" data-toggle="modal" data-target="#mediumModal2">Reject</button>-->
	                                                <!--<a href="javascript:void(0)" class="btn redbtn" onclick="rejectBook('<?= $values->booking_id ?>','<?= $values->booking_status?>')">Reject</a>-->
	                                                <!--                                        <?php if($values->booking_status=='3'){?>-->
	                                                <!--		<button class="btn blackbtn" data-toggle="modal" data-target="#mediumModal45">Schedule</button>-->
	                                                <!--		<?php } ?>-->
	                                                <!--<a href="javascript:void(0)" class="btn redbtn" onclick="paymentSuccess('<?= $values->booking_id ?>','<?= $values->booking_status?>')">Accept Payment</a>-->
	                                                <!--	</div>-->

	                                            </div>

	                                        </div>
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

</body>

</html>