


$(document).ready(function(){

 let buttonClicked = null;

    // Cuando se haga clic en el botón "Solicitar cotización"
    $('#btn-cotizar-m').click(function () {
        buttonClicked = 'cotizar'; // Marcamos que el botón presionado es "cotizar"
    });

    // Cuando se haga clic en el botón "Pedir ahora"
    $('#btn-pedir-ahora-m').click(function () {
        buttonClicked = 'pedir'; // Marcamos que el botón presionado es "pedir"
    });


  $('#main-form-mobile').submit(function(e){
        e.preventDefault(); // Evitamos el comportamiento por defecto del formulario  
        $('.missing_alert').css('display', 'none');
        if (parseInt($('#main-form-mobile #quantity-m').val()) < parseInt($('#main-form-mobile #minima-m').val())) {
          _alertGeneric('info','Información','Debes ingresar la cantidad minima requerida',null);
          $('#quantity-m').val('');
          $('.text-price').text('$'+formatNumber(0));
          $('.price-unit').text('$'+formatNumber(0)+' valor por unidad');
          //$('#main-form #quantity').focus();
          return false;
      }

        if ($('#main-form-mobile #quantity-m').val() === '') {
          $('#main-form-mobile #quantity-m_alert').text('Ingrese una cantidad').show();
          $('#main-form-mobile #quantity-m').focus();
          return false;
      }

        var data = $('#main-form-mobile').serialize();
        //var formData = new FormData($("#main-form-mobile")[0]);
        console.log(data);
        //$('input').iCheck('disable');
        $('#main-form-mobile input, #main-form-mobile button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
        if (buttonClicked === 'cotizar') {
            $.ajax({
              url: $('#main-form-mobile #_url-m').val(),
    		      headers: {'X-CSRF-TOKEN': $('#main-form-mobile #_token-m').val()},
    		      type: 'POST',
              data: data,
              success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                  $('#main-form-mobile #submit').hide();
                  $('#main-form-mobile #edit-button').attr('href', $('#main-form-mobile #_url-m').val() + '/' + json.user_id + '/edit');
                  $('#main-form-mobile #edit-button').removeClass('hide');
                  //notifications.success('Servicio ingresado exitosamente');
                  Swal.fire({
                    icon: 'success',
                    text:json.message_cart ,
                    showCancelButton: true,
                    confirmButtonClass: 'btn btn-success btn-fill btn-c1 ',
                    cancelButtonClass: 'btn btn-danger btn-fill btn-c2',
                    confirmButtonText: 'Solicitar cotización',
                    cancelButtonText: 'Agregar más productos a cotización',
                    buttonsStyling: false
                    }).then(function(e) {
                      console.log(e.dismiss);
                      if(e.dismiss=='cancel'){
                        location.reload();
                      }else{
                        window.location.href = "/carrito";
                      }
                      //
              
                    }).catch(function(e) {
                      location.reload();
              
                    });
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  notifications.error(value);
                  return false;
                });
                $('input').iCheck('enable');
                $('#main-form-mobile input, #main-form-mobile button').removeAttr('disabled');
                $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
              }
           });
          }else if (buttonClicked === 'pedir') {
            // Si se presionó "Pedir ahora", hacemos otro procesamiento
            $.ajax({
                url: '/pedir-ahora', // Asegúrate de configurar esta ruta
                headers: { 'X-CSRF-TOKEN': $('#main-form-mobile #_token-m').val() },
                type: 'POST',
                data: data,
                success: function (response) {
                    var json = response;
                    if (json.success) {
                        Swal.fire({
                          icon: 'success',
                          text: 'Tu pedido ha sido realizado con éxito.',
                          showConfirmButton: false, // Elimina el botón de confirmación
                          timer: 2000, // Establece un tiempo antes de la redirección (por ejemplo, 2 segundos)
                      }).then(function () {
                          // Redirige al carrito después de mostrar la alerta
                          window.location.href = "/carrito"; // Redirige al checkout o página de pago
                      });
                    }
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                    $.each(errors.errors, function (key, value) {
                        notifications.error(value); // Muestra los errores
                        return false;
                    });
                    
                    $('#main-form input, #main-form button').removeAttr('disabled');
                    $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
                }
            });
        }
        

       return false;

    });
});
