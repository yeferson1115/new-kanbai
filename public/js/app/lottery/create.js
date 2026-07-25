$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form #name').val() === '') {
            $('#main-form #name_alert').text('Campo Obligatorio').show();
            $('#main-form #name').focus();
            return false;
        }
        if ($('#main-form #email').val() === '') {
            $('#main-form #email_alert').text('Campo Obligatorio').show();
            $('#main-form #email').focus();
            return false;
        }
        if (! $('#main-form #email').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
            $('#main-form #email_alert').text('Ingrese correo electrónico válido').show();
            $('#main-form #email').focus();
            return false;
        }

        if ($('#main-form #document').val() === '') {
            $('#main-form #document_alert').text('Campo Obligatorio').show();
            $('#main-form #document').focus();
            return false;
        }

        if ($('#main-form #phone').val() === '') {
            $('#main-form #phone_alert').text('Campo Obligatorio').show();
            $('#main-form #phone').focus();
            return false;
        }
        if ($('#main-form #organization').val() === '') {
            $('#main-form #organization_alert').text('Campo Obligatorio').show();
            $('#main-form #organization').focus();
            return false;
        }
        if ($('#main-form #file').val() === '') {
            $('#main-form #file_alert').text('Campo Obligatorio').show();
            $('#main-form #file').focus();
            return false;
        }
        

  

        //var data = $('#main-form').serialize();
        var formData = new FormData($("#main-form")[0]);
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
        $('#preloadersite').show();
            $.ajax({
              url: $('#main-form #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#main-form #submit').hide();
                  $('#main-form #edit-button').attr('href', $('#main-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#main-form #edit-button').removeClass('hide');
                  //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Muy bien! ','Incripción realizada con éxito','/');
                }
              },error: function (data) {
                $('#preloadersite').hide();
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  _alertGeneric('error','Error! ',value,null);
                  return false;
                });
                
                $('#main-form input, #main-form button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
        

       return false;

    });
});
