$(document).ready(function(){
  
  $("#next").click(function() {

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

  if ($('#main-form #name_business').val() === '') {
      $('#main-form #name_business_alert').text('Ingrese el nombre de tu empresa').show();
      $('#main-form #name_business').focus();
      return false;
  }

  
  $('#profile-tab').click();


});

$("#next-datos").click(function() {  

  if ($('#main-form #email-user').val() === '') {
      $('#main-form #email-user_alert').text('Ingrese tu correo electrónico').show();
      $('#main-form #email-user').focus();
      return false;
  }
  if (!$('#main-form #email-user').val().match(/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/)) {
      $('#main-form #email-user_alert').text('Ingrese correo electrónico válido').show();
      $('#main-form #email-user').focus();
      return false;
  }

  if ($('#main-form #password').val() ==='') {
      $('#main-form #password_alert').text('Ingrese una contraseña').show();
      $('#main-form #password').focus();
      return false;
  }

  if (! $('#main-form #password').val().match(/^[a-zA-Z0-9\.!@#\$%\^&\*\?_~\/]{6,30}$/)) {
      $('#main-form #password_alert').text('Ingrese contraseña de al menos 06 caracteres').show();
      $('#main-form #password').focus();
      return false;
  }

  if ($('#main-form #password-confirm').val() === '') {
      $('#main-form #password-confirm_alert').text('Ingrese contraseña nuevamente').show();
      $('#main-form #password-confirm').focus();
      return false;
  }
  
  if ($('#main-form #password-confirm').val() !== $('#main-form #password').val()) {
  
      $('#main-form #password-confirm_alert').text('Contraseñas no coinciden').show();
      $('#main-form #password-confirm').focus();
      return false;
  }
  if ($('#main-form #name-user').val() === '') {
      $('#main-form #name-user_alert').text('Ingrese un nombre').show();
      $('#main-form #name-user').focus();
      return false;
  }
  if ($('#main-form #name_business').val() === '') {
      $('#main-form #name_business_alert').text('Ingrese nombre de la empresa').show();
      $('#main-form #name_business').focus();
      return false;
  }
  if ($('#main-form #phone').val() === '') {
      $('#main-form #phone_alert').text('Ingrese nombre número de celular').show();
      $('#main-form #phone').focus();
      return false;
  }

  const formvalidate = new FormData();
  formvalidate.append("email", $('#main-form #email-user').val());

  $.ajax({
    url: $('#main-form #_url_validate').val(),
    headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    type: 'POST',
    data: formvalidate,
    cache: false,
    contentType: false,
    processData: false,
    success: function (response) {
      var json = $.parseJSON(response);
      if(json.success){
        $('#home').addClass('active');
        $('#register').removeClass('active');
        $('#email').val($('#main-form #email-user').val());
        $('#cellphone').val($('#main-form #phone').val());
        $('#name').val($('#main-form #name-user').val());
        $('#name_business').val($('#main-form #name_business').val());
        
        $('#home-tab').click();
        //notifications.success('Servicio ingresado exitosamente');
        //_alertGeneric('success','Listo! Hemos recibido tu solicitud ','Número de solicitud #'+json.id,'/');
      }
    },error: function (data) {
      var errors = data.responseJSON;
      console.log(errors);
      $.each( errors.errors, function( key, value ) {
        _alertGeneric('error','Error',value,null);
        return false;
      });
     
    }
 });
  
  
  


});


  $('#main-form').submit(function(){

        $('.missing_alert').css('display', 'none');

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
  
      if ($('#main-form #name_business').val() === '') {
          $('#main-form #name_business_alert').text('Ingrese el nombre de tu empresa').show();
          $('#main-form #name_business').focus();
          return false;
      }

      if ($('#main-form #quantity').val() === '') {
          $('#main-form #quantity_alert').text('Ingrese cantidad').show();
          $('#main-form #quantity').focus();
          return false;
      }

      if ($('#main-form #date_delivery').val() === '') {
          $('#main-form #date_delivery_alert').text('Seleccione una fecha de entrega').show();
          $('#main-form #date_delivery').focus();
          return false;
      }      

      if ($('#main-form #budget_unit').val() === '') {
          $('#main-form #budget_unit_alert').text('Ingrese un presupuesto por unidad').show();
          $('#main-form #budget_unit').focus();
          return false;
      }

      if ($('#main-form #delivery_method').val() === '') {
          $('#main-form #delivery_method_alert').text('Ingrese una forma de entrega').show();
          $('#main-form #delivery_method').focus();
          return false;
      }

      var state=$('input:radio[name=category_id]:checked').val();
        if(state===undefined){
          $('#main-form #category_id_alert').text('Seleccione una categoria').show();
          return false;
        }
        

  

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
                  //notifications.success('Servicio ingresado exitosamente');
                  _alertGeneric('success','Muy bien! ','Solicitud personaliza creada correctamente','/');
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
