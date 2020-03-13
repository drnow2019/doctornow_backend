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
                                        <h2 class="title-1">Edit Promo Code</h2>
                                        
                                    </div>
                                    <div class="col-md-12 tabdatabga">
                                    <div class="">
                                <!-- DATA TABLE-->
                                        <div class="card-body">
                                
                                            <div class="doctnowfrmds">
                                            <div class="card">
                                   <form action="<?= base_url('specificpromocode/editpromo')?>" method="post"  class="form-horizontal" id="myForm">
                                    <div class="card-body card-block">
                                        
                                           
                                           
                                            
                                             <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Select Doctor</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="hidden" value="<?= $spePromo[0]->id ?>" name="promo_id" >
                                                    <select class="form-control" data-validation="required" name="doctor">
                                                        <option value="">Select Doctor</option>
                                                        <?php 
                                                         if($doctor):
                                                        foreach($doctor as $doc):?>
                                                        <option value="<?= $doc->id ?>" <?php if($doc->id==$spePromo[0]->doctor_id){echo "selected";} ?>><?= $doc->name ?></option>
                                                        <?php endforeach;endif;?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                             <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Select Dept./Specialty
                                                        </label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select class="form-control" data-validation="required" name="specialty">
                                                        <option value="">Select Dept./Specialty</option>
                                                         <?php 
                                                         if($specialty):
                                                        foreach($specialty as $spe):?>
                                                        <option value="<?= $spe->id ?>" <?php if($spe->id==$spePromo[0]->specialty_id){echo "selected";} ?>><?= $spe->name ?></option>
                                                        <?php endforeach;endif;?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                           
                                            
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Promo Code</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="promo_code" name="promo_code" placeholder="Enter Promo Code" class="form-control" data-validation="required" value="<?= $spePromo[0]->promocode ?>"> 
                                                </div>
                                            </div>
                                            
                                              <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Offer Discount</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="offer_discount" name="offer_discount" placeholder="Enter Offer Discount(%)" class="form-control" data-validation="required" value="<?= $spePromo[0]->offer_discount ?>" onkeypress="return numbersonly(event)" maxlength="3"> 
                                                </div>
                                            </div>
                                            
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Offer Validity</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="validity" name="validity" placeholder="" class="form-control datepicker" data-validation="required" value="<?= date('d-m-Y',strtotime($spePromo[0]->validity)) ?>"> 
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
                                        <a href="<?= base_url('specificpromocode')?>" class="btn btn-danger btn-sm">Cancel</a>

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
