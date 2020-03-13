
												<?php 
                                                  $sn=1;
                                                 if(!empty($rating)) :
                                                 	foreach($rating as $values) :
                                                 	   // echo $values->doctor_id.'  ';
                                          //  $Avgrating  =     $this->my_model->getfields(RATING,'id,rating',array('doctor_id'=>$values->id)); 	
                                          $Avgrating =   $this->db->query("select id,AVG(rating) as rate from doctor_rating where doctor_id='".$values->doctor_id."'")->result();
                                         // echo $this->db->last_query();
                                        //  echo "<pre>";
                                        //  print_r($Avgrating);
                                        //  echo $this->db->last_query();
                                           // print_r($Avgrating);
                                           //echo $Avgrating[0]->rate;
                                            //echo $this->db->last_query();
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														
														<td> <?php  echo ucwords($values->name) ?></td>
														<td><?= ucwords($values->clinic_name)?></td>
													
														<td>
															<span class="ratings leftrtgd">
                                                                  
                                                           <input id="input-1" name="rating" class="rating rating-loading" data-min="0" data-max="5" data-step="0.5" value="<?php if($Avgrating[0]->rate){echo $Avgrating[0]->rate;}else{echo 0;} ?>" data-validation="required"></span>
														</td>
														

															
														
														<td>
															<div class="table-data-feature"> 
														
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(RATING)?>','id','<?=$Avgrating[0]->id?>')">
																<i class="zmdi zmdi-delete"></i>
															</button>
															</div>
														</td>
													</tr>

												<?php
		endforeach;
	else:

	?>
<tr>
	<td ><center><b style="color: red;">No Record Available</b></center></td>
</tr>
<?php
	endif;
	echo $this->ajax_pagination->create_links(); 
?>
													


