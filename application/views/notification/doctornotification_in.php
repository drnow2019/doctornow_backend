
												<?php 
                                                  $sn=1;
                                                 if(!empty($notification)) :
                                                 	foreach($notification as $values) :
												?>
													<tr id="<?= $values->id ?>">
														<td><?= $sn++ ?></td>
													
														<td><?= $values->name ?></td>
														<td><?= $values->mobile ?></td>
													    <td><?= $values->title ?></td>
													    <td><?= $values->message ?></td>
														<td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
													

														<td>
															<div class="table-data-feature"> 
														    <?php define(NOTIFICATION,'notification')?>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(NOTIFICATION)?>','id','<?=$values->id?>')">
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
													