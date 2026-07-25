$(document).ready(function(){

  $(".next-d").click(function() {

    

    if ($('#main-form #email').val() === '') {
        $('#main-form #email_alert').text('Ingrese tu correo electrónico').show();
        $('#main-form #email').focus();
        return false;
    }
    if (!$('#main-form #email').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
        $('#main-form #email_alert').text('Ingrese correo electrónico válido').show();
        $('#main-form #email').focus();
        return false;
    }
    if ($('#main-form #type_document').val() === '') {
        $('#main-form #type_document_alert').text('Seleccione el tipo de documento').show();
        $('#main-form #type_document').focus();
        return false;
    }
    if ($('#main-form #document').val() === '') {
        $('#main-form #document_alert').text('Ingrese número de documento').show();
        $('#main-form #document').focus();
        return false;
    }
    if ($('#main-form #name_business').val() === '') {
        $('#main-form #name_business_alert').text('Ingrese nombre de tu empresa').show();
        $('#main-form #name_business').focus();
        return false;
    }
    if ($('#main-form #name').val() === '') {
        $('#main-form #name_alert').text('Ingrese tu nombre').show();
        $('#main-form #name').focus();
        return false;
    }


    if ($('#main-form #cellphone').val() === '') {
        $('#main-form #cellphone_alert').text('Ingrese número celular').show();
        $('#main-form #cellphone').focus();
        return false;
    }
    if ($('#main-form #address').val() === '') {
        $('#main-form #address_alert').text('Ingrese dirección de entrega').show();
        $('#main-form #address').focus();
        return false;
    }

    if ($('#main-form #city').val() === '') {
        $('#main-form #city_alert').text('Ingrese un municipio').show();
        $('#main-form #city').focus();
        return false;
    }

    if ($('#main-form #date_delivery').val() === '') {
        $('#main-form #date_delivery_alert').text('Seleccione una fecha de entrega').show();
        $('#main-form #date_delivery').focus();
        return false;
    }
    $('#profile-tab').click();


});

$(".comfirm").click(function() {

  if ($('input[name="payment_method"]').is(':checked')) {
    $('#fisnish-tab').click();
  }else{
    $('#main-form #payment_method_alert').text('Seleccione un metodo de pago').show();
    return false;
  }
  

});



  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

        /*if ($('#main-form #vaucher').val() === '') {
            $('#main-form #vaucher_alert').text('Ingrese el Comprobante de Pago').show();
            $('#main-form #vaucher').focus();
            return false;
        }*/
        var id=0;
        //var data = $('#main-form').serialize();
        var formData = new FormData($("#main-form")[0]);
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
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

                  id=json.user_id;
                  var wompi=json.wompi;
                  if(wompi!=0){

                     console.log(wompi.reference);

                  var checkout = new WidgetCheckout({
                      currency: 'COP',
                      amountInCents: wompi.total* 100,
                      reference: wompi.reference,
                      publicKey: 'pub_test_owkycEC79JnjV87EIMlLnojmQSPZO65O',
                      signature: {integrity : 'test_integrity_JanWHqxUxKMPErlim3bf2bM4zsOXcbc8'},
                      customerData: { // Opcional
                        email:wompi.email,
                        fullName: wompi.fullName,
                        phoneNumber: wompi.phoneNumber,
                        phoneNumberPrefix: '+57',
                        legalId: wompi.legalId,
                        legalIdType: 'CC'
                      }                      
                    });

                    checkout.open(function (result) {
                      var transaction = result.transaction;
                      console.log("Transaction ID: ", transaction.id);
                      console.log("Transaction object: ", transaction);

                      if(transaction.status=='APPROVED'){
                          $.ajax({
                              url: 'checkoutpayment',
                              headers: {'X-CSRF-TOKEN': token},
                              type: 'POST',
                              cache: false,
                              data: {'id':id,'status':transaction.status,
                                  'paymentMethodType':transaction.paymentMethodType,
                                  'reference':transaction.reference,
                                  'transactionid':transaction.id                                  
                              },
                              success: function (response) {
                                  var json = $.parseJSON(response);
                                  console.log(json);
                                  _alertGeneric('success','Listo! Hemos recibido tu solicitud ','Número de solicitud #'+json.id,'/');

                              },error: function (data) {
                                  var errors = data.responseJSON;
                                  console.log(errors);
                                  _alertGeneric('error','Error','Ocurrio un error intenta nuevamente',null);

                              }
                          });
                      }
                    });

                  }else{
                    //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Listo! Hemos recibido tu solicitud ','Número de solicitud #'+json.id,'/');
                  }
                 

                  
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
        

       return false;

    });
});
