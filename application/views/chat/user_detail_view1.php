<div class="chatbriefflow" id="scrollid">
     
      <?php                              
      if($chat){
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
                                        <p>No chat record found!</p>
                                        <?php } ?>
     </div>
<script>
var element = document.getElementById("scrollid");
element.scrollTop = element.scrollHeight ;
 </script>