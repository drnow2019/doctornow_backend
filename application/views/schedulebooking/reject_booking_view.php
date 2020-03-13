
				<div id="reject_booking" class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="closingstfd">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body">
							<div class="rehectstatus">
								<div class="card">
								<div class="card-body card-block">
                                        <!--<form action="<?= base_url('homebooking/updateRejectStatus')?>" method="post"  class="form-horizontal">-->
                                           
                                            <div class="row form-group">
                                                <div class="col col-md-6">
                                                    <label for="text-input" class=" form-control-label">Select Reason for Reject Request</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <input type="hidden" name="booking_id"  id="booking_id" value="<?= $booking_id ?>" />
                                            
                                                    <select class="form-control" name="reject_reason" id="reject_reason">
														<option>Doctor is unavailable</option>
														<option>Location is Far</option>
													</select>
                                                </div>
                                            </div>
											
											
                                        <!--</form>-->
                                    </div>
										
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary btn-sm" data-target="#mediumModal43" onclick="rejectstatus()">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm" data-dismiss="modal" aria-label="Close">
                                            <i class="fa fa-ban"></i> Cancel
                                        </button>
                                    </div>
								</div>
							</div>
							
						</div>
						
					</div>
				</div>
				
			