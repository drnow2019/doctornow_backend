
												<?php 
                                                  $sn=1;
                                               
                                                 if(!empty($earning)) :
                                                 	foreach($earning as $values) :
												?>
													<tr id="user_<?= $values->id ?>">
														<td><?= $sn++ ?></td>
													
														<td><?= $values->name ?></td>
														<td><?= $values->email ?></td>
														<td><?= $values->mobile?></td>
														<td><?= number_format(round($values->amt),2).' INR'?></td>
													   <td><a href="<?= base_url('earning/history/'.$values->doctor_id)?>" class="btn btn-success">Earning History</td>
													
													
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
													