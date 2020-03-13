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
										<h2 class="title-1">Edit Speciality</h2>
										
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="card-body">
								
											<div class="doctnowfrmds">
											<div class="card">
                                   <form action="<?= base_url('speciality/editspeciality')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Speciality Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="hidden" value="<?= $speciality[0]->id ?>" name="spe_id" />
                                                    <input type="text" id="speciality_name" name="speciality_name" placeholder="Enter Speciality Name" class="form-control" data-validation="required" value="<?= $speciality[0]->name?>"> 
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Speciality Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="hidden" value="<?= $speciality[0]->id ?>" name="spe_id" />
                                                    <input type="text" id="speciality_name" name="hi_speciality_name" placeholder="Enter Speciality Name" class="form-control" data-validation="required" value="<?= $speciality[0]->hi_name?>"> 
                                                </div>
                                            </div>
											
										
											
										 <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Status</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="status" class="form-control">
                                                        <option value="1" <?php  if($speciality[0]->status=='1'){echo "selected";}?>>Active</option>
                                                        <option value="0" <?php if($speciality[0]->status=='0'){echo "selected";}?>>Deactive</option>
                                                    </select>
                                                    
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
                                        
                                     <a href="<?= base_url('speciality')?>" class="btn btn-danger btn-sm">Cancel</a>

                                    </div>
                                     </form>
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

</body>

</html>
<!-- end document-->


<script src="https://cdn.ckeditor.com/4.11.4/standard/ckeditor.js"></script>
 <script>
     CKEDITOR.replace( 'description' );
</script>