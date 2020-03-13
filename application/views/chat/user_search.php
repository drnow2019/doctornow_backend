	
<div class="usersactvs Chat_List">
	<?php foreach($user as $list){ 
		$query = $this->db->query("select message,created_date from doctor_chat where user_id = $list->id order by id DESC")->row();
		$time = $this->com_model->calculateTime($query->created_date);
	  	$badgeCount = $this->my_model->coutrow('doctor_chat','id',array('user_id'=>$list->id,'user_type'=>'user','sender_type'=>'sender','status'=>'1','badge_count'=>'1'));
	?>
	
	<div class="userinfo">
		<a href="javascript:void(0)" onclick="userDetails('<?= $list->id?>')">
			<div class="userpic">					   
			    <?php if($list->image){?>
					<img src="<?= $list->image ?>" title="<?= ucwords($list->name)?>">
				<?php } else {?>
					<img src="<?= base_url('assets/images/avtar_dummy.png')?>" title="No Profile" />
				<?php } ?>
			</div>
		
			<div class="usrcrednt">
				<h6><?= ucwords($list->name) ?></h6>
				<span id="bage1_<?= $list->id?>">
					<span class="badge"><?php if($badgeCount){ echo  $badgeCount ;}?></span>
				</span>
				<p><?= substr($query->message,0,15) ?>......</p>				
				<p class="pstdrn"><?= $time ?></p>	
			</div>
		</a>					
	</div>
	<?php }?>
</div>


<script>
    function userDetails(id){
 		//alert(id); 
  		$("#show_chat_id").html("");
		$.ajax({
   			type:"POST",
      		url: "<?= base_url('userchat/userDetails')?>",
          	data:{
            	user_id:id
          	},
          	cache: false,
          		success:function(response){
                    // alert(response);
               		if(response){
                    	//alert("bage_"+id);
                     // location.reload();
                  		$("#hide_chat_id").css("display", "none");
                  		$("#bage1_"+id).css("display", "none");
                  		$("#show_chat_id").html(response);
                    //  $("#result").css("display", "block");                          
                	}                       
           		}
         	});
		}        
</script>
