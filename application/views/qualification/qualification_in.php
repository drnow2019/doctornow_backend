
												<?php 
                                                  $sn=1;
                                                 if(!empty($qualification)) :
                                                 	foreach($qualification as $values) :
												?>
													<tr id="<?= $values->id ?>">
														<td><?= $sn++ ?></td>
														<td><?= $values->name ?></td>
														
													   <td><?php if($values->status=='1'){echo "Active";}else{echo "Deactive";}?></td>
														<td><?= date('d-m-Y',strtotime($values->created_date)) ?></td>
													
														<td>
															<div class="table-data-feature"> 
															<a href="<?= base_url('qualification/edit/'.$values->id)?>" class="item">
																<i class="zmdi zmdi-edit"></i>
															</a>
															<button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(QUALIFICATION)?>','id','<?=$values->id?>')">
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
													