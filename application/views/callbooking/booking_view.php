<!DOCTYPE html>
<html lang="en">



<body class="">
    <div class="page-wrapper">
        <!-- HEADER MOBILE-->
       
        <!-- END HEADER MOBILE-->

        <!-- MENU SIDEBAR-->
      
        <!-- END MENU SIDEBAR-->

        <!-- PAGE CONTAINER-->
        <div class="page-container">
            <!-- HEADER DESKTOP-->
        
            <!-- HEADER DESKTOP-->

            <!-- MAIN CONTENT-->
		
			<div id="usermgnt" class="tabcontent">
				<div class="main-content">
					<div class="section__content section__content--p30">
						<div class="container-fluid">
							<div class="row">
								<div class="col-md-12">
									<div class="overview-wrap"> 
										<h2 class="title-1">Call Booking</h2>
							
									</div>
                                     <div class="col-md-6 col-xs-12">
                               <div class="searchbox">
                
                   <input type="text"  class="form-control enterSearch" id="keywords" placeholder="Search"   value="<?php echo $this->input->get('keywords');?>"/>
                  <button id="btnSearch"  class="btn btn search" onclick="searchFilter()"><i class="icon-search"></i> Search</button><a href="<?php echo base_url('callbooking');?>" class="btn "><i class="fa fa-refresh" aria-hidden="true"></i></a>
              </div>
              </div>
               <?php
                                        if($this->session->flashdata('msg'))
                                               echo $this->session->flashdata('msg');
                                       ?>
									<div class="col-md-12 tabdatabga">
									<div class="">
                                <!-- DATA TABLE-->
										<div class="table-responsive m-b-40">
											<table class="table table-borderless table-data3">
												<thead>
													<tr>
															<th>S No.</th>
														<th>User Name</th>
														<!--<th>Booking Request</th>-->
														<th>Email Id</th>
														<th>Phone No.</th>
														<th>Date</th>
														<th>Time</th>
														<th>Status</th>
														<th>Action</th>
														
													</tr>
												</thead>
												
											 <tbody id="postList">                        
                              
                                                <?php $this->load->view('callbooking/booking_in'); ?>
                                           </tbody>
                                                
                                            </table>
                                 <div class="loading" style="display: none;" ><div class="content"><img src="<?php echo base_url('assets/images/loading.gif'); ?>"/></div></div> 
										</div>
                                <!-- END DATA TABLE-->
									</div>
							  
									</div>
								</div>
							</div>
						</div>
							  
					</div>
				</div>
            <!-- END MAIN CONTENT-->
            <!-- END PAGE CONTAINER-->
			</div>
			
			
		
		
        </div>
		
    </div>
	
	<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Number Of Children</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    <div class="card-body card-block">
                                       <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Classroom name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Classroom number</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
														<option value="3">4</option>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Children</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Nannies</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
                                        </form>

                                            
                                            
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal2" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Nannies</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    <div class="card-body card-block">
                                       <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Enter Your Name" class="form-control">
                                                </div>
                                            </div>
											
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Enter Your Surname" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Username</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Enter Your Username" class="form-control">
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="password-input" class=" form-control-label">Password</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="password" id="password-input" name="password-input" placeholder="Enter Your Password" class="form-control">
                                                </div>
                                            </div>
                                        </form>

                                            
                                            
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="mediumModal3" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Children</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    <div class="card-body card-block">
                                       <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Name and </label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Age (birth date)</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Profile photo (optional)</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="file" id="file-input" name="file-input" class="form-control-file">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Father Name</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Mother Name and Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Surname</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="select" class=" form-control-label">Classroom number</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <select name="select" id="select" class="form-control">
                                                        <option value="0">Please select</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
														<option value="3">4</option>
                                                    </select>
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Children</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
											
											<div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="text-input" class=" form-control-label">Number of Nannies</label>
                                                </div>
                                                <div class="col-12 col-md-9">
                                                    <input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control">
                                                    
                                                </div>
                                            </div>
                                        </form>

                                            
                                            
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
	<!-- Audio Uploads 4-->
	
			<div class="modal fade" id="mediumModal4" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Upload Audio</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="mediumModal5" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Upload Photo/Video</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal6" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Children Meal Duration</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			
			<div class="modal fade" id="mediumModal7" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Children Nap Duration</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal8" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Toilet</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal9" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Activities</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="mediumModal10" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Report</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="card">
                                   
                                    
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary btn-sm">
                                            <i class="fa fa-dot-circle-o"></i> Submit
                                        </button>
                                        <button type="reset" class="btn btn-danger btn-sm">
                                            <i class="fa fa-ban"></i> Reset
                                        </button>
                                    </div>
                                </div>
						</div>
						
					</div>
				</div>
			</div>
			

   
</body>

</html>
<!-- end document-->
<script>
    function searchFilter(page_num,cur_page) {

      page_num       = page_num?page_num:0;
      activePage     = cur_page?cur_page:0;
      var keywords   = $('#keywords').val();
     // var type       = $('#type').val();
      
      var limit    = $('#limit').val();
      var dataVar = 'page='+page_num+'&activePage='+activePage+'&keywords='+keywords+'&perpage='+limit;
      $.ajax({
        type: 'GET',
        url: '<?=base_url('callbooking/ajaxPaginationData')?>/'+page_num,
        data:csrf_name+'='+hash+'&'+dataVar,
        beforeSend: function () {
          $('.loading').show();
        },
        success: function (html) {
           // alert(html);exit();
          $('#postList').html(html);
            window.history.pushState("object or string", "Title", "<?=base_url('callbooking?')?>"+dataVar);
          $('.loading').fadeOut("slow");
         // location.reload();
        }
      });
    }

</script>
<script>
  function rowstatus1(status,booking_id) {
  //alert(status);
  //alert(booking_id);
  var confirmModal = 
  $('<div class="modal fade">' +        
          '<div class="modal-dialog" style="width:450px">' +
          '<div class="modal-content">' +
          '<div class="modal-header">' +
            '<h4>Status Confirmation</h4>' +
            '<a class="close" data-dismiss="modal" >&times;</a>' +
          
          '</div>' +

          '<div class="modal-body">' +
            //'<p>Hi do you want to Change '+ currstatus +' To status '+changestatus+'? </p>' +
      '<p>Are you sure you want to Change  status  ? </p>' +
          '</div>' +

          '<div class="modal-footer">' +
            '<button id="cancelButton" class="btn btn-danger btn-sm" data-dismiss="modal" style="width:70px;border-radius:40px;padding:6px 15px">No</button>' +
            '<button id="okButton" class="btn btn-success btn-sm" style="width:70px;border-radius:40px;padding:6px 15px">Yes </button>' +
          '</div>' +
          '</div>' +
          '</div>' +
        '</div>');
        
          confirmModal.find('#cancelButton').click(function(event) {  
          
         location.reload(); 
      }); 
    
    confirmModal.find('#okButton').click(function(event) {
     $.ajax({

        'url' : "<?= base_url('homebooking/bookingStatus')?>",
        'type' : 'GET',
        'data' : {
           // table       : table,
           // idfield     : idfield,
            id        : booking_id,
           // statusfield   : statusfield,
            status      : status,
        },
        'success' : function(res) {
          //  alert(res);
    if(res == "ok"){ 
        if(status!=2){
        location.reload();}
    
       // alert("open modal");
                      if(status==2)
                      
                      {
                        //  myfunction(booking_id);
                    $("#myModal").modal('show');
              
                      }

    }
    else { alert('Error');  }
    
        },
        'error' : function(request,error)
        {
            alert("Request: "+JSON.stringify(request));
        }
    });

  confirmModal.modal('hide');
    }); 

    confirmModal.modal('show'); 

};
</script>
