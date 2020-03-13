<!DOCTYPE html>
<html lang="en">
<style type="text/css">
 .EarningArea{margin:40px 0 0 0}
 .EarningArea .EarningBox{display:inline-block;width:45%;margin:0 30px 0 0;padding:25px;border:1px solid #eaeaea;box-shadow:0 10px 10px #ddd}
 .EarningArea .EarningBox p{padding:10px 0 10px 45px;position:relative;margin:0 0 12px 0;font-size:15px}
 .EarningArea .EarningBox p span.Icon{position:absolute;top:6px;left:0;width:30px;background-color:#000;height:30px;border-radius:50%;text-align:center;line-height:31px;font-size:11px;color:#fff}
 .EarningArea .EarningBox p:first-child span.Icon{background-color:green}
 .EarningArea .EarningBox p:last-child span.Icon{background-color:#ffa700;color:#000}
 .EarningArea .EarningBox p span.Price{float:right;font-weight:600;color:#000}

.Earning-Ttitle{
    margin:  0 0 20px;
    font-weight:  600;
    font-size: 23px;
}
.Earning-Ttitle span{
    font-size:  15px;
    color: #d70e0f;
    margin: 0 0 0 10px;
}

</style>
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
                                 <h2 class="Earning-Ttitle">Earning History <span>(Dr. <?= $doctor_name ?>)</span></h2>
                              </div>
                             <div class="row">
                                 
                                <div class="col-md-12">
                                    <div class="Doctor_Table">
                                        <!-- DATA TABLE-->
                                        <div class="table-responsive ">
                                            <table class="table table-borderless table-data3">
                                                <thead>
                                                    <tr>
                                                        <th>S No.</th>
                                                        <th>Amout</th>
                                                        <th>Payment Date</th>
                                                        <th style="width: 100%; padding: 8px 0; height: auto; ">Booking Type</th>
                                                      
                                                    </tr>
                                                </thead>
                                                <tbody id="postList">
                                                <?php if(!empty($earning)){ 
                                                   $sn = 1;
                                                   foreach($earning as $values){
                                                   ?>
                                                  <tr>
                                                     <td><?= $sn++ ?></td>
                                                     <td><?= $values->amount?></td>
                                                     <td><?= date('d-m-Y',strtotime($values->created_date))?></td>
                                                   <td style="text-align: left;"><?= $values->payment_type?></td>
                                                  </tr>
                                                  <?php }} else {?>
                                                 <tr><td> <p>No Earning Found!</p><td></td>
                                                  <?php } ?>
                                                    
                                                </tbody>

                                            </table>
                                           

                                        </div>
                                        <!-- END DATA TABLE-->
                                    </div>



                                    <div class="EarningArea">
                                       <div class="EarningBox">
                                          <p>
                                             <span class="Icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                             Total Earning by calls
                                             <span class="Price">Rs. <?php if($callEarning->amount){echo $callEarning->amount;}else{echo '0';} ?> </span>
                                          </p>
                                          <p>
                                             <span class="Icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                             Total Earning by Home vist : 
                                             <span class="Price">Rs. <?php if($homeEarning->amount){echo $homeEarning->amount;}else{ echo '0';} ?> </span>
                                          </p>
                                       </div>
                                       <div class="EarningBox">
                                          <p>
                                             <span class="Icon"><i class="fa fa-phone" aria-hidden="true"></i></span>
                                             Total  calls Visit
                                             <span class="Price"><?php if($totalcall){echo $totalcall;}else{echo '0';} ?></span>
                                          </p>
                                          <p>
                                             <span class="Icon"><i class="fa fa-home" aria-hidden="true"></i></span>
                                             Total Home Visit : 
                                             <span class="Price"><?php if($totalHome){echo $totalHome;}else{echo '0';} ?></span>
                                          </p>
                                       </div>
                                    </div>


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
      <!-- Audio Uploads 4-->
   </body>
</html>
<!-- end document-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
