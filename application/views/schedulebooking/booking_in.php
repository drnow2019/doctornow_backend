
												<?php 
												
												// echo"<pre>";print_r($booking);die;
                                                  $sn=1;
                                                 if(!empty($scheduling)) :
                                                 	foreach($scheduling as $values) :
                                                 	  //  print_r($values);die;
                                            $bookingReq   = $this->my_model->coutrow(BOOKING,"id",array('user_id'=>$values->user_id,'booking_type'=>'scheduling'));    
                                                 	  
												?>
													<tr id="<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														<td><?= ucwords($values->user) ?></td>
														<td><?php echo $bookingReq ?></td>
														<td><?= $values->email ?></td>
														<td><?= $values->mobile ?></td>
												        <td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
													

													<td><a href="<?= base_url('schedulebooking/details/'.$values->user_id)?>" class="item" title="view bookings">
																<i class="fas fa-eye"></i>
															</a></td>
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
													