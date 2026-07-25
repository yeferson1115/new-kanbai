<form class="form" role="form" id="main-form-aprove" autocomplete="off" enctype="multipart/form-data">
  <input type="hidden" id="_url_aprove" value="{{ route('aprobarsolicitud') }}">
  <input type="hidden" id="_token_aprove" value="{{ csrf_token() }}">
  <input type="hidden" name="id" value="{{ $customrequest->encode_id }}">
  <input type="hidden" name="customrequest_id" value="{{$customrequest->id}}">
  <input type="hidden" name="state" value="1">
    <div class="row">

    <div class="col-6">

      <div class="col-md-12 col-12">
          <div class="mb-1">
              <label class="form-label" for="product">Nombre Producto</label>
              <input type="text" class="form-control" id="product" name="product"  value="{{$customrequest->product}}" >
              <span class="missing_alert text-danger" id="product_alert"></span>
          </div>
      </div>   
    
      <div class="col-md-12 col-12">
        <div class="mb-1">
          <label class="form-label" for="price_finish">Precio del producto</label>
          <input type="text" class="form-control" id="price_finish" name="price_finish"  value="{{$customrequest->price_finish}}" >
          <span class="missing_alert text-danger" id="price_finish_alert"></span>
        </div>
      </div> 
      <div class="col-md-12 col-12">
        <div class="mb-1">
          <label class="form-label" for="iva">Iva</label>
          <select  class="form-control" id="iva" name="iva">
            <option value="0" {{ ($customrequest->iva==0) ? "selected" : "" }} >Ninguno - (0%)</option>
            <option value="0.5" {{ ($customrequest->iva==0.5) ? "selected" : "" }} >IVA - (5%)</option>
            <option value="0.19" {{ ($customrequest->iva==0.19) ? "selected" : "" }} >IVA - (19%)</option>
            <option value="0.8" {{ ($customrequest->iva==0.8) ? "selected" : "" }} >IVA - (8%)</option>
           
          </select>
          <span class="missing_alert text-danger" id="iva_alert"></span>
        </div>
      </div> 
      <div class="col-md-12 col-12">
          <div class="mb-1">
              <label class="form-label" for="shipping_from">Enviado desde</label>
              <input type="text" class="form-control" id="shipping_from" name="shipping_from"  value="{{$customrequest->shipping_from}}" >
              <span class="missing_alert text-danger" id="shipping_from_alert"></span>
          </div>
      </div>       
      
      <div class="col-md-12 col-12">
        <div class="mb-1">
          <label class="form-label" for="price_shiping">Valor del envio</label>
          <input type="text" class="form-control" id="price_shiping" name="price_shiping"  value="{{$customrequest->price_shiping}}" >
          <span class="missing_alert text-danger" id="price_shiping_alert"></span>
        </div>
      </div>

    </div>
    <div class="col-6">
      <div class="col-md-12 col-12">
        <div class="mb-1">
          <label class="form-label" for="comment">Descripción detallada de lo que incluye</label>
          <textarea class="form-control" id="comment" name="comment"  >{{$customrequest->comment}}</textarea>          
        </div>
      </div> 

      <div class="col-md-12 col-12">
        <div class="mb-1">
        <div class='element row' id='div_1'>                                        
                                            <div class="col-md-8 col-12">
                                                <label class="form-label" for="image">Imagen</label>
                                                <input type="file" class="form-control" id="image" name="image[]" >
                                                <span class="missing_alert text-danger" id="image_alert"></span>
                                            </div>
                                            <div class="col-md-4 col-12 pt-2 ">                                           
                                                <a href="#" title="Agregar" class="btn btn-success add"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
        </div>
      </div>

    </div>
    

       

    </div>    
    <div class="col-12 mt-3">
      <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('solicitud-personalizada',[$customrequest->encode_id]) }}" class="btn btn-primary waves-effect waves-float waves-light add-ingredient-size" value="Delete user"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
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
if ($('#price_finish').val() === '') {
    $('#price_finish_alert').text('Ingrese el precio final').show();
    $('#price_finish').focus();
    return false;
}
if ($('#shipping_from').val() === '') {
    $('#shipping_from_alert').text('Ingrese el lugar de donde se envia').show();
    $('#shipping_from').focus();
    return false;
}
if ($('#product').val() === '') {
    $('#product_alert').text('Ingrese un nombre para el producto').show();
    $('#product').focus();
    return false;
}
if ($('#date_delivery_ok').val() === '') {
    $('#date_delivery_ok_alert').text('Seleccione la fecha de entrega').show();
    $('#date_delivery_ok').focus();
    return false;
}
if ($('#price_shiping').val() === '') {
    $('#price_shiping_alert').text('Ingrese el valor del envio en caso contrario ingrese 0 ').show();
    $('#price_shiping').focus();
    return false;
}
Swal.fire({
title: 'Seguro que desea aprobar la solicitud personalizada',
text: "",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Aceptar',
cancelButtonText: 'Cancelar',
}).then((result) => {
if (result.isConfirmed) {
  $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
  var formData = new FormData($("#main-form-aprove")[0]);
    $.ajax({
      url: $('#main-form-aprove #_url_aprove').val(),
    	headers: {'X-CSRF-TOKEN': $('#main-form-aprove #_token_aprove').val()},
    	type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (response) {
        var json = $.parseJSON(response);
        console.log(json);
        Swal.fire(
            'Muy bien!',
            'Solicitud perzonalizada aprobada correctamente',
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


$(document).ready(function() {
    var iCnt = 0;
// Crear un elemento div añadiendo estilos CSS
        var container = $(document.createElement('div'));

        $('#btAdd').click(function() {
            if (iCnt <= 19) {
                iCnt = iCnt + 1;
                // Añadir caja de texto.
                $(container).append('<div class="row" id="tb'+iCnt +'"><div class="col-md-6 col-12"><div class="mb-1"><label class="form-label" for="question">Pegunta</label><input type="text" class="form-control"  name="question[]" ></div></div><div class="col-md-6 col-12"><div class="mb-1"><label class="form-label" for="answer">Respuesta</label><textarea class="form-control"  name="answer[]" ></textarea></div></div></div>');

                if (iCnt == 1) {   

                var divSubmit = $(document.createElement('div'));
                    

                }

        $('#main').after(container, divSubmit); 
            }
            else {      //se establece un limite para añadir elementos, 20 es el limite
                
                $(container).append('<label>Limite Alcanzado</label>'); 
                $('#btAdd').attr('class', 'bt-disable'); 
                $('#btAdd').attr('disabled', 'disabled');

            }
        });

        $('#btRemove').click(function() {   // Elimina un elemento por click
            if (iCnt != 0) { $('#tb' + iCnt).remove(); iCnt = iCnt - 1; }
        
            if (iCnt == 0) { $(container).empty(); 
        
                $(container).remove(); 
                $('#btSubmit').remove(); 
                $('#btAdd').removeAttr('disabled'); 
                $('#btAdd').attr('class', 'bt btn-success btn') 

            }
        });
        
    });

    $(document).ready(function(){

// Add new element
$(".add").click(function(){

 // Finding total number of elements added
 var total_element = $(".element").length;

 // last <div> with element class id
 var lastid = $(".element:last").attr("id");
 var split_id = lastid.split("_");
 var nextindex = Number(split_id[1]) + 1;

 var max = 10;
 // Check total number elements
 if(total_element < max ){
  // Adding new div container after last occurance of element class
  $(".element:last").after("<div class='element row' id='div_"+ nextindex +"'></div>");

  // Adding element to <div>
  $("#div_" + nextindex).append('<div class="col-md-8 col-12"><label class="form-label" for="image">Imagen</label><input type="file" name="image[]"  class="form-control" placeholder="xxxx" id="txt_1" ></div><div class="col-md-4 col-12 pt-2 "><a href="#" id="remove_'+nextindex+'" class="btn btn-danger remove" title="Eliminar"><i class="fa fa-trash-o" aria-hidden="true"></i></a></div> ');

 }

});

// Remove element
$('.container').on('click','.remove',function(){

 var id = this.id;
 var split_id = id.split("_");
 var deleteindex = split_id[1];

 // Remove <div> with id
 $("#div_" + deleteindex).remove();

}); 
});

</script>
@endpush