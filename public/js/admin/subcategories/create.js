$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form #category_id').val() === '') {
          $('#main-form #category_id_alert').text('Selecione una categoría padre').show();
          $('#main-form #category_id').focus();
          return false;
      }

        if ($('#main-form #name').val() === '') {
            $('#main-form #name_alert').text('Ingrese nombre de la sub categoría').show();
            $('#main-form #name').focus();
            return false;
        }
        var state=$('input:radio[name=state]:checked').val();
        if(state===undefined){
          $('#main-form #state_alert').text('Seleccione un estado').show();
          return false;
        }
        
        if ($('#main-form #file').val() === '') {
          $('#main-form #file_alert').text('Seleccione una imagen').show();
          $('#main-form #file').focus();
          return false;
      }

  

        //var data = $('#main-form').serialize();
        var formData = new FormData($("#main-form")[0]);
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
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
                  //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Muy bien! ','Sub Categoría creada correctamente','/subcategories');
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
