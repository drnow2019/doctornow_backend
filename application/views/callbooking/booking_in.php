
												<?php 
												
												// echo"<pre>";print_r($booking);die;
                                                  $sn=1;
                                                 if(!empty($booking)) :
                                                 	foreach($booking as $values) :
                                           // $bookingReq   = $this->my_model->coutrow(BOOKING,"id",array('user_id'=>$values->user_id,'booking_type'=>'call'));    
                                                 	  
												?>
													<tr id="<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														<td><?= ucwords($values->user) ?></td>
														<td><?= $values->email ?></td>
														<td><?= $values->mobile ?></td>
												        <td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
													    <td><?= date('h:i A',strtotime($values->created_date)) ?></td>
                                                         <td>
													  <select onchange="rowstatus1(this.value,'<?= $values->booking_id ?>')">
													    <option value="0" <?php if($values->booking_status=='0'){echo "selected";}?> >Pending</option>
													    <option value="1" <?php if($values->booking_status=='1'){echo "selected";}?>>Accept</option>
													    <option value="2" <?php if($values->booking_status=='2'){echo "selected";}?>>Reject</option>
													    <!--<option value="3" <?php if($values->booking_status=='3'){echo "selected";}?>>Payment</option>-->
													     <option value="5" <?php if($values->booking_status=='5'){echo "selected";}?>>Cancel</option>
													  </select>      
													    </td>

													<td><a href="<?= base_url('callbooking/details/'.$values->booking_id)?>" class="item" title="view bookings">
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
													