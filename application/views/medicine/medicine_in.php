
												<?php 
                                                  $sn=1;
                                                 if(!empty($medicine)) :
                                                 	foreach($medicine as $values) :
                                                 	//    print_r($values);die;
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														
														<td><?= ucwords($values->name) ?></td>
														<td><?= $values->email?></td>
													   <td><?= $values->address ?></td>
													   <?php if($values->image){?>
													   <td title="Prescription Image"><a href="<?php echo $values->image ?>" target="_blank"><img src="<?php echo $values->image ?>" height="70" width="70" ></a></td>
													   <?php } else{?>
													   <td>  <span class="fa fa-file" title="No Prescription Uploaded" style="font-size:90px"></span</td>
													   <?php } ?>
													   <td><?php if($values->delivery_status=='1'){echo "Yes";}else{echo "No";}?></td>
													   <td>
													   <select onchange="deliveryStatus(this.value,'<?= $values->id ?>')">
													   <option value="0" <?php if($values->delivery_confirm_status==0){echo "selected";}?>>Pending</option>
													   <option value="1" <?php if($values->delivery_confirm_status==1){echo "selected";}?>>confirmed</option>
													   <option value="2" <?php if($values->delivery_confirm_status==2){echo "selected";}?>>cancelled</option>
													   </select>    
													   </td>	

															
													
														<td>
															<div class="table-data-feature"> 
														   <?php define(SESS,'doctor_session');?>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return delmedicine('<?= strrev(SESS) ?>','id','<?=$values->id?>','del_status','<?=$values->del_status?>');">
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
													