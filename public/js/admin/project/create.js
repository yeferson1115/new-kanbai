$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form #no_project').val() === '') {
            $('#main-form #no_project_alert').text('Campo requerido').show();
            $('#main-form #no_project').focus();
            return false;
        }

        if ($('#main-form #customer').val() === '') {
            $('#main-form #customer_alert').text('Campo requerido').show();
            $('#main-form #customer').focus();
            return false;
        }

        if ($('#main-form #date_shopping').val() === '') {
            $('#main-form #date_shopping_alert').text('Campo requerido').show();
            $('#main-form #date_shopping').focus();
            return false;
        }
        if ($('#main-form #bussine_id').val() === '') {
            $('#main-form #bussine_id_alert').text('Campo requerido').show();
            $('#main-form #bussine_id').focus();
            return false;
        }
        if ($('#main-form #email_customer').val() === '') {
            $('#main-form #email_customer_alert').text('Campo requerido').show();
            $('#main-form #email_customer').focus();
            return false;
        }
        if ($('#main-form #seller_id').val() === '') {
            $('#main-form #seller_id_alert').text('Campo requerido').show();
            $('#main-form #seller_id').focus();
            return false;
        }
        if ($('#main-form #asesor').val() === '') {
            $('#main-form #asesor_alert').text('Campo requerido').show();
            $('#main-form #asesor').focus();
            return false;
        }
        if ($('#main-form #phone_asesor').val() === '') {
            $('#main-form #phone_asesor_alert').text('Campo requerido').show();
            $('#main-form #phone_asesor').focus();
            return false;
        }
        if ($('#main-form #email_asesor').val() === '') {
            $('#main-form #email_asesor_alert').text('Campo requerido').show();
            $('#main-form #email_asesor').focus();
            return false;
        }
        if ($('#main-form #information_shopping').val() === '') {
            $('#main-form #information_shopping_alert').text('Campo requerido').show();
            $('#main-form #information_shopping').focus();
            return false;
        }

      var validate=false;
      if(document.getElementById("producto") !== null){
        $("input[name='producto[]']").each(function() {
            var temp=$(this).val();
            console.log(temp);
            if(temp=="" || temp==null){             
              validate=true;
              return false;
            }
        });
        $("input[name='price[]']").each(function() {
            var temp1=$(this).val();
            console.log(temp1);
            if(temp1=="" || temp1==null){             
              validate=true;
              return false;
            }
        });
        $("input[name='quantity[]']").each(function() {
            var temp2=$(this).val();
            console.log(temp2);
            if(temp2=="" || temp2==null){             
              validate=true;
              return false;
            }
        });
        $("input[name='imagen[]']").each(function() {
          var temp2=$(this).val();
          console.log(temp2);
          if(temp2=="" || temp2==null){             
            validate=true;
            return false;
          }
      });
        
      }else{
        _alertGeneric('info','Información','Debes agregar almenos un productos',null);       
        return false;
      }

     
      if(validate==true){
        _alertGeneric('info','Información','Debes agregar almenos un productos',null);       
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
                var json = response;
                if(json.success){
                  $('#main-form #submit').hide();
                  $('#main-form #edit-button').attr('href', $('#main-form #_url').val() + '/' + json.user_id + '/edit');
                  $('#main-form #edit-button').removeClass('hide');
                  //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Muy bien! ','Proyecto creado correctamente','/projects');
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
