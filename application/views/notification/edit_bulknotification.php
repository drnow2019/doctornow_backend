<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
 
  <div class="modal-dialog" style="width: 500px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
            <h4 style="font-weight: 600">Edit Notification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
            <form method="POST" action="<?= base_url('notification/update')?>" id="myForm">
     <table>
       
         <tr>
            <th>Title</th>
            <input type="hidden" value="<?= $result[0]->id ?>" name="id">
            <td><input type="text" name="title" value="<?= $result[0]->title ?>" class="form-control" data-validation= "required"></td>
         </tr>
         <br>
          <tr>
            <th>Message</th>
            <td><input type="text" name="message" value="<?= $result[0]->message ?>" class="form-control" data-validation= "required"></td>
         </tr>
         <tr>
            <td><input type="submit" value="Update" class="btn btn-success"></td> 
         </tr>
        
     </table>
      </form>
       
     </div>
    </div>
   </div>
 </div>   

<script>
  $.validate({
    form : '#myForm',
    validateHiddenInputs : true,
    onSuccess : function($form) {
      
      $('#smt').hide();
      $('#buttonreplacement').show(); 
    }
   
  });
</script>