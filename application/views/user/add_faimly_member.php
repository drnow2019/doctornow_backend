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
                                        <h2 class="title-1">Add Family Member</h2>
                                        
                                    </div>
                                    <div class="col-md-12 tabdatabga">
                                    <div class="">
                                <!-- DATA TABLE-->
                                        <div class="card-body">
                                
                                            <div class="doctnowfrmds">
                                            <div class="card">
                                   <form action="<?= base_url('user/addmembervalue')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Member Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="name" name="name" placeholder="Enter Member Name" class="form-control" data-validation="required"> 
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">DOB</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="dob" name="dob" placeholder="Enter DOB" class="form-control datepicker" data-validation="required"> 
                                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Relationship</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="relationship" name="relationship" placeholder="Relationship" class="form-control" data-validation="required"> 
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
                                            
                                            
                                            
                                            
                                       
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
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
 