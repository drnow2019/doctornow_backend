
												<?php 
                                                  $sn=1;
                                                 if(!empty($user)) :
                                                 	foreach($user as $values) :
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														<td><?= $values->name ?></td>
														<td><?= $values->email ?></td>
														<td><?= $values->mobile?></td>
														<td><?php if($values->dob!='0000-00-00') {echo date('d-m-Y',strtotime($values->dob)); } ?></td>
														<td><?php  if($values->gender=='m'){echo "Male";}else{echo "Female";} ?></td>
														<td>
														    <?php if($values->image){?>
													<a href="<?= $values->image?>" target="_blank">	    
														<img src="<?= $values->image ?>" height="50" width="50" title="<?= $values->name ?>"  style="border-radius: 25px;" /></a>
														<?php } else{ ?>
													   <img src="<?= base_url('assets/images/avtar_dummy.png')?>"  title="No Image" height="50" width="50" style="border-radius: 25px;"/>
													   <?php } ?>
														</td>

															
														<td style="width:100px; text-align:center;">		
														   <button onclick="return rowstatus1('<?=USER ?>','id','<?=$values->id?>','status','<?=$values->status?>');"  title="Change Status" <?php if($values->status == '1' ){ ?> class="btn btn-success btn-xs"> <?php echo "Unblocked "; } else { ?> class="btn btn-primary btn-xs"><?php  echo "Blocked"; } ?>
															</button> 
														</td>
														<td><a class ="btn btn-info" href="<?= base_url('user/medicalHistory/'.$values->id)?>">View Medical History</a></td>
															<td><a class ="btn btn-info" href="<?= base_url('user/faimlymember/'.$values->id)?>">Family member</a></td>
														<td>
															<div class="table-data-feature"> 
															<a href="<?= base_url('user/edit/'.$values->id)?>" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow1('<?=strrev(USER)?>','id','<?=$values->id?>')">
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
													