$(document).ready(function () {

    // Variable para saber qué botón fue presionado
    let buttonClicked = null;

    // Cuando se haga clic en el botón "Solicitar cotización"
    $('#btn-cotizar').click(function () {
        buttonClicked = 'cotizar'; // Marcamos que el botón presionado es "cotizar"
    });

    // Cuando se haga clic en el botón "Pedir ahora"
    $('#btn-pedir-ahora').click(function () {
        buttonClicked = 'pedir'; // Marcamos que el botón presionado es "pedir"
    });

    // Controlamos el envío del formulario
    $('#main-form').submit(function (e) {
        e.preventDefault(); // Evitamos el comportamiento por defecto del formulario

        // Escondemos alertas de error previas
        $('.missing_alert').css('display', 'none');

        // Verificamos la cantidad mínima
        if (parseInt($('#main-form #quantity').val()) < parseInt($('#main-form #minima').val())) {
            _alertGeneric('info', 'Información', 'Debes ingresar la cantidad mínima requerida', null);
            $('#quantity').val('');
            $('.text-price').text('$' + formatNumber(0));
            $('.price-unit').text('$' + formatNumber(0) + ' valor por unidad');
            return false;
        }

        // Verificamos si la cantidad no está vacía
        if ($('#main-form #quantity').val() === '') {
            $('#main-form #quantity_alert').text('Ingrese una cantidad').show();
            $('#main-form #quantity').focus();
            return false;
        }

        var data = $('#main-form').serialize(); // Serializamos los datos del formulario
        $('#main-form input, #main-form button').attr('disabled', 'true'); // Desactivamos el formulario para evitar múltiples envíos
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh'); // Cambiamos el ícono a "loading"

        if (buttonClicked === 'cotizar') {
            // Si se presionó "Solicitar cotización", hacemos el siguiente procesamiento
            $.ajax({
                url: $('#main-form #_url').val(),
                headers: { 'X-CSRF-TOKEN': $('#main-form #_token').val() },
                type: 'POST',
                data: data,
                success: function (response) {
                    var json = $.parseJSON(response);
                    if (json.success) {
                        $('#main-form #submit').hide();
                        $('#main-form #edit-button').attr('href', $('#main-form #_url').val() + '/' + json.user_id + '/edit');
                        $('#main-form #edit-button').removeClass('hide');

                        // Notificación de éxito
                        Swal.fire({
                            icon: 'success',
                            text: json.message_cart,
                            showCancelButton: true,
                            confirmButtonClass: 'btn btn-success btn-fill btn-c1 ',
                            cancelButtonClass: 'btn btn-danger btn-fill btn-c2',
                            confirmButtonText: 'Solicitar cotización',
                            cancelButtonText: 'Agregar más productos a cotización',
                            buttonsStyling: false
                        }).then(function (e) {
                            if (e.dismiss == 'cancel') {
                                location.reload(); // Recarga la página si el usuario hace clic en "Agregar más productos"
                            } else {
                                window.location.href = "/carrito"; // Redirige al carrito
                            }
                        }).catch(function (e) {
                            location.reload(); // Si ocurre un error, recarga la página
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
                    $('input').iCheck('enable');
                    $('#main-form input, #main-form button').removeAttr('disabled');
                    $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
                }
            });
        } else if (buttonClicked === 'pedir') {
            // Si se presionó "Pedir ahora", hacemos otro procesamiento
            $.ajax({
                url: '/pedir-ahora', // Asegúrate de configurar esta ruta
                headers: { 'X-CSRF-TOKEN': $('#main-form #_token').val() },
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
                    $('input').iCheck('enable');
                    $('#main-form input, #main-form button').removeAttr('disabled');
                    $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
                }
            });
        }

        return false; // Evitar el envío por defecto
    });
});
