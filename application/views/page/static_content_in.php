
												<?php 
                                                  $sn=1;
                                                 if(!empty($content)) :
                                                 	foreach($content as $values) :
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														
														<td><?= $values->title ?></td>
														<td><?= substr($values->description,0,200)?></td>
														<td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
														
                                                         <td><?php if($values->type==0){echo "Doctor";}else{echo "User";} ?></td>  
															
														<td style="width:100px; text-align:center;">		
														   <button onclick="return rowstatus('<?= PAGE ?>','id','<?=$values->id?>','status','<?=$values->status?>');"  title="Change Status" <?php if($values->status == '1' ){ ?> class="btn btn-success btn-xs"> <?php echo "Active "; } else { ?> class="btn btn-primary btn-xs"><?php  echo "Inactive"; } ?>
															</button> 
														</td>
														
														<td>
															<div class="table-data-feature"> 
															<a href="<?= base_url('content/edit/'.$values->id)?>" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(PAGE)?>','id','<?=$values->id?>')">
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
													