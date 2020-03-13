<!DOCTYPE html>
<html lang="en">



<body class="animsition">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
        
        <!-- END HEADER MOBILE-->

   
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
										<h2 class="title-1">Edit Info</h2>
										
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="card-body">
									
										<div class="drnowtabdsn">
										<ul class="nav nav-tabs" id="myTab" role="tablist">
											<li class="nav-item">
										<a class="nav-link active" id="personalinfo-tab" data-toggle="tab" href="#personalinfo" role="tab" aria-controls="personalinfo" aria-selected="true">Personal</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="profess-tab" data-toggle="tab" href="#profess" role="tab" aria-controls="profess" aria-selected="false">Professional</a>
											</li>
											<li class="nav-item">
												<a class="nav-link" id="bankdtls-tab" data-toggle="tab" href="#bankdtls" role="tab" aria-controls="bankdtls" aria-selected="false">Bank Details</a>
											</li>
										</ul>
										</div>
										<!-- form anas-->
                                        <form action="<?= base_url('doctor/editdoctor') ?>" method="post" enctype= multipart/form-data id="myForm">
										<div class="tab-content" id="myTabContent">
											<div class="tab-pane fade show active" id="personalinfo" role="tabpanel" aria-labelledby="personalinfo-tab">
											
											<div class="doctnowfrmds">
											<div class="card">
                                     
                                         <div class="card-body card-block">
                                      
                                           
                                            <div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="name" name="name" placeholder="Enter Doctor Name" class="form-control" value="<?= $doctor[0]->name ?>" onkeypress="return onlyletter(event)" maxlength="50" data-validation="required"> 
                                                    <input type="hidden" name="doctor_id" value="<?= $doctor[0]->id ?>">
                                                </div>
                                            </div>
                                            <div class="row ">
                                                <div class="col col-md-3">
                                                    <label for="email-input" class=" form-control-label">Email ID</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="email" name="email" placeholder="Enter Email ID" class="form-control" onchange="checkemail('<?= $doctor[0]->id ?>')"  value="<?= $doctor[0]->email ?>" data-validation="email required" data-validation-error-msg="Please provide valid Email ID">
                                                   <span id="email_error" style="display: none;color: red;font-size: 14px;font-weight: bold">This email is already exists.</span>
                                                        <span id="email_suscess1" style="display: none;color: green;font-size: 14px;font-weight: bold">This is valid email id.</span> 
                                                </div>
                                            </div>
											
											<div class="row ">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Phone Number</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="phone" name="mobile" placeholder="Enter Phone Number" class="form-control" onchange="checkmobile('<?= $doctor[0]->id ?>')" onkeypress="return numbersonly(event)"  value="<?= $doctor[0]->mobile ?>" data-validation="required length" data-validation-length="6-18" data-validation-error-msg="Please provide valid Mobile Number"> 

                                                <span id="mob_error" style="display: none;color: red;font-size: 14px;font-weight: bold">This mobile is already exists.</span>
                                                        <span id="mob_suscess1" style="display: none;color: green;font-size: 14px;font-weight: bold">This is valid mobile.</span>
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">DOB</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="dob" name="dob" placeholder="Enter Date of Birth" class="form-control datepicker"  value="<?= date('d-m-Y',strtotime($doctor[0]->dob)) ?>" data-validation="required"> 
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">Gender</label>
                                                </div>
                                                <div class="col col-md-9 form-group">
                                                   
                                                        <div class="custom-control custom-radio custom-control-inline">
															  <input type="radio" class="custom-control-input" id="customRadio1" name="gen" value="m" <?php if($doctor[0]->gender=='m'){echo "checked";}?>>
															  <label class="custom-control-label" for="customRadio1">Male</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline">
														  <input type="radio" class="custom-control-input" id="customRadio2" name="gen" value="f" <?php if($doctor[0]->gender=='f'){echo "checked";}?> >
														  <label class="custom-control-label" for="customRadio2">Female</label>
														</div>
                                                    
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Address</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="address" name="address" placeholder="Enter Address" class="form-control" value="<?= $doctor[0]->address ?>"> 
                                                </div>
                                            </div>
                                            
                                            	<div class="row">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Profile</label>
													</div> 
													<div class="col-12 col-md-9 form-group">
													   
														<input type="file" id="" name="profile"  class="form-control">
														<input type="hidden" name="profile1" value="<?= $doctor[0]->image ?>" />
														<br>
														<?php if($doctor[0]->image){?>
														<a href="<?=$doctor[0]->image ?>" target="_blank">
														<img src="<?= $doctor[0]->image ?>" height="50" width="50" title="<?= $doctor[0]->name ?>"/></a>
														<?php } else{ ?>
													   <img src="<?= base_url('assets/images/avtar_dummy.png')?>"  title="No Image" height="50" width="50"/>
													   <?php } ?>
													</div>
												</div>



                                                <div class="row">
                                       <div class="col col-md-3">
                                          <label for="text-input" class=" form-control-label">Country</label>
                                       </div>
                                       <div class="col-12 col-md-9 form-group">
                                         <select name="country" class="form-control" onchange="getstate(this.value)">
                                             <option value="">Select Country</option>
                                             <?php if(!empty($country)){
                                              foreach($country as $con){?>
                                              <option value="<?= $con->id ?>" <?php if($con->id==$doctor[0]->country_id){echo "selected";}?>><?= $con->name ?></option>
                                              <?php } } ?>
                                             
                                         </select>
                                       </div>
                                       
                                       
                                    </div>



                                         <div class="row">
                                       <div class="col col-md-3">
                                          <label for="text-input" class=" form-control-label">State</label>
                                       </div>
                                       <div class="col-12 col-md-9 form-group" id="state1">
                                         <select name="state" class="form-control" onchange="getstate(this.value)">
                                             <option value="">Select State</option>
                                             <?php if(!empty($state)){
                                              foreach($state as $st){?>
                                              <option value="<?= $st->id ?>" <?php if($st->id==$doctor[0]->state_id){echo "selected";}?>><?= $st->name ?></option>
                                              <?php } } ?>
                                             
                                         </select>
                                       </div>
                                       
                                       
                                    </div>


                                        <div class="row" >
                                       <div class="col col-md-3">
                                          <!--<label for="text-input" class=" form-control-label">State</label>-->
                                       </div>
                                       <div class="col-12 col-md-9 form-group" id="state2" style="display: none">
                                        <span id="state_res"></span>
                                       </div>
                                       
                                       
                                    </div>


                                                <div class="row">
                                       <div class="col col-md-3">
                                          <label for="text-input" class=" form-control-label">City</label>
                                       </div>
                                       <div class="col-12 col-md-9 form-group" id="city1">
                                         <select name="city" class="form-control" onchange="getstate(this.value)">
                                             <option value="">Select City</option>
                                             <?php if(!empty($citys)){
                                              foreach($citys as $cty){?>
                                              <option value="<?= $cty->id ?>" <?php if($cty->id==$doctor[0]->city_id){echo "selected";}?>><?= $cty->name ?></option>
                                              <?php } } ?>
                                             
                                         </select>
                                       </div>
                                       
                                       
                                    </div>
											

                                           <div class="row">
                                       <div class="col col-md-3">
                                          <!--<label for="text-input" class=" form-control-label">City</label>-->
                                       </div>
                                       <div class="col-12 col-md-9 form-group" id="city2"  style="display:none">
                                        <span id="city_res"></span>
                                       </div>
                                       
                                       
                                    </div>
                                              
                                            
                                            
                                       
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary btn-sm" id="first">
                                            <i class="fa fa-dot-circle-o"></i> Next
                                        </button>
                                        <!--<button type="reset" class="btn btn-danger btn-sm">-->
                                        <!--    <i class="fa fa-ban"></i> Reset-->
                                        <!--</button>-->
                                    	<!--<a href="<?= base_url('doctor')?> " class="btn btn-danger btn-sm">Cancel</a>-->

                                    </div>
                                <!-- </form> -->
                                </div>
											</div>
											
											
											</div>
											<div class="tab-pane fade" id="profess" role="tabpanel" aria-labelledby="profile-tab">
												<div class="doctnowfrmds">
												<div class="card">
                                   
                                    <div class="card-body card-block">
                                       <!--  <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"> -->
                                          <div class="row">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Select Specialty</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <select name="specialty" id="select" class="form-control" data-validation="required">
                                                        <option value="">Please select</option>
                                                        <?php 
                                                          if(!empty($specialtyList)):
                                                     //   print_r($specialtyList);die;
                                                            foreach($specialtyList as $spes):
                                                            ?>
                                                           <option <?php if($spes->id==$doctor[0]->specialty){echo "selected";}?>><?= $spes->name ?></option>
                                                           <?php  endforeach;endif;?> 
                                                    </select>
                                                </div>
                                            </div>
											
                                            <div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Enter License No.</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="text-input" name="license" placeholder="Enter License No." class="form-control" value="<?= $doctor[0]->license_no ?>" data-validation="required">
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class=" form-control-label">Upload Document</label>
                                                </div>
                                                <div class="col-8 col-md-5 form-group">
                                                    <input type="file" id="file-input" name="document" class="form-control-file">
                                                 <input type="hidden" name="document1" value="<?= $doctor[0]->document ?>">
                                                </div>
                                                <div class="col-2 col-md-2">
                                                <?php if($doctor[0]->document){?>    
                                               <img src="<?= $doctor[0]->document ?>" height="50px" width="50px" style="border-radius:50% " title="Document Image">
                                               <?php } else{ ?>
                                                <span class="fa fa-file" title="No Document Uploaded" style="font-size:25px"></span>

                                               <?php } ?>
                                                </div>
                                            </div>

                                             <div class="row">
                                            
                                             <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Qualification</label>
                                                </div>
                                                
                                                <div class="col-12 col-md-9 form-group">
                                                    <select name="qualification" id="select" class="form-control" data-validation="required">
                                                        <option value="">Please select</option>
                                                        <?php 
                                                             if(!empty($qualification)):
                                                              foreach($qualification as $qual):
                                                         ?>
                                                         <option <?php if($qual->name==$doctor[0]->qualification){echo "selected";}?>><?= ucwords($qual->name) ?></option>
                                                     <?php 
                                                          endforeach;
                                                          endif;
                                                          ?>
                                                    </select>
                                                </div>
                                                
                                            </div>
											
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Experience</label>
                                                </div>
                                                <!--<div class="col-12 col-md-9">-->
                                                <!--    <input type="text" id="text-input" name="exp" placeholder="Enter Experience" class="form-control" value="<?= $doctor[0]->experience ?>"  onkeypress="return numbersonly(event)" data-validation="required">-->
                                                <!--</div>-->
                                                
                                                <div class="col-12 col-md-4">
                                                    <select class="form-control" name="year">
                                                        <option>Select Year</option>
                                                        <?php for($i=0;$i<=10;$i++){?>
                                                        <option value="<?= $i ?>" <?php if($doctor[0]->experience==$i){echo "selected";}?>><?= $i.' Year' ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!--<input type="text" id="text-input" name="exp" placeholder="Enter Experience" class="form-control"  onkeypress="return numbersonly(event)" data-validation="required">-->
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <select class="form-control" name="month">
                                                        <option>Select Month</option>
                                                        <?php for($j=0;$j<=11;$j++){?>
                                                        <option value="<?= $j ?>" <?php if($doctor[0]->month==$j){echo "selected";}?>><?= $j.' Month' ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <!--<input type="text" id="text-input" name="exp" placeholder="Enter Experience" class="form-control"  onkeypress="return numbersonly(event)" data-validation="required">-->
                                                </div>
                                            </div>
											
											<div class="row ">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Hospital/Clinic Name</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="clinic_name" name="clinic_name" placeholder="Enter Hospital/Clinic Name" class="form-control" value="<?= $doctor[0]->clinic_name ?>" >
                                                </div>
                                            </div>
											
											
											<div class="row ">
											
											 <div class="col col-md-12">
                                                    <label for="text-input" class=" form-control-label"><strong>Availability</strong></label>
                                                </div>
												
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Home Visit</label>
                                                </div>
                                               <div class="col col-md-9 form-group">
                                                   
                                                        <div class="custom-control custom-radio custom-control-inline">
															  <input type="radio" class="custom-control-input" id="customRadio4" name="home_visit_type" value="yes" <?php if($doctor[0]->home_visit_type=='yes'){echo "checked";}?> data-validation="required">
															  <label class="custom-control-label" for="customRadio4">Yes</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline">
														  <input type="radio" class="custom-control-input" id="customRadio5" name="home_visit_type" value="no" <?php if($doctor[0]->home_visit_type=='no'){echo "checked";}?> data-validation="required">
														  <label class="custom-control-label" for="customRadio5">No</label>
														</div>
                                                    
                                                </div>
												<?php $home_visit_days =  explode(',',$doctor[0]->home_visit_days); ?>
												 <div class="col col-md-12">
                                                   <div class="form-check daysselectsdr">
                                                        <div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck1" name="home_visit_days[]" value="1" <?php if(in_array('1',$home_visit_days)){echo "checked";}?> >
															  <label class="custom-control-label" for="customCheck1"><p>Mo</p></label>
														</div>
                                                       <div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck2" name="home_visit_days[]" value="2" <?php if(in_array('2',$home_visit_days)){echo "checked";}?> >
															  <label class="custom-control-label" for="customCheck2"><p>Tu</p></label>
														</div>
                                                        <div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck3" name="home_visit_days[]" value="3" <?php if(in_array('3',$home_visit_days)){echo "checked";}?> >
															  <label class="custom-control-label" for="customCheck3"><p>We</p></label>
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck4" name="home_visit_days[]" value="4" <?php if(in_array('4',$home_visit_days)){echo "checked";}?> >
															  <label class="custom-control-label" for="customCheck4"><p>Th</p></label>
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck5" name="home_visit_days[]" value="5" <?php if(in_array('5',$home_visit_days)){echo "checked";}?> >
															  <label class="custom-control-label" for="customCheck5"><p>Fr
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck6" name="home_visit_days[]" value="6" <?php if(in_array('6',$home_visit_days)){echo "checked";}?> >
															  <label class="custom-control-label" for="customCheck6"><p>Sa</p></label>
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input home" id="customCheck7" name="home_visit_days[]" value="7" <?php if(in_array('7',$home_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck7"><p>Su</p></label>
														</div>
														
                                                    </div>
                                                </div>
												
                                            </div>
											
											
											<div class="row">
											
											
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Call</label>
                                                </div>
                                               <div class="col col-md-9 form-group">
                                                   
                                                        <div class="custom-control custom-radio custom-control-inline">
															  <input type="radio" class="custom-control-input" id="customRadio6" name="call_visit_type1" value="yes" <?php if($doctor[0]->call_visit_type){ echo "checked";}?>  data-validation="required">
															  <label class="custom-control-label" for="customRadio6">Yes</label>
														</div>
														<div class="custom-control custom-radio custom-control-inline">
														  <input type="radio" class="custom-control-input" id="customRadio7" name="call_visit_type1" value="no" <?php if($doctor[0]->call_visit_type=="no"){ echo "checked";}?> data-validation="required">
														  <label class="custom-control-label" for="customRadio7">No</label>
														</div>
                                                    
                                                </div>
												    <?php $call_visit_days =  explode(',',$doctor[0]->call_visit_days); ?>
												<div class="col col-md-12">
                                                   <div class="form-check daysselectsdr">
                                                        <div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck8" name="call_visit_days[]" value="1" <?php if(in_array(1,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck8"><p>Mo</p></label>
														</div>
                                                       <div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck9" name="call_visit_days[]" value="2" <?php if(in_array(2,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck9"><p>Tu</p></label>
														</div>
                                                        <div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck10" name="call_visit_days[]" value="3" <?php if(in_array(3,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck10"><p>We</p></label>
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck11" name="call_visit_days[]" value="4" <?php if(in_array(5,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck11"><p>Th</p></label>
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck12" name="call_visit_days[]" value="5" <?php if(in_array(6,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck12"><p>Fr
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck13" name="call_visit_days[]" value="6" <?php if(in_array(6,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck13"><p>Sa</p></label>
														</div>
														
														<div class="custom-control custom-checkbox">
															  <input type="checkbox" class="custom-control-input call" id="customCheck14" name="call_visit_days[]" value="7" <?php if(in_array(7,$call_visit_days)){echo "checked";}?>>
															  <label class="custom-control-label" for="customCheck14"><p>Su</p></label>
														</div>
														
                                                    </div>
                                                </div>
												
												
												
                                            </div>
											
											
										
											
											
											<div class="row">
											
											 <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Select Distance</label>
                                                </div>
												
												<div class="col-12 col-md-9 form-group">
												    <select name="distance" id="select" class="form-control" data-validation="required">
                                                        <option value="0">Please select</option>
                                                        <?php for($i=0;$i<=20;$i++){?>
                                                        <option value="<?= $i ?>" <?php if($doctor[0]->distance==$i){echo "selected";}?>><?php echo $i;?> km</option>
                                                        <?php } ?>
                                                   
                                                </div>
												
											</div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="file-input" class=" form-control-label">Add Digital Signature</label>
                                                </div>
                                                <div class="col-8 col-md-5">
                                                    <input type="file" id="file-input" name="digital_sign" class="form-control-file" >
                                                    
                                                    <input type="hidden" name="digital_sign1" value="<?= $doctor[0]->digital_sign ?>">

                                                </div>
                                                 <div class="col-2 col-md-2">
                                                <?php if($doctor[0]->digital_sign){?>     
                                               <img src="<?= $doctor[0]->digital_sign ?>" height="50px" width="50px" style="border-radius:50% " title="Signature">
                                               <?php } else{?>
                                               <i class="fa fa-signature" style="font-size:25px"></i>
                                               <?php } ?>
                                                </div>
                                            </div>
											
                                       <!--  </form> -->
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm" id="second">
                                            <i class="fa fa-dot-circle-o"></i> Next
                                        </button>
                                        <!--<button type="reset" class="btn btn-danger btn-sm">-->
                                        <!--    <i class="fa fa-ban"></i> Reset-->
                                        <!--</button>-->
                                    	<!--<a href="<?= base_url('doctor')?> " class="btn btn-danger btn-sm">Cancel</a>-->

                                    </div>
                                </div>
								
												</div>
											</div>
											<div class="tab-pane fade" id="bankdtls" role="tabpanel" aria-labelledby="bankdtls-tab">
												<div class="doctnowfrmds">
											<div class="card">
                                   
                                    <div class="card-body card-block">
                                      <!--   <form action="" method="post" enctype="multipart/form-data" class="form-horizontal"> -->
                                           
                                            <div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Bank Name</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="text-input" name="bank_name" placeholder="Enter Bank Name" class="form-control" value="<?= $bank[0]->bank_name ?>" onkeypress="return onlyletter(event)" maxlength="50" data-validation="required"> 
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Account Holder Name</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="text-input" name="holder_name" placeholder="Enter Ac/holder Name" class="form-control"  value="<?= $bank[0]->ac_holder ?>" onkeypress="return onlyletter(event)" maxlength="50" data-validation="required"> 
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Account Number</label>
                                                </div>
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="text-input" name="account_no" placeholder="Enter Account No" class="form-control"  value="<?= $bank[0]->account_no ?>"  onkeypress="return numbersonly(event)"  data-validation="required"> 
                                                </div>
                                            </div>
											
											<div class="row">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">IFSC Code</label>
                                                </div> 
                                                <div class="col-12 col-md-9 form-group">
                                                    <input type="text" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code" class="form-control"  value="<?= $bank[0]->ifsc_code ?>" data-validation="required"> 
                                                </div>
                                            </div>

                                       
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <!--<button type="reset" class="btn btn-danger btn-sm">-->
                                        <!--    <i class="fa fa-ban"></i> Reset-->
                                        <!--</button>-->
                                	<a href="<?= base_url('doctor')?> " class="btn btn-danger btn-sm">Cancel</a>

                                    </div>
                                </div>
											</div>
											</div>
                                              </form>
										</div>

         
									</div>
                                <!-- END DATA TABLE-->
									</div>
							  
									</div>
								</div>
							</div>
						</div>
						 </form>	  
					</div>
				</div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
			</div>
			
			
		
        </div>
		
    </div>
			



</body>

</html>
<!-- end document-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<script>


   
    $('#first').click(function(e){
    e.preventDefault();
    $('#myTab a[href="#profess"]').tab('show');
});


    $('#second').click(function(e){
    e.preventDefault();
    $('#myTab a[href="#bankdtls"]').tab('show');
})
    //

</script>

 <script>
 function checkemail(user_id)
    {
       // alert();
    var email = $("#email").val();
    //alert(user_id);
             $.ajax({
                      type:"POST",
                      url: "<?= base_url('doctor/updateEmail')?>",
                      data:{
                             email:email,
                             user_id:user_id
                       },
                       success:function(response)
                       {
                        //alert(response);exit();
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


            function checkmobile(user_id)
            {
             var phone = $("#phone").val();
          // alert(phone);
             $.ajax({
                      type:"POST",
                      url: "<?= base_url('doctor/updateMobile')?>",
                      data:{
                             phone:phone,
                             user_id:user_id
                       },
                       success:function(response)
                       {
                         // alert(response);
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

       </script>
<script>

//for home days
 $(document).ready(function() {
      
    $("input[name$='home_visit_type']").click(function() {
        var type = $(this).val();
        //alert(test);
        if(type=="no"){
        $('.home').prop('disabled', true);
        $('.home').prop('checked', false); 
        }else
        {
         
         $('.home').prop('disabled', false);

        

        }

      
    });
});          

//for call

$(document).ready(function() {
   
    $("input[name$='call_visit_type1']").click(function() {
        //alert();
       //  $('.call').prop('disabled', true);
      //  $('.call').prop('checked', false); 
        var type1 = $(this).val();
       //alert(type1);
        if(type1=="no"){
        $('.call').prop('disabled', true);
        $('.call').prop('checked', false); 
        }else
        {
         
         $('.call').prop('disabled', false);

        

        }

      
    });
}); 
</script>
 <script>
          function getstate(con_id)
          {
              //var email = $("#email").val();
    // alert(con_id);
          $.ajax({
                      type:"POST",
                      url: "<?= base_url('doctor/getstate')?>",
                      data:{
                             con_id:con_id
                       },
                       success:function(response)
                       {
                       
                        if(response)
                        {
                           $("#state1").css("display", "none");    
                        $("#state2").css("display", "block");
                         $("#state_res").html(response);
                        }
                      
                       }
          });
          }
          
          
          //get city
          
          function getCity(state_id)
          {
             // alert(state_id);
               $.ajax({
                      type:"POST",
                      url: "<?= base_url('doctor/getcity')?>",
                      data:{
                             state_id:state_id
                       },
                       success:function(response)
                       {
                        //alert(response);
                        if(response)
                        {
                        $("#city1").css("display", "none");    
                        $("#city2").css("display", "block");
                         $("#city_res").html(response);
                        }
                      
                       }
          });
          }
      </script>       