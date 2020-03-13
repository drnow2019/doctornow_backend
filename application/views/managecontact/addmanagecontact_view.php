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
                    <h2 class="title-1">Add Contact No</h2>
                    
                  </div>
                  <div class="col-md-12 tabdatabga">
                  <div class="">
                                <!-- DATA TABLE-->
                    <div class="card-body">
                
                      <div class="doctnowfrmds">
                      <div class="card">
                                   <form action="<?= base_url('managecontact/addcontact')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                         
                      
                                              <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Contact No</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="" name="contact_no" placeholder="Enter contact No" class="form-control" data-validation="required" onkeypress="return numbersonly(event)"> 
                                                </div>
                                            </div>
                                            
                                             <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Location</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="" name="location" placeholder="Enter Location" class="form-control" data-validation="required"  > 
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
                                        <a href="<?= base_url('managecontact')?>" class="btn btn-danger btn-sm">Cancel</a>
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
