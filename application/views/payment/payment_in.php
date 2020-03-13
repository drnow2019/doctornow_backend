
												<?php 
                                                  $sn=1;
                                               
                                                 if(!empty($payment)) :
                                                 	foreach($payment as $values) :
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														<td><?= $values->username ?></td>
														<td><?= $values->useremail ?></td>
														<td><?= $values->usermobile?></td>
														<td><?= $values->name ?></td>
														<td><?= $values->email ?></td>
														<td><?= $values->mobile?></td>
														<td><?= number_format(round($values->amount),2).' INR'?></td>
														<td><?php 
														if($values->status=='TXN_SUCCESS'){echo "SUCCESS";}
															if($values->status=='TXN_FAILURE'){echo "FAILED";}
														?></td>
														<td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
													       <td>Online</td>
                                                           <td>
												
															<div class="table-data-feature"> 
														    
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(PAYMENT)?>','id','<?=$values->id?>')">
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
													