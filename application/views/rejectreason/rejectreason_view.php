<!DOCTYPE html>
<html lang="en">

<body class="">
    <div class="page-wrapper"> 
        <div class="page-container">  

            <div id="usermgnt" class="tabcontent">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">

                        	<div class="overview-wrap">
                                <h2 class="title-1">Reason Management</h2>

                                

                            </div>




                        	<div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="searchbox">
                                       	<input type="text" class="form-control enterSearch" id="keywords" placeholder="Search" value="<?php echo $this->input->get('keywords');?>" />
                                            
                                        <button id="btnSearch" class="btn btn search" onclick="searchFilter()"><i class="icon-search"></i> Search</button>

                                        <a href="<?php echo base_url('rejectreason');?>" class="btn "><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="Add_Button">
                                        <a href="<?= base_url('rejectreason/add')?>"> <i class="zmdi zmdi-plus"></i>Add New Reason</a>
                                    </div>
                                </div>
                            </div>


                            <?php
                                if($this->session->flashdata('msg'))
                              	echo $this->session->flashdata('msg');
                           	?>




                            <div class="row">
                                <div class="col-md-12">                                    
                                    <div class="col-md-12 tabdatabga">
                                        <div class=""> 
                                            <div class="table-responsive m-b-40">
                                                <table class="table table-borderless table-data3">
                                                    <thead>
                                                        <tr>
                                                            <th>S No.</th>
                                                            <th>Reason Name</th>

                                                            <th>Date</th>
                                                            <th>Status</th>
                                                            <th>Manage Info</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tbody id="postList">

                                                            <?php $this->load->view('rejectreason/rejectreason_in'); ?>
                                                        </tbody>

                                                    </tbody>
                                                </table>
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
            url: '<?=base_url('rejectreason/ajaxPaginationData')?>/' + page_num,
            data: csrf_name + '=' + hash + '&' + dataVar,
            beforeSend: function() {
                $('.loading').show();
            },
            success: function(html) {
                // alert(html);exit();
                $('#postList').html(html);
                window.history.pushState("object or string", "Title", "<?=base_url('rejectreason?')?>" + dataVar);
                $('.loading').fadeOut("slow");
                // location.reload();
            }
        });
    }
</script>
<!-- end document-->