$(document).ready(function(){

    let quotationType = null; // Para saber si es WhatsApp o Email

    // Detectar qué botón abrió el modal
    $(".open-modal-quotation").on("click", function(){
        quotationType = $(this).data("type"); // whatsapp o email
        console.log("Cotización por:", quotationType);
    });

    // Envío del formulario
    $('#main-form').submit(function(){

        $('.missing_alert').hide();

        // Validaciones
        if ($('#name').val() === '') {
            $('#name_alert').text('Campo Obligatorio').show();
            $('#name').focus();
            return false;
        }
        if ($('#company').val() === '') {
            $('#company_alert').text('Campo Obligatorio').show();
            $('#company').focus();
            return false;
        }
        if ($('#email').val() === '') {
            $('#email_alert').text('Campo Obligatorio').show();
            $('#email').focus();
            return false;
        }
        if (! $('#email').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
            $('#email_alert').text('Ingrese correo electrónico válido').show();
            $('#email').focus();
            return false;
        }
        if ($('#phone').val() === '') {
            $('#phone_alert').text('Campo Obligatorio').show();
            $('#phone').focus();
            return false;
        }

        // Serializar datos
        var formData = new FormData($("#main-form")[0]);
        formData.append("type", quotationType); // enviamos si es whatsapp o email

        $('#main-form input, #main-form button').attr('disabled','true');

        $.ajax({
            url: $('#_url').val(), // tu ruta /carrito
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                var json = response;
                if(json.success){
                    if(quotationType === 'whatsapp'){
                        // Abrir WhatsApp con la info
                        window.open(json.whatsapp_url, "_blank");
                        location.href="/agradecimiento";
                        //Swal.fire('Listo!', 'Hemos generado tu cotización en WhatsApp', 'success').then(()=> location.href="/");
                    }else{
                        location.href="/agradecimiento";
                        //Swal.fire('Listo!', 'Hemos recibido tu solicitud por correo', 'success').then(()=> location.href="/");
                    }
                }
            },
            
            error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                    notifications.error(value);
                    return false;
                });
                $('#main-form input, #main-form button').removeAttr('disabled');
            }
        });

        return false;
    });
});
