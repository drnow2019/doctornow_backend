<!DOCTYPE html>
<html lang="en">

<body class="">
    <div class="page-wrapper"> 
        <div class="page-container"> 
            <div id="usermgnt" class="tabcontent">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="overview-wrap">
                                        <h2 class="title-1">Notification  Management</h2>
                                    </div>

                                    <!-- <div class="col-md-6 col-xs-12">
                                        <div class="searchbox">

                                            <input type="text" class="form-control enterSearch" id="keywords" placeholder="Search" value="<?php echo $this->input->get('keywords');?>" />
                                            <button id="btnSearch" class="btn btn search" onclick="searchFilter()"><i class="icon-search"></i> Search</button>
                                            <a href="<?php echo base_url('notification');?>" class="btn "><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                            <a href="<?= base_url('notification/importnotification')?>" class="btn-danger" style="float: right;">Upload Excel</a>
                                        </div>
                                        <a href="<?= base_url('notification')?>" class="btn btn-success disabled">User Notification</a>
                                        <a href="<?= base_url('doctornotification')?>" class="btn btn-default">Doctor Notification</a>
                                    </div> -->

                                    <div class="NotificationSearch"> 
                                    	<a href="<?= base_url('notification/importnotification')?>" class="Upload">Upload Excel</a>

                                    	<div class="Search">
	                                        <input type="text" class="enterSearch" id="keywords" placeholder="Search" value="<?php echo $this->input->get('keywords');?>" />

                                            <button id="btnSearch" class="btn btn search" onclick="searchFilter()">
                                            	<i class="icon-search"></i> Search
                                            </button>

                                            <a href="<?php echo base_url('notification');?>">
                                            	<i class="fa fa-refresh" aria-hidden="true"></i>
                                            </a>
	                                    </div>

	                                    <div class="NotificationLink">
	                                    	<a href="<?= base_url('notification')?>" class="btn btn-success disabled">User Notification</a>
                                        	<a href="<?= base_url('doctornotification')?>" class="btn btn-default">Doctor Notification</a>
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
                                                                <th>Mobile</th>
                                                                <th>title</th>
                                                                <th>Message</th>
                                                                <th>Date</th>
                                                                <th>Delete</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="postList">

                                                            <?php $this->load->view('notification/notification_in'); ?>
                                                        </tbody>

                                                    </table>
                                                    <div class="loading" style="display: none;">
                                                        <div class="content"><img src="<?php echo base_url('assets/images/loading.gif'); ?>" /></div>
                                                    </div>
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

        <!-- Audio Uploads 4-->

</body>

</html>
<!-- end document-->
<script>
    function searchFilter(page_num, cur_page) {

        page_num = page_num ? page_num : 0;
        activePage = cur_page ? cur_page : 0;
        var keywords = $('#keywords').val();
        // var type       = $('#type').val();

        var limit = $('#limit').val();
        var dataVar = 'page=' + page_num + '&activePage=' + activePage + '&keywords=' + keywords + '&perpage=' + limit;
        $.ajax({
            type: 'GET',
            url: '<?=base_url('notification/ajaxPaginationData')?>/' + page_num,
            data: csrf_name + '=' + hash + '&' + dataVar,
            beforeSend: function() {
                $('.loading').show();
            },
            success: function(html) {
                // alert(html);exit();
                $('#postList').html(html);
                window.history.pushState("object or string", "Title", "<?=base_url('notification?')?>" + dataVar);
                $('.loading').fadeOut("slow");
                // location.reload();
            }
        });
    }
</script>