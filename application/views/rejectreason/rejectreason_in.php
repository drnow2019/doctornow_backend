
												<?php 
                                                  $sn=1;
                                                 if(!empty($rejectreason)) :
                                                 	foreach($rejectreason as $values) :
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														
														<td><?= $values->name ?>(<?= $values->hi_name ?>)</td>
													
														<td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
														

															
														<td style="width:100px; text-align:center;">		
														   <button onclick="return rowstatus('<?= REASON ?>','id','<?=$values->id?>','status','<?=$values->status?>');"  title="Change Status" <?php if($values->status == '1' ){ ?> class="btn btn-success btn-xs"> <?php echo "Active "; } else { ?> class="btn btn-primary btn-xs"><?php  echo "Deactive"; } ?>
															</button> 
														</td>
														<td>
															<div class="table-data-feature"> 
															<a href="<?= base_url('rejectreason/edit/'.$values->id)?>" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(REASON)?>','id','<?=$values->id?>')">
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
													