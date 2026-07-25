$(function () {
  // abre modal y carga partial
  $(document).on('click', '.btn-manage', function (e) {
    e.preventDefault();
    var url = $(this).data('url');
    $('#manageModalBody').html('Cargando...');
    $('#manageModal').modal('show');

    $.get(url, function (html) {
      $('#manageModalBody').html(html);
    }).fail(function () {
      $('#manageModalBody').html('<div class="p-3">Error al cargar el formulario.</div>');
    });
  });

  // delegación: eliminar producto existente dentro del partial
  $(document).on('click', '.remove-existing-product', function () {
    var prodId = $(this).data('prod-id');
    var rowId = $(this).data('row');
    // agrega input hidden con removed id
    $('#removed-products-container').append('<input type="hidden" name="removed_products[]" value="'+prodId+'">');
    $('#'+rowId).remove();
  });

  // delegación: submit del formulario cargado en el modal
  $(document).on('submit', '#manage-form', function (e) {
    e.preventDefault();
    var $form = $(this);
    var action = $form.data('action'); // route('updateproyect')
    var fd = new FormData(this);

    // botón guardado: bloqueo visual
    $('#manageSaveBtn').prop('disabled', true).text('Guardando...');

    $.ajax({
      url: action,
      type: 'POST',
      data: fd,
      contentType: false,
      processData: false,
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      success: function (res) {
        $('#manageSaveBtn').prop('disabled', false).text('Guardar');
        if (res.success) {
          // cerrar modal y mostrar mensaje
          $('#manageModal').modal('hide');
          Swal.fire('Listo', res.message ?? 'Guardado correctamente', 'success').then(function () {
            location.reload(); // o actualizar sólo la fila si prefieres
          });
        } else {
          Swal.fire('Error', res.message ?? 'Ocurrió un error', 'error');
        }
      },
      error: function (xhr) {
        $('#manageSaveBtn').prop('disabled', false).text('Guardar');
        if (xhr.responseJSON && xhr.responseJSON.errors) {
          // mostrar errores (simple)
          var errs = xhr.responseJSON.errors;
          var msg = Object.values(errs).map(function(v){ return v.join(' ') }).join('<br>');
          Swal.fire({ icon: 'error', title: 'Errores de validación', html: msg });
        } else {
          Swal.fire('Error', 'Ocurrió un error al guardar', 'error');
        }
      }
    });
  });

});
