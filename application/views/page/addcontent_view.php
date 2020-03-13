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
										<h2 class="title-1">Add New Page</h2>
										
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="card-body">
								
											<div class="doctnowfrmds">
											<div class="card">
                                   <form action="<?= base_url('content/addcontent')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Title</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="clinic_name" name="title" placeholder="Enter Page Name" class="form-control" data-validation="required"> 
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Description</label>
                                                </div>
                                                <div class="col-12 col-md-9">

                                                   <textarea class="form-control description" name="description" data-validation="" id="description"></textarea>
                                                </div>
                                            </div>
                                            
                                            	<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Type</label>
                                                </div>
                                                <div class="col-12 col-md-9">

                                                 <select class="form-control" name="type" data-validation="reuired">
                                                     <option>Select Type</option>
                                                     <option value ='0'>For Doctor</option>
                                                     <option value="1">For User</option>
                                                 </select>
                                                </div>
                                            </div>



                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Page Type</label>
                                                </div>
                                                <div class="col-12 col-md-9">

                                                 <select class="form-control" name="page_type" data-validation="reuired">
                                                     <option>Select Type</option>
                                                     <option value ='0'>About Us</option>
                                                     
                                                      <option value="1">FAQ</option>
                                                       <option value="2">Terms & Condition</option>
                                                        <option value="3">Privacy & Policy</option>
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
                                 <a href="<?= base_url('content')?>" class="btn btn-danger btn-sm">Cancel</a>

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