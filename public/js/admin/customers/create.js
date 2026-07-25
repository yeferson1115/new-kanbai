$(document).ready(function(){

    $('#departament_id').on('change', function(e){
        var department = e.target.value;
        $.get('cities/' + department,function(data) {
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

        if ($('#main-form #first_name').val() === '') {
            $('#main-form #first_name_alert').text('Ingrese nombre del vliente').show();
            $('#main-form #first_name').focus();
            return false;
        }

        if ($('#main-form #last_name').val() === '') {
            $('#main-form #last_name_alert').text('Ingrese el apellido del cliente').show();
            $('#main-form #last_name').focus();
            return false;
        }

        if ($('#main-form #type').val() === '') {
            $('#main-form #type_alert').text('Seleccione un tipo').show();
            $('#main-form #type').focus();
            return false;
        }

        if ($('#main-form #identification_type').val() === '') {
            $('#main-form #identification_type_alert').text('Seleccione un tipo de identificación').show();
            $('#main-form #identification_type').focus();
            return false;
        }

        if ($('#main-form #identification').val() === '') {
            $('#main-form #identification_alert').text('Ingrese identificación').show();
            $('#main-form #identification').focus();
            return false;
        }

        if ($('#main-form #regimen').val() === '') {
            $('#main-form #regimen_alert').text('Seleccione un regimen').show();
            $('#main-form #regimen').focus();
            return false;
        }

        if ($('#main-form #departament_id').val() === '') {
            $('#main-form #departament_id_alert').text('Seleccione un departamento').show();
            $('#main-form #departament_id').focus();
            return false;
        }

        if ($('#main-form #city_id').val() === '') {
            $('#main-form #city_id_alert').text('Seleccione una ciudad').show();
            $('#main-form #city_id').focus();
            return false;
        }

        if ($('#main-form #phone').val() === '') {
            $('#main-form #phone_alert').text('Ingrese un télefono').show();
            $('#main-form #phone').focus();
            return false;
        }

        if (! $('#main-form #email').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
            $('#main-form #email_alert').text('Ingrese correo electrónico válido').show();
            $('#main-form #email').focus();
            return false;
        }

        if ($('#main-form #address_line').val() === '') {
            $('#main-form #address_line_alert').text('Ingrese una dirección').show();
            $('#main-form #address_line').focus();
            return false;
        }


        var data = $('#main-form').serialize();
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
        Pace.track(function () {
            $.ajax({
              url: $('#main-form #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'POST',
              cache: false,
    	        data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#main-form #submit').hide();
                  $('#main-form #edit-button').attr('href', $('#main-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#main-form #edit-button').removeClass('hide');
                  //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Muy bien! ','Cliente creado Correctamente','/customers');
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  notifications.error(value);
                  return false;
                });
                $('input').iCheck('enable');
                $('#main-form input, #main-form button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
        });

       return false;

    });
});
