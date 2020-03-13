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
                                        <h2 class="title-1"></h2>
                                    </div>

                                    <div class="col-sm-12">
                                      <div class="ExcelArea"> 
                                        <form method="POST" action="<?= base_url('notification/upload') ?>" enctype='multipart/form-data'>
                                          <label>Upload Excel</label>
                                          <input type="file" name="upload">
                                          <button type="submit" name="submit" value="Upload" class="UPLoad">Upload</button>
                                          <!-- <input type="submit" name="submit" value="Upload" class="UPLoad"> -->
                                        </form>
                                      </div>
                                    </div>



                                    <!-- <div class="col-md-9 col-xs-12">
                                        <div class="searchbox">
                                            <table>
                                                <form method="POST" action="<?= base_url('notification/upload') ?>" enctype='multipart/form-data'>
                                                    <tr>
                                                        <th>Upload Excel</th>
                                                        <td>
                                                            <input type="file" name="upload" class="form-control">
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="submit" name="submit" value="Upload" class="btn btn-success"> </td>
                                                    </tr>
                                                </form>
                                            </table>
                                        </div>
                                    </div> -->

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

                                                                <th>Title</th>
                                                                <th>Message</th>
                                                                <th>Date</th>
                                                                <th>Send Notification</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody id="postList">
                                                            <?php if(!empty($result)){
                                                              $sn=1;
                                                           foreach($result as $values){
                                                           ?>
                                                                <tr>
                                                                    <td>
                                                                        <?= $sn++?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $values->title ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= $values->message ?>
                                                                    </td>
                                                                    <td>
                                                                        <?= date('d-m-Y',strtotime($values->created_date))?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?= base_url('notification/sendUser/'.$values->id)?>" class="btn btn-success">Send to User</a>
                                                                        <a href="<?= base_url('notification/sendDoctor/'.$values->id)?>" class="btn btn-success">Send to Doctor</a>
                                                                    </td>
                                                                    <td>
                                                                        <div class="table-data-feature">
                                                                            <a href="JavaScript:Void(0)" class="item" onclick="editNotification('<?= $values->id ?>')">
                                                                                <i class="zmdi zmdi-edit"></i>
                                                                            </a>
                                                                            <?php define(BULK,'bulk_notification')?>
                                                                                <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(BULK)?>','id','<?=$values->id?>')">
                                                                                    <i class="zmdi zmdi-delete"></i>
                                                                                </button>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <?php }}else{ ?>
                                                                    <p>No Record found!</p>
                                                                    <?php } ?>

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

            <div id="formmodel" class="modal"></div>

        </div>
        <script>
            function editNotification(id) {
                // alert(id);
                $.ajax({
                    type: 'POST',
                    cache: false,
                    url: '<?= base_url("notification/edit")?>',
                    data: 'id=' + id,

                    success: function(html) {
                        //alert(html);
                        $("#formmodel").html(html);
                        $("#formmodel").modal('show');

                    }
                });
            }
        </script>

</body>

</html>

