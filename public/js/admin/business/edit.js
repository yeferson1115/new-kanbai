$(document).ready(function(){
  function showError(field, message) {
    $(field).addClass("is-invalid").focus();
    $(field + "_alert").text(message).show();
}

$('#main-form').submit(function () {

    // Limpiar alertas y clases de error
    $('.missing_alert').hide();
    $('#main-form .form-control').removeClass('is-invalid');

    // Validaciones
    if ($('#main-form #company_name').val().trim() === '') {
        showError('#main-form #company_name', 'Campo Obligatorio');
        return false;
    }

    if ($('#main-form #nit').val().trim() === '') {
        showError('#main-form #nit', 'Campo Obligatorio');
        return false;
    }

    if ($('#main-form #billing_email').val().trim() === '') {
        showError('#main-form #billing_email', 'Campo Obligatorio');
        return false;
    }

    let email = $('#main-form #billing_email').val().trim();
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailRegex.test(email)) {
        showError('#main-form #billing_email', 'Ingrese correo electrónico válido');
        return false;
    }

    if ($('#main-form #address').val().trim() === '') {
        showError('#main-form #address', 'Campo Obligatorio');
        return false;
    }

    let department = $('#main-form #department_id').val();
    if (department === '' || department === '0') {
        showError('#main-form #department_id', 'Campo Obligatorio');
        return false;
    }

    let city = $('#main-form #city_id').val();
    if (city === '' || city === '0') {
        showError('#main-form #city_id', 'Campo Obligatorio');
        return false;
    }
    if ($('#main-form #user_id').val().trim() === '') {
      showError('#main-form #user_id', 'Campo Obligatorio');
      return false;
  }
      var data = $('#main-form').serialize();
      var formData = new FormData($("#main-form")[0]);
        //$('input').iCheck('disable');
        $('#main-form input, #main-form button').attr('disabled','true');
        $('#ajax-icon').removeClass('fa fa-edit').addClass('fa fa-spin fa-refresh');

        Pace.track(function () {
            $.ajax({
              url: '/update-empresa',
    		      headers: {'X-CSRF-TOKEN': $('#main-form #_token').val()},
    		      type: 'PUT',
              data: data,           
               success: function (response) {
                var json = response;
                if(json.success){                  
                  //toastr.success('Datos modificados exitosamente');
                  _alertGeneric('success','Muy bien! ','Empresa actualizada correctamente',1);
                }
              },error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
                $.each( errors.errors, function( key, value ) {
                  toastr.error(value);
                  return false;
                });
                
              }
           });
        });

       return false;

    });
});
