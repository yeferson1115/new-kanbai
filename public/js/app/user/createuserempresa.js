$(document).ready(function(){

  $('#departament_id').on('change', function(e){
    var department = e.target.value;
    $.get('customers/cities/' + department,function(data) {
    $('#city_id').empty();
    $.each(data, function(fetch, city){
        $('#city_id').append('<option value="">Seleccione</option>');
        for(i = 0; i < city.length; i++){
        $('#city_id').append('<option value="'+ city[i].id +'">'+ city[i].name +'</option>');
        }
    })
 })
});

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        

        if ($('#main-form #name').val() === '') {
            $('#main-form #name_alert').text('Ingrese nombre completo').show();
            $('#main-form #name').focus();
            return false;
        }

        if (!$('input[name="genero"]:checked').val()) {
            $('#main-form #gender_alert').text('Seleccione un género').show();
            $('input[name="genero"]').first().focus();  // Enfocar el primer radio button si no se seleccionó ninguno
            return false;
        }

        if (! $('#main-form #email').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
            $('#main-form #email_alert').text('Ingrese correo electrónico válido').show();
            $('#main-form #email').focus();
            return false;
        }
        if ($('#main-form #phone').val() === '') {
            $('#main-form #phone_alert').text('Ingrese número de celular').show();
            $('#main-form #phone').focus();
            return false;
        }
        if ($('#main-form #charge').val() === '') {
            $('#main-form #charge_alert').text('Ingrese un cargo').show();
            $('#main-form #charge').focus();
            return false;
        }

        if (! $('#main-form #password').val().match(/^[a-zA-Z0-9\.!@#\$%\^&\*\?_~\/]{6,30}$/)) {
            $('#main-form #password_alert').text('Ingrese contraseña de al menos 06 caracteres').show();
            $('#main-form #password').focus();
            return false;
        }
        

        if ($('#main-form #password_confirmation').val() === '') {
            $('#main-form #password_confirmation_alert').text('Ingrese contraseña nuevamente').show();
            $('#main-form #password_confirmation').focus();
            return false;
        }



        if ($('#main-form #password_confirmation').val() !== $('#main-form #password').val()) {
            $('#main-form #password_confirmation_alert').text('Contraseñas no coinciden').show();
            $('#main-form #password_confirmation').focus();
            return false;
        }


        var data = $('#main-form').serialize();
        //$('input').iCheck('disable');
       
       
            $.ajax({
              url: $('#main-form #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'POST',
              cache: false,
    	        data: data,
              success: function (response) {
                var json = response;
                if(json.success){                  
                  //notifications.success('Usuario ingresado exitosamente');
                 
                  _alertGeneric('success','Muy bien! ','Usuario creado correctamente','usuarios-empresa');
                  //window.history.back();
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  _alertGeneric('error','Error',value,null);
                  return false;
                });
               
              }
           });
       

       return false;

    });
});
