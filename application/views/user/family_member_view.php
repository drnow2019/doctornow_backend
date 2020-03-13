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
                    <h2 class="title-1">User Family Member</h2>

                    <a  href="<?= base_url('user/addmember/'.$user_id)?>" class="au-btn au-btn-icon au-btn--blue" >
                      <i class="zmdi zmdi-plus"></i>Add New Member</a>
                  </div>

                                    <div class="col-md-6 col-xs-12">
                               <div class="searchbox">
                
                   <input type="text"  class="form-control enterSearch" id="keywords" placeholder="Search"   value="<?php echo $this->input->get('keywords');?>"/>
                  <button id="btnSearch"  class="btn btn search" onclick="searchFilter()"><i class="icon-search"></i> Search</button><a href="<?php echo base_url('user');?>" class="btn "><i class="fa fa-refresh" aria-hidden="true"></i></a>
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
                            <th>Full Name</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Relationship</th>
                            <th>Medical History</th>
                            <th>Edit Info</th>
                          </tr>
                        </thead>

                                        <tbody> 
                                        <tr>
                                          <?php  
                                             $sn=1;
                                             if(!empty($member)):
                                          foreach($member as $values):?>
                                          <td><?=  $sn++;?></td>
                                          <td><?= $values->name?></td>
                                          <td><?= date('d-m-Y',strtotime($values->dob))?></td>
                                          <td><?= $values->gender ?></td>
                                          <td><?= $values->relationship ?></td>
                                          <td><a href="<?= base_url('user/membermedicalHistory/'.$values->id) ?>">View Medical History</a></td>

                                          <td>
                              <div class="table-data-feature"> 
                              <a href="<?= base_url('user/editmember/'.$values->id) ?>" class="item">
                                <i class="zmdi zmdi-edit"></i>
                              </a>
                              <?php define('MEMBER','user_member')?>
                              <button class="item" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete" onclick="return deleterow('<?=strrev(MEMBER)?>','id','<?=$values->id?>')">
                                <i class="zmdi zmdi-delete"></i>
                              </button>
                              </div>
                            </td>
                                        </tr> 
                                        <?php endforeach; 
                                         else:

                                         ?>                      
 <tr>
  <td ><center><b style="color: red;">No Record Available</b></center></td>
                </tr>
            <?php endif; ?>
                                              
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
        url: '<?=base_url('user/ajaxPaginationData')?>/'+page_num,
        data:csrf_name+'='+hash+'&'+dataVar,
        beforeSend: function () {
          $('.loading').show();
        },
        success: function (html) {
           // alert(html);exit();
          $('#postList').html(html);
            window.history.pushState("object or string", "Title", "<?=base_url('user?')?>"+dataVar);
          $('.loading').fadeOut("slow");
         // location.reload();
        }
      });
    }

</script>


<script>
    function deleterow(table,fieldname,fieldvalue) {
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
            '<p>Are you sure want to delete this records11  ? </p>' +
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
      'url'   : "<?=base_url('user/deleteRecords')?>",
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