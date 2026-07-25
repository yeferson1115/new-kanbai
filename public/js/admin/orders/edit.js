$(document).ready(function(){



  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');
        if ($('#main-form #state').val() === '') {
            $('#main-form #state_alert').text('Seleccione un estado').show();
            $('#main-form #state').focus();
            return false;
        }



        var data = $('#main-form').serialize();
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-edit').addClass('fa fa-spin fa-refresh');

        Pace.track(function () {
            $.ajax({
              url: $('#main-form #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'PUT',
              cache: false,
    	        data: data,
               success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#main-form #submit').hide();
                  $('#main-form #edit-button').attr('href', $('#main-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#main-form #edit-button').removeClass('hide');
                  //toastr.success('Datos modificados exitosamente');
                  _alertGeneric('success','Muy bien! ','Orden actualizada Correctamente','/ordenes');
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  toastr.error(value);
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
