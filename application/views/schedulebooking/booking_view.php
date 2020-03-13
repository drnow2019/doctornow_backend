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
										<h2 class="title-1">Schedule Booking</h2>
							
									</div>
                                     <div class="col-md-6 col-xs-12">
                               <div class="searchbox">
                
                   <input type="text"  class="form-control enterSearch" id="keywords" placeholder="Search"   value="<?php echo $this->input->get('keywords');?>"/>
                  <button id="btnSearch"  class="btn btn search" onclick="searchFilter()"><i class="icon-search"></i> Search</button><a href="<?php echo base_url('schedulebooking');?>" class="btn "><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
														<th>Booking Request</th>
														<th>Email Id</th>
														<th>Phone No.</th>
														<th>Date</th>
														<th>Action</th>
														
													</tr>
												</thead>
												
											 <tbody id="postList">                        
                              
                                                <?php $this->load->view('schedulebooking/booking_in'); ?>
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
        url: '<?=base_url('schedulebooking/ajaxPaginationData')?>/'+page_num,
        data:csrf_name+'='+hash+'&'+dataVar,
        beforeSend: function () {
          $('.loading').show();
        },
        success: function (html) {
           // alert(html);exit();
          $('#postList').html(html);
            window.history.pushState("object or string", "Title", "<?=base_url('schedulebooking?')?>"+dataVar);
          $('.loading').fadeOut("slow");
         // location.reload();
        }
      });
    }

</script>
