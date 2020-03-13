 <!-- Jquery JS-->
    <script src="<?= base_url('assets/vendor/jquery-3.2.1.min.js')?>"></script>
    <!-- Bootstrap JS-->
    <script src="<?= base_url('assets/vendor/bootstrap-4.1/popper.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap-4.1/bootstrap.min.js')?>"></script>
    <!-- Vendor JS       -->
    <script src="<?= base_url('assets/vendor/slick/slick.min.js')?>">
    </script>
    <script src="<?= base_url('assets/vendor/wow/wow.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/bootstrap-progressbar/bootstrap-progressbar.min.js')?>">
    </script>
    <script src="<?= base_url('assets/vendor/counter-up/jquery.waypoints.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/counter-up/jquery.counterup.min.js')?>">
    </script>
    <script src="<?= base_url('assets/vendor/circle-progress/circle-progress.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
    <script src="<?= base_url('assets/vendor/chartjs/Chart.bundle.min.js')?>"></script>
    <script src="<?= base_url('assets/vendor/select2/select2.min.js')?>">
    </script>
        <script src="<?= base_url('assets/vendor/animsition/animsition.min.js')?>"></script>

  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <!-- Main JS-->
    <script src="<?= base_url('assets/js/main.js')?>"></script>
    <script src="<?= base_url('assets/js/monami.js')?>"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script>
  $( function() {
    $( ".datepicker" ).datepicker({ 
        dateFormat: 'dd-mm-yy',
        changeYear: true,
        changeMonth: true,
        yearRange: '1950:2020'
        });

  } );
    
  $(".alert").fadeIn('slow').animate({opacity: 2.0}, 1500).fadeOut('slow'); 

  </script>

  <script>
      function numbersonly(e){
    var unicode=e.charCode? e.charCode : e.keyCode
    if (unicode!=8){ //if the key isn't the backspace key (which we should allow)
        if (unicode != 46 && unicode > 31 &&unicode<48||unicode>57) //if not a number
            return false //disable key press
    }
}

$('#reset').click(function(){
            $('#myForm')[0].reset();
 });
 
 
  function onlyletter(e){
        var inputValue = event.charCode;
        if(!(inputValue >= 65 && inputValue <= 120) && (inputValue != 32 && inputValue != 0)){
            event.preventDefault();
        }
   // });
}
  </script>

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
      'url'   : "<?=base_url('common/del_single')?>",
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
  function rowstatus(table,idfield,id,statusfield,status) {
  
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

        'url' : "<?php echo base_url('common/change_status'); ?>",
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
  