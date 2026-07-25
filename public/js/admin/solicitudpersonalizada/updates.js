$(document).ready(function(){
   


  $('#main-form-updates').submit(function(){

        $('.missing_alert').css('display', 'none');

       

        if ($('#main-form-updates #update_text').val() === '') {
            $('#main-form-updates #update_text_alert').text('Campo Obligatorio').show();
            $('#main-form-updates #update_text').focus();
            return false;
        }
        



        var formData = new FormData($("#main-form-updates")[0]);
        //$('input').iCheck('disable');
        $('#main-form-updates input, #main-form-updates button').attr('disabled','true');

        Pace.track(function () {
            $.ajax({
              url: $('#main-form-updates #_url_update').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form-updates #_token_update').val()},
    		      type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
               success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                 
                  //toastr.success('Datos modificados exitosamente');
                  _alertGeneric('success','Muy bien! ','Update creado correctamente',1);
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  toastr.error(value);
                  return false;
                });
                $('input').iCheck('enable');
                $('#main-form-updates input, #main-form-updates button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
        });

       return false;

    });
});
