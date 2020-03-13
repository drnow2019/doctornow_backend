<!DOCTYPE html>
<html lang="en">

<div class="page-container">
            <!-- HEADER DESKTOP-->
            
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
        
            <div id="usermgnt" class="tabcontent">
                <div class="main-content">
                    <div class="sections">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap"> 
                                        <h2 class="title-1">Change Password</h2>
                                    </div>
                                         
                                    <div class="col-md-12">
                                  <div class="login-contents">

                      <?php if($this->session->flashdata('msg')){echo $this->session->flashdata('msg');}?>
                        <div class="login-forms">
                            <form action="<?= base_url('Changepassword/updatepassword')?>" method="POST" id="myForm">
                          

                              <div class="form-group">
                                   
                                    <input class="au-input au-input--full" type="password" name="old_pass" placeholder="Old Password" id="" data-validation="required">
                                  
                                    
                                </div>
                          <div class="form-group">
                                   
                                    <input class="au-input au-input--full" type="password" name="new_pass" placeholder="New Password" id="" data-validation="required">
                                  
                                    
                                </div>

                                <div class="form-group">
                                   
                                    <input class="au-input au-input--full" type="password" name="con_pass" placeholder="Confirm Password" id="" data-validation="required">

                                </div>

                                 
                                <input type="submit" name="submit" class="au-btn au-btn--block au-btn--green m-b-20" value="submit" id="smt">
                            </form>
                        </div>
                                </div>
                            </div>
                        </div>
                              
                    </div>
                </div>
            </div>
            
        </div>
<!-- <body class="">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">

   <br><br><br>

     <div class="overview-wrap">
                                        <h2 class="title-1">Change Password</h2>
                                        <button class="au-btn au-btn-icon au-btn--blue">
                                            <i class="zmdi zmdi-plus"></i>Add New Grade</button> 
                                    </div>
                                    <br>
                    <div class="login-contents">

                      <?php if($this->session->flashdata('msg')){echo $this->session->flashdata('msg');}?>
                        <div class="login-forms">
                            <form action="<?= base_url('Changepassword/updatepassword')?>" method="POST" id="myForm">
                          

                              <div class="form-group">
                                   
                                    <input class="au-input au-input--full" type="password" name="old_pass" placeholder="Old Password" id="" data-validation="required">
                                  
                                    
                                </div>
                          <div class="form-group">
                                   
                                    <input class="au-input au-input--full" type="password" name="new_pass" placeholder="New Password" id="" data-validation="required">
                                  
                                    
                                </div>

                                <div class="form-group">
                                   
                                    <input class="au-input au-input--full" type="password" name="con_pass" placeholder="Confirm Password" id="" data-validation="required">

                                </div>

                                 
                                <input type="submit" name="submit" class="au-btn au-btn--block au-btn--green m-b-20" value="submit" id="smt">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

 
</body>
 -->
</html>
<!-- end document-->