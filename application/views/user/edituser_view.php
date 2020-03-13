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
										<h2 class="title-1">Edit Info</h2>
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
							<div class="card-body">
									
										<!--<div class="drnowtabdsn">-->
										<!--<ul class="nav nav-tabs" id="myTab" role="tablist">-->
										<!--	<li class="nav-item">-->
										<!--<a class="nav-link active" id="personalinfo-tab" data-toggle="tab" href="#personalinfo" role="tab" aria-controls="personalinfo" aria-selected="true">Personal</a>-->
										<!--	</li>-->
										<!--	<li class="nav-item">-->
										<!--		<a class="nav-link" id="profess-tab" data-toggle="tab" href="#profess" role="tab" aria-controls="profess" aria-selected="false">Familty</a>-->
										<!--	</li>-->
											
										<!--</ul>-->
										<!--</div>-->
										
							<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="personalinfo" role="tabpanel" aria-labelledby="personalinfo-tab">
											
								<div class="doctnowfrmds">
									<div class="card">
                             <form action="<?= base_url('user/edituser') ?>" method="POST" class="form-horizontal" id="myForm" enctype= multipart/form-data>

										<div class="card-body card-block">
											   
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Name</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="name" name="name" placeholder="Enter User Name" class="form-control" value="<?= $user[0]->name ?>" data-validation="required" maxlength="50" onkeypress="return onlyletter(event)" > 
														<input type="hidden" name="user_id" value="<?= $user[0]->id ?>" >
													</div>
												</div>
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="email-input" class=" form-control-label">Email ID</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="email" id="email" name="email" placeholder="Enter Email ID"  onchange="checkemail('<?= $user[0]->id ?>')" class="form-control" value="<?= $user[0]->email ?>" data-validation="required" data-validation-error-msg="Please provide valid Email ID">
												       <span id="email_error" style="display: none;color: red;font-size: 14px;font-weight: bold">Email ID already exists.</span>
														<span id="email_suscess1" style="display: none;color: green;font-size: 14px;font-weight: bold">This is valid email id.</span>
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Phone Number</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="phone" name="phone" placeholder="Enter Phone Number" onchange="checkmobile('<?= $user[0]->id ?>')" class="form-control" onkeypress="return numbersonly(event)" value="<?= $user[0]->mobile ?>" data-validation="required length" data-validation-length="6-18" data-validation-error-msg="Please provide valid Mobile Number"> 
													    <span id="mob_error" style="display: none;color: red;font-size: 14px;font-weight: bold">Mobile No  already exists.</span>
														<span id="mob_suscess1" style="display: none;color: green;font-size: 14px;font-weight: bold">This is valid mobile.</span>
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">DOB</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="datepicker" name="dob" placeholder="Enter Date of Birth" class="form-control datepicker" value="<?= date('d-m-Y',strtotime($user[0]->dob)) ?>" data-validation="required"> 
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label class=" form-control-label">Gender</label>
													</div>
													<div class="col col-md-9">
													   
															<div class="custom-control custom-radio custom-control-inline">
																  <input type="radio" class="custom-control-input" id="customRadio1" name="gen" value="m" <?php if($user[0]->gender=="m"){echo "checked";}?> >
																  <label class="custom-control-label" for="customRadio1">Male</label>
															</div>
															<div class="custom-control custom-radio custom-control-inline">
															  <input type="radio" class="custom-control-input" id="customRadio2" name="gen" value="f" <?php if($user[0]->gender=="f"){echo "checked";}?>>
															  <label class="custom-control-label" for="customRadio2">Female</label>
															</div>
														
													</div>
												</div>
												
												<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Address</label>
													</div>
													<div class="col-12 col-md-9">
														<input type="text" id="address" name="address" placeholder="Enter Address" class="form-control" value="<?= $user[0]->address?>"> 
													</div>
												</div>
												
												<!--<div class="row form-group">-->
												<!--	<div class="col col-md-3">-->
												<!--		<label for="text-input" class=" form-control-label">Password</label>-->
												<!--	</div>-->
												<!--	<div class="col-12 col-md-9">-->
												<!--		<input type="password" id="password" name="password" placeholder="Enter Password" class="form-control"> -->
												<!--	</div>-->
												<!--</div>-->
												
													<div class="row form-group">
													<div class="col col-md-3">
														<label for="text-input" class=" form-control-label">Profile</label>
													</div>
													<div class="col-12 col-md-9">
													    <input type="hidden" name="img" value="<?= $user[0]->image ?>" />
														<input type="file" id="" name="profile"  class="form-control">
														<br>
														<?php if($user[0]->image){?>
														<img src="<?= $user[0]->image ?>" height="50" width="50" title="<?= $user[0]->name ?>"/>
														<?php } else{ ?>
													   <img src="<?= base_url('assets/images/avtar_dummy.png')?>"  title="No Image" height="50" width="50"/>
													   <?php } ?>
													</div>
												</div>
												
												
											
												
												
												
											
										</div>
										<div class="card-footer">
											<button type="submit" class="btn btn-primary btn-sm">
												<i class="fa fa-dot-circle-o"></i> Submit
											</button>
											<!--<button type="reset" class="btn btn-danger btn-sm" id="reset">-->
											<!--	<i class="fa fa-ban"></i> Reset-->
											<!--</button>-->
									<a href="<?= base_url('user')?> " class="btn btn-danger btn-sm">Cancel</a>

										</div>
									</div>
                                    </form>
								</div>
											
											
							</div>
							<div class="tab-pane fade" id="profess" role="tabpanel" aria-labelledby="profile-tab">
								<div class="doctnowfrmds">
									<div class="table-responsive m-b-40">
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
														<th>S No.</th>
														<th>Full Name</th>
														<th>DOB</th>
														<th>Gender</th>
														<th>Relationship</th>
														
														<th>Edit Info</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1</td>
														<td>Alex</td>
														<td>21/07/1993</td>
														<td>Male</td>
														<td>Brother</td>
														
														<td>
															<div class="table-data-feature"> 
															<a href="editfamilymember.html" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
																<i class="zmdi zmdi-delete"></i>
															</button>
															</div>
														</td>
													</tr>
													<tr>
														<td>2</td>
														<td>Maria</td>
														<td>21/07/1993</td>
														<td>Female</td>
														<td>Sister</td>
														<td>
															<div class="table-data-feature"> 
															<a href="editfamilymember.html" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
																<i class="zmdi zmdi-delete"></i>
															</button>
															</div>
														</td>
													</tr>
													<tr>
														<td>3</td>
														<td>Stella</td>
														<td>21/07/1993</td>
														<td>Female</td>
														<td>Wife</td>
														<td>
															<div class="table-data-feature"> 
															<a href="editfamilymember.html" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete">
																<i class="zmdi zmdi-delete"></i>
															</button>
															</div>
														</td>
													</tr>
													
												</tbody>
											</table>
										</div>
				
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
			
			
		
			<div class="row">
				<div class="col-md-12">
					<div class="copyright">
						<p>Copyright © 2018 ASEC. All rights reserved. <a href="#">Mobulous</a>.</p>
					</div>
				</div>
			</div>
        </div>
		
    </div>
	
	<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Number Of Children</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    <div class="card-body card-block">
                                       <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Classroom name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Classroom number</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
														<option value="3">4</option>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Children</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Nannies</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
                                        </form>

                                            
                                            
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal2" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Nannies</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                    <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">  
                                    <div class="card-body card-block">
                                    
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Enter Your Name" class="form-control">
                                                </div>
                                            </div>
											
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Enter Your Surname" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Username</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Enter Your Username" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="password-input" class=" form-control-label">Password</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="password" id="password-input" name="password-input" placeholder="Enter Your Password" class="form-control">
                                                </div>
                                            </div>
                                        

                                            
                                            
                                    </div>
                                    <div class="card-footer">
                                        <!-- <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button> -->
                                        <input type="submit" name="save" value="Submit11111111" class="btn btn-primary btn-sm">
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                               </form>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="mediumModal3" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Children</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    <div class="card-body card-block">
                                       <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name and </label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Age (birth date)</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Profile photo (optional)</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="file-input" class="form-control-file">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Father Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Mother Name and Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Classroom number</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
														<option value="3">4</option>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Children</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Nannies</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
                                        </form>

                                            
                                            
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
	<!-- Audio Uploads 4-->
	
			<div class="modal fade" id="mediumModal4" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Upload Audio</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="mediumModal5" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Upload Photo/Video</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal6" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Children Meal Duration</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="mediumModal7" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Children Nap Duration</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal8" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Toilet</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal9" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Activities</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal10" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Report</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			



</body>

</html>
<!-- end document-->
<script>
    $(function() {
        $( ".datepicker" ).datepicker();
    });
    
    </script>
    <script>
        	function checkmobile(user_id)
			{
			 var phone = $("#phone").val();
         //  alert(user_id);
			 $.ajax({
                      type:"POST",
                      url: "<?= base_url('user/updateMobile')?>",
                      data:{
                      	     phone:phone,
                      	     user_id:user_id
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
			
			
			//check email
		function checkemail(user_id)
			{
			 var email = $("#email").val();
            // alert(user_id);
			 $.ajax({
                      type:"POST",
                      url: "<?= base_url('user/updateEmail')?>",
                      data:{
                      	     email:email,
                      	     user_id:user_id
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
    </script>
    
    
    
    
    