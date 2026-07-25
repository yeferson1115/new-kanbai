
$(document).ready(function(){

  $('#main-form-login').submit(function(){

        $('.missing_alert').css('display', 'none');

        

        var data = $('#main-form-login').serialize();
        //$('input').iCheck('disable');
        $('#main-form-login input, #main-form-login button').attr('disabled','true');
        $('#ajax-icon').removeClass('fas fa-sign-in-alt').addClass('fas fa-spinner fa-pulse');

        Pace.track(function () {
            $.ajax({
              url: $('#main-form-login #_url_login').val(),
              headers: {'X-CSRF-TOKEN': $('#main-form-login #_token_login').val()},
              type: 'POST',
              cache: false,
              data: data,
              success: function (response) {
                 if(response === 'authenticated.true'){
                   $('#ajax-icon').removeClass('fas fa-sign-in-alt').addClass('fas fa-spinner fa-pulse');
                   location.reload();
                  }
              },error: function (data) {
                var errors = data.responseJSON;
                $.each( errors.errors, function( key, value ) {
                  _alertGeneric('info','Información',value,null);                
                });
                //$('input').iCheck('enable');
                $('#main-form-login input, #main-form-login button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fas fa-spinner fa-pulse').addClass('fas fa-sign-in-alt');
            }
           });
        });

       return false;

    });
});