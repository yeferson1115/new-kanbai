$(document).ready(function(){

  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        if ($('#main-form #name').val() === '') {
            $('#main-form #name_alert').text('Ingrese un nombre de producto').show();
            $('#main-form #name').focus();
            return false;
        }

        var validate=false;
      if(document.getElementById("quantity_min_escala") !== null){
        $("input[name='quantity_min_escala[]']").each(function() {
            var temp=$(this).val();
            console.log(temp);
            if(temp=="" || temp==null){             
              validate=true;
              return false;
            }
        });
        $("input[name='quantity_max[]']").each(function() {
            var temp1=$(this).val();
            console.log(temp1);
            if(temp1=="" || temp1==null){             
              validate=true;
              return false;
            }
        });
        $("input[name='price_escala[]']").each(function() {
            var temp2=$(this).val();
            console.log(temp2);
            if(temp2=="" || temp2==null){             
              validate=true;
              return false;
            }
        });
        
      }else{
        _alertGeneric('info','Información','Debes agregar almenos una escala de precios',null);       
        return false;
      }

     
      if(validate==true){
        _alertGeneric('info','Información','Debes agregar almenos una escala de precios',null);       
        return false;
      }
      
        if ($('#main-form #delivery_time').val() === '') {
            $('#main-form #delivery_time_alert').text('Ingrese un tiempo de entrega').show();
            $('#main-form #delivery_time').focus();
            return false;
        }

        if ($('#main-form #size').val() === '') {
            $('#main-form #size_alert').text('Seleccione un tamaño').show();
            $('#main-form #size').focus();
            return false;
        }
        if ($('#main-form #shipping_price').val() === '') {
            $('#main-form #shipping_price_alert').text('Ingrese un valor de envio').show();
            $('#main-form #shipping_price').focus();
            return false;
        }
        var description=CKEDITOR.instances.description.getData();
        if (description === '') {
          $('#main-form #description_alert').text('Ingrese una descripción').show();
          $('#main-form #description').focus();
          return false;
      }
      
      console.log(description);
        if ($('#main-form #user_id').val() === '') {
          $('#main-form #user_id_alert').text('Seleccione el comercio que vende el producto').show();
          $('#main-form #user_id').focus();
          return false;
      }


        //var data = $('#main-form').serialize();
        var formData = new FormData($("#main-form")[0]);

        formData.append('description_render', description);
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
                  _alertGeneric('success','Muy bien! ','Producto creado correctamente','/products');
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
