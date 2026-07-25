$(document).ready(function(){

  $('#main-form-chat').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form-chat #message').val() === '') {
            $('#main-form-chat #message_alert').text('Ingrese un mensaje').show();
            $('#main-form-chat #message').focus();
            return false;
        }
        
        
        

  

        //var data = $('#main-form-chat').serialize();
        var formData = new FormData($("#main-form-chat")[0]);
        //$('input').iCheck('disable');
        $('#main-form-chat input, #main-form-chat button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
        
            $.ajax({
              url: $('#main-form-chat #_url').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form-chat #_token').val()},
    		      type: 'POST',
              data: formData,
              cache: false,
              contentType: false,
              processData: false,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#main-form-chat #submit').hide();
                  $('#main-form-chat #edit-button').attr('href', $('#main-form-chat #_url').val() + '/' + json.user_id + '/edit');
                  $('#main-form-chat #edit-button').removeClass('hide');
                  //notifications.success('Servicio ingresado exitosamente');
                  var imagen="";
                  if(json.data.file!=null){
                    imagen='<img style="max-width: 50%; border-radius: 30px;float: right;clear: right; border-radius: 30px;" class="mb-1" src="'+json.imagen+'">';
                  }
                  $("#chat-content").append('<div class="media media-chat media-chat-reverse"><div class="media-body"><p>'+json.data.message+'</p>'+imagen+'</div></div>');
                  $('.publisher-input').val('');
                  $('#imagechat').val('');
                  $("#chat-content").animate({ scrollTop: $('#chat-content')[0].scrollHeight}, 1000);
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  notifications.error(value);
                  return false;
                });
                $('input').iCheck('enable');
                $('#main-form-chat input, #main-form-chat button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
        

       return false;

    });
});
