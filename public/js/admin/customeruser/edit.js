$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form #name').val() === '') {
          $('#main-form #name_alert').text('Ingrese un nombre').show();
          $('#main-form #name').focus();
          return false;
      }

      if ($('#main-form #lastname').val() === '') {
          $('#main-form #lastname_alert').text('Ingrese un apellido').show();
          $('#main-form #lastname').focus();
          return false;
      }
      if ($('#main-form input[name="genero"]:checked').length === 0) {
          $('#main-form #role_alert').text('Seleccione un genero').show();
          return false;
      }
      if ($('#main-form #whatsapp').val() === '') {
          $('#main-form #whatsapp_alert').text('Ingrese No. de whatsapp').show();
          $('#main-form #whatsapp').focus();
          return false;
      }

      if ($('#main-form #cellphone').val() === '') {
          $('#main-form #cellphone_alert').text('Ingrese No. de celular').show();
          $('#main-form #cellphone').focus();
          return false;
      }

      if ($('#main-form #email').val() === '') {
          $('#main-form #email_alert').text('Ingrese un email').show();
          $('#main-form #email').focus();
          return false;
      }
      if (! $('#main-form #email').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
          $('#main-form #email_alert').text('Ingrese correo electrónico válido').show();
          $('#main-form #email').focus();
          return false;
      }

      if ($('#main-form #username').val() === '') {
          $('#main-form #username_alert').text('Ingrese un nombre de usuario').show();
          $('#main-form #username').focus();
          return false;
      }
     

      

      //var data = $('#main-form').serialize();
      var formData = new FormData($("#main-form")[0]); 
        //$('input').iCheck('disable');
        //$('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-edit').addClass('fa fa-spin fa-refresh');

        Pace.track(function () {
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
                  //toastr.success('Datos modificados exitosamente');
                  _alertGeneric('success','Muy bien! ','Asesor actualizado correctamente','/asignar-asesor');
                }
              },error: function (data) {
                let errors = data.responseJSON.errors;
              
                // Limpiar errores anteriores
                $('#main-form .text-danger').remove();
                $('#main-form .is-invalid').removeClass('is-invalid');
              
                // Recorrer errores y mostrarlos
                $.each(errors, function (key, messages) {
                  _alertGeneric('error','Error',messages[0],null);
                  return;
                });                
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
        });

       return false;

    });
});
