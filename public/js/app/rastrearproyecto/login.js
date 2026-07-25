
$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        

        var data = $('#main-form').serialize();
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fas fa-sign-in-alt').addClass('fas fa-spinner fa-pulse');


            $.ajax({
              url: $('#main-form #_url').val(),
              headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  _alertGeneric('success','Listo! Hemos encontrado tu proyecto','Número de solicitud #'+json.id,'/mis-proyectos/'+json.id);
                }else{
                  _alertGeneric('info','Información! No hemos encontrado tu proyecto','',1);
                }
              },error: function (data) {
                var errors = data.responseJSON;
                $.each( errors.errors, function( key, value ) {
                  //_alertLogin('info','Informacón',value,'/register');

                
                });
                //$('input').iCheck('enable');
                $('#main-form input, #main-form button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fas fa-spinner fa-pulse').addClass('fas fa-sign-in-alt');
            }
           });
       

       return false;

    });
});