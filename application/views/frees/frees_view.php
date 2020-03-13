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
									<?php
                                        if($this->session->flashdata('msg'))
                                               echo $this->session->flashdata('msg');
                                       ?>
									<div class="overview-wrap"> 
										<h2 class="title-1">Update Fees</h2>
										 
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="card-body">
								
											<div class="doctnowfrmds">
											<div class="card">
                                   <form action="<?= base_url('frees/update')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Home Fees Amount </label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="" name="frees" placeholder="Enter Frees Amount" class="form-control" data-validation="required" value="<?= $frees[0]->frees ?>"> 
                                                </div>
                                            </div>
                                            
                                            
                                            
                                             <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Call Fees Amount </label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="" name="call_fee" placeholder="Enter Frees Amount" class="form-control" data-validation="required" value="<?= $frees[0]->call_fees ?>"> 
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
