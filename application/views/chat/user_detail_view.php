<h2 align="center"><?= ucwords($chat[0]->name) ?></h2><hr>
<br>
<span id="chat1">
 <div class="chatbriefflow" id="messageScrollArea">
     
      <?php                              
      if(!empty($chat)){
                                         foreach($chat as $values){
                                             $time = $this->com_model->calculateTime($values->created_date);
                                        if($values->sender_type=="sender"){?>
                                        <div class="userinfo">
                                            <div class="leftsidepane">
                                                <div class="userpic">
                                                    <?php if($values->image){?>
                                                    <img src="<?= $values->image ?>" title="<?= ucwords($values->name)?>">
                                                    <?php } else {?>
                                                    <img src="<?= base_url('assets/images/avtar_dummy.png')?>" title="No Profile" />
                                                    <?php } ?>
                                                </div>
                                                <div class="usrcrednt">
                                                    <h6><?= ucwords($values->name) ?></h6>
                                                    <p><?= $values->message?></p>
                                                    
                                                    <p class="pstdrn"><?= $time ?></p>
                                                    
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
                                                    <h6>Admin</h6>
                                                    <p><?=$values->message ?></p>
                                                    <p class="statusdrn"><span class="gnblb">Active</span></p>
                                                    <p class="pstdrn"><?= $time ?></p>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <?php } }}else{?>
                                        <h3>No chat record found!</h3>
                                        <?php } ?>
     </div>
   </span>

   <span id="show"></span>

<div class="chatsendbdn">
  <div class="col-12 col-md-12">
    <input type="text" id="text-input<?= $user_id ?>" name="text-input" placeholder="Write here..." class="form-control myInput">
    <div class="card-footer">
        <input type="hidden" name="" value="<?= $user_id ?>" id="myid">
        <input type="hidden" name="" value="<?= $user_id ?>" id="userid<?= $user_id ?>">
        <button type="button" class="btn btn-primary btn-sm enterSearch" onclick="myfunction(this.id)" id="<?= $user_id ?>">
        Send
        </button>
    </div>
  </div>
</div>
                                   
                                   
                                        


<script type="text/javascript" language="javascript" >
//$(document).ready(function(){
  
  function load_data(userid)
  {
   // alert(userid);
    $.ajax({
      url:"<?php echo base_url('userchat/userDetails1'); ?>",
    //  dataType:"JSON",

      method:"POST",
       data:{
                           
                user_id:userid,
            },
          cache: false,               
      success:function(data){
          $("#chat1").css("display", "none");
        $("#show").html(data);
       
      //  alert(data.length);exit();

       
      }
    });
  }


 function myfunction(id) {
      var id1 = "#text-input"+id;
      var id2 = "#userid"+id;      

      var text = $(id1).val();
      var userid = $(id2).val();
      if(text==''){
        alert('Please enter message');
        return false;
      }
      $.ajax({
          url:"<?php echo base_url('userchat/saveData'); ?>",
          method:"POST",
          async: true,
          data:{
                  text:text,
                  user_id:userid,
               },
          cache: false,
          success:function(data){
           // alert(data);
              $(id1).val("");
              load_data(userid);
              // $('#messageScrollArea').scrollTop(1E10);
              test();

          }
      });
 }


  
//});
</script>   
<script>
  $(".myInput").keyup(function(e){
        var myid  = $("#myid").val(); 
        var code = (e.keyCode ? e.keyCode : e.which);
    if(code == 13) { //Enter keycode
     // alert(myid);exit();
        // window.location.href="http://videoreviewclub.com/search?q="+keywords;
        myfunction(myid);
    }      
})


  function test()
  {
     $("#hide_search_id").css("display", "none");
      //  $("#hide_chat_id").css("display", "block");
      //alert();
        $.ajax({
          url:"<?php echo base_url('userchat/getuser'); ?>",
          method:"POST",
          async: true,
          data:{

                
               },
          cache: false,
          success:function(data){
            $("#saveDiv").html(data);
           // alert(data);
            //  $(id1).val("");
             // load_data(userid);
              // $('#messageScrollArea').scrollTop(1E10);
             // test();
          }
      });
  }
    
 </script>                            
                                        
   <script>
var element = document.getElementById("messageScrollArea");
element.scrollTop = element.scrollHeight ;
 </script>                                                                   
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
