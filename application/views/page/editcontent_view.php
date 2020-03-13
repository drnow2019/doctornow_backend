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
										<h2 class="title-1">Edit Page</h2>
										
									</div>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="card-body">
								
											<div class="doctnowfrmds">
											<div class="card">
                                   <form action="<?= base_url('content/editcontent')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Title</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="hidden" value="<?= $page[0]->id ?>" name="page_id">
                                                    <input type="text" id="clinic_name" name="title" placeholder="Enter Page Name" class="form-control" data-validation="required" value="<?= $page[0]->title ?>"> 
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Description</label>
                                                </div>
                                                <div class="col-12 col-md-9">

                                                   <textarea class="form-control" name="description" data-validation="" id="description"><?= $page[0]->description ?></textarea>
                                                </div>
                                            </div>
											
											
												<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Type</label>
                                                </div>
                                                <div class="col-12 col-md-9">

                                                 <select class="form-control" name="type" data-validation="reuired">
                                                     <option>Select Type</option>
                                                     <option value ='0' <?php if($page[0]->type=='0'){echo "selected";}?>>For Doctor</option>
                                                     <option value="1" <?php if($page[0]->type=='1'){echo "selected";}?>>For User</option>
                                                 </select>
                                                </div>
                                            </div>
										
											
                                                <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Page Type</label>
                                                </div>
                                                <div class="col-12 col-md-9">

                                                 <select class="form-control" name="page_type" data-validation="reuired">
                                                     <option value="">Select Type</option>
                                                     <option value ='0'  <?php if($page[0]->page_type=='0'){echo "selected";}?>>About Us</option>
                                                   
                                                      <option value="1"  <?php if($page[0]->page_type=='1'){echo "selected";}?>>FAQ</option>
                                                       <option value="2"  <?php if($page[0]->page_type=='2'){echo "selected";}?>>Terms & Condition</option>
                                                       <option value="3"  <?php if($page[0]->page_type=='3'){echo "selected";}?>>Privacy & Policy</option>
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