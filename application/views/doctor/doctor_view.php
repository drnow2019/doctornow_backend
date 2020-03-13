<!DOCTYPE html>
<html lang="en">

<style>

#loader{ display:none;}

    .Loader{
            background: #ffffff94;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9;
    align-items: center;
    justify-content: center;
    display: flex;
    }
    .Loader img{ width:300px; }
</style>
<body class="">
    <div class="page-wrapper"> 
        <div class="page-container"> 
            <div id="usermgnt" class="tabcontent">
                <div class="main-content">
                    <div class="section__content section__content--p30">
                        <div class="container-fluid">

                            <div class="overview-wrap">
                                <h2 class="title-1">Doctors</h2>
                                
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="searchbox">
                                        <input type="text" class="form-control enterSearch" id="keywords" placeholder="Search" value="<?php echo $this->input->get('keywords');?>" />

                                        <button id="btnSearch" class="btn btn search" onclick="searchFilter()"><i class="icon-search"></i> Search</button>

                                        <a href="<?php echo base_url('doctor');?>" class="btn "><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="Add_Button">
                                        <a href="<?= base_url('doctor/add')?>"> <i class="zmdi zmdi-plus"></i>Add Doctor</a>
                                    </div>
                                </div>
                            </div>

                            <?php
                                if($this->session->flashdata('msg'))
                                echo $this->session->flashdata('msg');
                            ?>

                            <div class="row">
                                 
                                <div class="col-md-12 tabdatabga">
                                    <div class="Doctor_Table">
                                        <!-- DATA TABLE-->
                                        <div class="table-responsive m-b-40">
                                            <table class="table table-borderless table-data3">
                                                <thead>
                                                    <tr>
                                                        <th>S No.</th>
                                                        <th>Full Name</th>
                                                        <th>Email Id</th>
                                                        <th>Date of Birth</th>
                                                        <th>Phone Number</th>
                                                        <th>Address</th>
                                                        <th>City</th>
                                                        <th>Speciality</th>
                                                        <th>Profile</th>
                                                        <th>Block/Unblock</th>
                                                        <th>Verified/Unverified</th>
                                                        <th>Earning History</th>
                                                        <th>Edit Info</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="postList">

                                                    <?php $this->load->view('doctor/doctor_in'); ?>
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
        </div>
    </div>

                                    <div id="loader">
                                        <div class="Loader">
                                             <img src="<?= base_url('assets/loading_new_img.gif')?>">
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
        url: '<?=base_url('doctor/ajaxPaginationData')?>/'+page_num,
        data:csrf_name+'='+hash+'&'+dataVar,
        beforeSend: function () {
          $('.loading').show();
        },
        success: function (html) {
           // alert(html);exit();
          $('#postList').html(html);
            window.history.pushState("object or string", "Title", "<?=base_url('doctor?')?>"+dataVar);
          $('.loading').fadeOut("slow");
         // location.reload();
        }
      });
    }

</script>

<script>
    function deleterow1(table,fieldname,fieldvalue) {
    //alert(fieldvalue);exit();
  var confirmModal = 
  $('<div class="modal fade">' +        
          '<div class="modal-dialog" style="width:450px">' +
          '<div class="modal-content">' +
          '<div class="modal-header">' +
           '<h4>Delete Confirmation</h4>' +
            '<a class="close" data-dismiss="modal" >&times;</a>' +
           
          '</div>' +

          '<div class="modal-body">' +
            '<p>Are you sure want to delete this records  ? </p>' +
          '</div>' +

          '<div class="modal-footer">' +
            '<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:70px;border-radius:40px;padding:4px 8px">CANCEL</button>' +
            '<button id="okButton" class="btn btn-success btn-sm" style="width:70px;border-radius:40px;padding:4px 5px">CONFIRM </button>' +
          '</div>' +
          '</div>' +
          '</div>' +
        '</div>');
    confirmModal.find('#okButton').click(function(event) {
     $.ajax({
      'url'   : "<?=base_url('doctor/deleteRecords')?>",
      'type'  : 'POST',
      'cache' : 'false',
      'async' : 'isAsync',
      
      'data'  : {
            csrf_name   : csrf_name,
            table     : table,
            fieldname   : fieldname,
            fieldvalue  : fieldvalue,
          },
      'beforeSend': function () {
              $('.loading').show();
            },
      'success' : function(res) {
    //  alert(res); exit();
        if(res == 1){ 
          $("#"+fieldvalue+"").remove();
        }
        else { location.reload(); }
        $('.loading').fadeOut("slow");
        location.reload();
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
  
  <script>
  function rowstatus1(table,idfield,id,statusfield,status) {
  
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
            '<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:70px;border-radius:40px;padding:6px 15px">No</button>' +
            '<button id="okButton" class="btn btn-success btn-sm" style="width:70px;border-radius:40px;padding:6px 15px">Yes </button>' +
          '</div>' +
          '</div>' +
          '</div>' +
        '</div>');
    
    confirmModal.find('#okButton').click(function(event) {
     $.ajax({

        'url' : "<?= base_url('doctor/change_status')?>",
        'type' : 'GET',
        'data' : {
            table       : table,
            idfield     : idfield,
            id        : id,
            statusfield   : statusfield,
            status      : status,
        },
        'success' : function(res) {
    if(res == "ok"){ location.reload(); }
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
  <script>
  function rowstatus2(table,idfield,id,statusfield,status) {
  //alert();exit();
   // $("#loader").css("display", "block");exit(); 
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
            '<button class="btn btn-danger btn-sm" data-dismiss="modal" style="width:70px;border-radius:40px;padding:6px 15px">No</button>' +
            '<button id="okButton" class="btn btn-success btn-sm" style="width:70px;border-radius:40px;padding:6px 15px">Yes </button>' +
          '</div>' +
          '</div>' +
          '</div>' +
        '</div>');
    
    confirmModal.find('#okButton').click(function(event) {
        $("#loader").css("display", "block");
     $.ajax({

        'url' : "<?= base_url('doctor/verifyStatus')?>",
        'type' : 'GET',
        'data' : {
            table       : table,
            idfield     : idfield,
            id        : id,
            statusfield   : statusfield,
            status      : status,
        },
        'success' : function(res) {
    if(res == "ok"){ 
       
      
//$("#id").css("display", "block");
 location.reload(); 
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