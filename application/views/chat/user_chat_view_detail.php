
<!DOCTYPE html>
<html lang="en">


<body class="">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
      

      

        <!-- PAGE CONTAINER-->
        <div class="page-container">
           
            <!-- MAIN CONTENT-->
        
            <div id="usermgnt" class="tabcontent">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap"> 
                                        <h2 class="title-1">Live Support Management</h2>
                                        
                                    </div>
                                    <div class="col-md-12 tabdatabga">
                                    <div class="userchatboards">
                                    <div class="chatlistingbrd">
                                        <input type="text" class="form-control" placeholder="Search Here.."  id="search_text" autocomplete="off">
                                        <span id="hide_search_id">
                                        <div class="usersactvs">
                                            <?php foreach($user as $list){?>
                                            <div class="userinfo">
                                                <div class="userpic">
                                                      <?php if($list->image){?>
                                                    <img src="<?= $list->image ?>" title="<?= ucwords($list->name)?>">
                                                    <?php } else {?>
                                                    <img src="<?= base_url('assets/images/avtar_dummy.png')?>" title="No Profile" />
                                                    <?php } ?>
                                                </div>
                                                <a href="<?= base_url('userchat/chat/'.$list->id)?>" >
                                                <div class="usrcrednt">
                                                    <h6><?= ucwords($list->name) ?></h6>
                                                    <p>Loren ispsum sit amir...</p>
                                                    <p class="statusdrn"><span class="gnblb">Active</span></p>
                                                    <p class="pstdrn">2 day Ago</p>
                                                    
                                                </div>
                                            </a>
                                                
                                            </div>
                                            <?php } ?>
                                            
                                            
                                            
                                            
                                        </div>
                                    </span>
                                    <div id="load_data2"></div>
                                    </div>
                                    
                                    
                                    <div class="charboardsshowpan">
                                    <span id="hide_chat_id">    
                                    <div class="chatbriefflow">
                                        <?php 
                                         foreach($chat as $values){
                                        if($values->sender_type=="sender"){?>
                                        <div class="userinfo">
                                            <div class="leftsidepane">
                                                <div class="userpic">
                                                    <img src="images/icon/avatar-01.jpg">
                                                </div>
                                                <div class="usrcrednt">
                                                    <h6>Alex john</h6>
                                                    <p>Loren ispsum sit amir...</p>
                                                    <p class="statusdrn"><span class="gnblb">Active</span></p>
                                                    <p class="pstdrn">2 day Ago1</p>
                                                    
                                                </div>
                                            </div>  
                                        </div>
                                        <?php } else{?>
                                        
                                        <div class="userinfo">
                                            <div class="rightsidepane">
                                                <div class="userpic">
                                                    <img src="images/icon/avatar-01.jpg">
                                                </div>
                                                <div class="usrcrednt">
                                                    <h6>Alex john</h6>
                                                    <p>Loren ispsum sit amir...</p>
                                                    <p class="statusdrn"><span class="gnblb">Active</span></p>
                                                    <p class="pstdrn">2 day Ago2</p>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php } }?>
                                      
                                        
                                        </div>
                                    </span>
                                    <div id="show_chat_id"></div>
                                        
                                        
                                        
                                    </div>
                                
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
    
    
        
            

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
<script>
$(document).ready(function(){

 //load_data();

 function load_data(query)
 {
     //alert
  $.ajax({
   url:"<?= base_url('userchat/fetchuser')?>",
   method:"POST",
   data:{keywords:query},
   success:function(data){
       //alert(data);exit();
    $('#load_data2').html(data);
    $("#hide_search_id").css("display", "none");

   }
  })
 }

 $('#search_text').keyup(function(){
  var search = $(this).val();
  //alert(search);exit();
  if(search != '')
  {
   load_data(search);
  }
  else
  {
   load_data();
  }
 });
});


</script>

