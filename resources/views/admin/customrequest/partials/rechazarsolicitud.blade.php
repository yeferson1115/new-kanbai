<form method="POST" action="">
  <input type="hidden" name="quotation_id" value="{{$quotation->id}}">
  <input type="hidden" name="state" value="2">
    <div class="row">

      <div class="col-md-12 col-12">
        
      <div class="col-md-12 col-12">
        <div class="mb-1">
          <label class="form-label" for="deny">Escribe a continuación motivo por el cual la oferta será rechazada:</label>
          <textarea class="form-control" id="deny" name="deny"  ></textarea>
          <span class="missing_alert text-danger" id="deny_alert"></span>
        </div>
      </div>  

    </div>    
    <div class="col-12 mt-3">
      <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$quotation->encode_id]) }}" class="btn btn-primary waves-effect waves-float waves-light add-ingredient-size" value="Delete user"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
    </div>        
</form>



@push('scripts')
<script>


$('.add-ingredient-size').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');
var data=$(e.target).closest('form').serialize();
if ($('#deny').val() === '') {
    $('#deny_alert').text('Ingrese el motivo del rechazo').show();
    $('#deny').focus();
    return false;
}

Swal.fire({
title: 'Seguro que desea rechazar la solicitud',
text: "",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Aceptar',
cancelButtonText: 'Cancelar',
}).then((result) => {
if (result.isConfirmed) {
    $.ajax({
      url: href,
      headers: {'X-CSRF-TOKEN': token},
      type: 'PUT',
      cache: false,
      data: data,
      success: function (response) {
        var json = $.parseJSON(response);
        console.log(json);
        Swal.fire(
            'Muy bien!',
            'Solicitud rechazada correctamente',
            'success'
            ).then((result) => {
                location.reload();
            });

      },error: function (data) {
        var errors = data.responseJSON;
        console.log(errors);

      }
   });

}
})

});



</script>
@endpush