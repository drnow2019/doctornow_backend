
												<?php 
												
												 // echo"<pre>";print_r($specificpromocode);die;
                                                  $sn=1;
                                                 if(!empty($specificpromocode)) :
                                                 	foreach($specificpromocode as $values) :
                                                 	  
												?>
													<tr id="<?= $values->id ?>">
														<td><?= $sn++ ?></td>
													
														<td><?= ucwords($values->doctor) ?></td>
													
														<td><?= $values->spe ?></td>
														<td><?= $values->promocode ?></td>
													    <td><?= $values->offer_discount ?></td>
														<td><?= date('d-m-Y',strtotime($values->validity)) ?></td>
													

														<td>
															<div class="table-data-feature"> 
															<a href="<?= base_url('specificpromocode/edit/'.$values->id)?>" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(SPECIFICPROMO)?>','id','<?=$values->id?>')">
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
													