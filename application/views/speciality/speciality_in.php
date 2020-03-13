
												<?php 
                                                  $sn=1;
                                                 if(!empty($speciality)) :
                                                 	foreach($speciality as $values) :
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														
														<td><?= $values->name ?>(<?= $values->hi_name?>)</td>
													
														<td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
														

															
														<td style="width:100px; text-align:center;">		
														   <button onclick="return rowstatus('<?= SPECIALITY ?>','id','<?=$values->id?>','status','<?=$values->status?>');"  title="Change Status" <?php if($values->status == '1' ){ ?> class="btn btn-success btn-xs"> <?php echo "Active "; } else { ?> class="btn btn-primary btn-xs"><?php  echo "Deactive"; } ?>
															</button> 
														</td>
														<td>
															<div class="table-data-feature"> 
															<a href="<?= base_url('speciality/edit/'.$values->id)?>" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(SPECIALITY)?>','id','<?=$values->id?>')">
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
													