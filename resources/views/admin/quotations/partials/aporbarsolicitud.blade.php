<form method="POST" action="">
  <input type="hidden" name="quotation_id" value="{{$quotation->id}}">
  <input type="hidden" name="state" value="1">
  <input type="hidden" name="new_state" value="0">
    <div class="row">
      <h4 class="mt-2 titleh">Productos</h4>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col"></th>
              <th scope="col">Producto</th>
              <th scope="col">Valor Unidad</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Subtotal</th>
              <th scope="col"></th>
            </tr>
          </thead>
        <tbody>
        @foreach($quotation->items as $key=>$item)
          <tr>
            <th scope="row">{{$key+1}}</th>
            <td style="padding: 7px;">
              @if(count($item->producto->gallery)>0)
                <img  class="image-solicitud" src="{{ asset('images/products/thumbnail/list/'.$item->producto->gallery[0]->file.'') }}">
              @endif
            </td>
            <td>{{$item->producto->name}}</td>
            <td style="padding: 7px;">
              <div class="mb-1">
                <input type="hidden"  name="item_id[]"  value="{{$item->id}}" >
                <input type="hidden"  name="product_id[]"  value="{{$item->product_id}}" >
                <input type="hidden"  name="color_id[]"  value="{{$item->color_id}}" >
                <input type="hidden"  name="talla_id[]"  value="{{$item->talla_id}}" >
                <input type="text" class="form-control" id="price" name="price[]"  value="{{$item->price}}" >
                <span class="missing_alert text-danger" id="price_alert"></span>
              </div>
            </td>
            <td style="padding: 7px;">
              <div class="mb-1">
                <input type="text" class="form-control" id="quantity" name="quantity[]"  value="{{$item->quantity}}" >
                <span class="missing_alert text-danger" id="quantity_alert"></span>
              </div>
            </td>
            <td style="padding: 7px;">
              <p class="total">
                {{$item->quantity*$item->price }}
              </p>
            </td>
            <td style="padding: 7px;"><a href="#" class="btn btn-light borrar"><i class="fa fa-times" aria-hidden="true"></i></a></td>
          </tr>
          @if(count($item->extras)>0)
          <tr>
            <td colspan="7">
            <table class="table">
              <thead>
                <tr>
                  <th>Extra</th>
                  <th>Precio</th>
                </tr>
              </thead>
              <tbody>
                @foreach($item->extras as $extra)
                <tr>
                  <td>{{$extra->itemextra->name}}</td>
                  <td>
                    <input type="hidden" class="form-control" name="extra_id_{{$item->id}}[]"  value="{{$extra->id}}" >
                    <input type="number" class="form-control" name="price_extra_{{$item->id}}[]"  value="{{$extra->itemextra->price}}" >
                  </td>
                </tr>
                @endforeach

                
              </tbody>
          </table>
          <td>
          </tr>
          @endif
          @endforeach
          <tr>
                  <td colspan="7" class="text-end">
                    <button type="button" class="btn btn-success btn-sm" id="btnAddProduct">
                      <i class="fa fa-plus"></i> Agregar producto
                    </button>
                  </td>
                </tr>
        </tbody>
      </table>

      <template id="productRowTemplate">
  <tr class="new-product-row">
    <th scope="row">#</th>
    <td style="padding:7px;">
      <img class="image-solicitud" src="{{ asset('images/products/thumbnail/list/default.png') }}">
    </td>
    <td>
      <select class="form-control select-product" name="product_id[]">
        <option value="">Seleccione un producto</option>
        @foreach(App\Models\Products::all() as $p)
          <option value="{{ $p->id }}">{{ $p->name }}</option>
        @endforeach
      </select>
    </td>
    <td style="padding:7px;">
      <input type="number" class="form-control price" name="price[]" value="0">
    </td>
    <td style="padding:7px;">
      <input type="number" class="form-control quantity" name="quantity[]" value="1">
    </td>
    <td style="padding:7px;">
      <p class="total">0</p>
    </td>
    <td style="padding:7px;">
      <a href="#" class="btn btn-light borrar"><i class="fa fa-times" aria-hidden="true"></i></a>
    </td>
  </tr>
</template>


    </div>
    <h4 class="mt-2 titleh">Envio</h4>
    <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="price_shiping">Valor Envio</label>
          <input type="text" class="form-control" id="price_shiping" name="price_shiping"  value="{{$quotation->price_shiping}}" >
          <span class="missing_alert text-danger" id="price_shiping_alert"></span>
        </div>

        
    </div> 

    <h4 class="mt-2 titleh">Gestion</h4>
    <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="price_shiping">Plazo</label>
          <select name="plazo" id="plazo" class="form-select">
            <option value="">Seleccione plazo</option>
            <option value="contado"  {{ ($quotation->plazo=='contado') ? "selected" : "" }}>Contado</option>
            <option value="15 dias" {{ ($quotation->plazo=='15 dias') ? "selected" : "" }}>15 días</option>
            <option value="30 dias" {{ ($quotation->plazo=='30 dias') ? "selected" : "" }}>30 días</option>
            <option value="45 dias" {{ ($quotation->plazo=='45 dias') ? "selected" : "" }}>45 días</option>
            <option value="60 dias" {{ ($quotation->plazo=='60 dias') ? "selected" : "" }}>60 días</option>
          </select>
          <span class="missing_alert text-danger" id="plazo_alert"></span>
        </div>

        
    </div> 

    <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="asesores">Asesor</label>
          <select name="user_id" id="user_id" class="form-select">
            <option value="">Seleccione Asesor</option>
            @foreach( $asesores as $key => $value )
              <option value="{{ $value->id }}" {{ ($quotation->user_id==$value->id) ? "selected" : "" }}>{{ $value->name }} {{ $value->lastname }}</option>
            @endforeach    
          </select>
          <span class="missing_alert text-danger" id="user_id_alert"></span>
        </div>

        
    </div> 
    

    

    <h4 class="mt-2 titleh">Datos Cliente</h4>
    
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="name">Nombre del Cliente</label>
          <input type="text" class="form-control" id="name" name="name"  value="{{$quotation->name}}" >
          <span class="missing_alert text-danger" id="name_alert"></span>
        </div>
      </div>
      <div class="col-md-6 col-12">
          <div class="mt-1rem">
              <label class="form-label" for="type_document">Tipo de documento</label>
              <select class="form-control input-cart" id="type_document" name="type_document">
                <option value="">Seleccione</option>
                <option value="Cédula de Ciudadania" {{ ($quotation->type_document=='Cédula de Ciudadania') ? "selected" : "" }}>Cédula de Ciudadania</option>
                <option value="Cédula de Extranjeria" {{ ($quotation->type_document=='Cédula de Extranjeria') ? "selected" : "" }}>Cédula de Extranjeria</option>
                <option value="Pasaporte" {{ ($quotation->type_document=='Pasaporte') ? "selected" : "" }}>Pasaporte</option>
                <option value="Nit" {{ ($quotation->type_document=='Nit') ? "selected" : "" }}>Nit</option>
              </select>
              <span class="missing_alert text-danger" id="type_document_alert"></span>
            </div>
      </div>

      <div class="col-md-6 col-12">
        <div class=" mt-1rem">
          <label class="form-label " for="document">Número de documento</label>
          <input type="text" class="form-control input-cart" id="document" name="document" value="{{$quotation->document}}" >
          <span class="missing_alert text-danger" id="document_alert"></span>
        </div>
      </div>
      <div class="col-md-6 col-12">
          <div class=" mt-1rem">
            <label class="form-label " for="name_business">Nombre de la empresa</label>
            <input type="text" class="form-control input-cart" id="name_business" name="name_business" value="{{$quotation->name_business}}">
            <span class="missing_alert text-danger" id="name_business_alert"></span>
          </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="cellphone">Teléfono del Cliente</label>
          <input type="text" class="form-control" id="cellphone" name="cellphone"  value="{{$quotation->cellphone}}" >
          <span class="missing_alert text-danger" id="cellphone_alert"></span>
        </div>
      </div> 
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="email">Correo del Cliente</label>
          <input type="email" class="form-control" id="email" name="email"  value="{{$quotation->email}}" >
          <span class="missing_alert text-danger" id="email_alert"></span>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class=" mt-1rem">
          <label class="form-label " for="address">Dirección de entrega</label>
          <input type="text" class="form-control input-cart" id="address" name="address" value="{{$quotation->address}}">
          <span class="missing_alert text-danger" id="address_alert"></span>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class=" mt-1rem">
          <label class="form-label " for="city">Municipio</label>
          <input type="text" class="form-control input-cart" id="city" name="city" value="{{$quotation->city}}">
          <span class="missing_alert text-danger" id="city_alert"></span>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class=" mt-1rem">
          <label class="form-label " for="date_delivery">Fecha de entrega</label>
          <input type="date" class="form-control input-cart" id="date_delivery" name="date_delivery" value="{{$quotation->date_delivery}}">
          <span class="missing_alert text-danger" id="date_delivery_alert"></span>
        </div>
      </div>
      <div class="col-md-6 col-12">
        <div class="mb-1">
          <label class="form-label" for="state">Estado</label>
          <select  id="state" name="state" class="form-control">
            <option value="0" {{ ($quotation->state==0) ? "selected" : "" }}>Sin gestionar</option>
            <option value="1" {{ ($quotation->state==1) ? "selected" : "" }}>Gestionado</option>
            <option value="1" {{ ($quotation->state==3) ? "selected" : "" }}>Aprobada</option>
            <option value="2" {{ ($quotation->state==2) ? "selected" : "" }}>Cancelado</option>
                                                    
          </select>
          <span class="missing_alert text-danger" id="state_alert"></span>
        </div>
      </div> 

      
      <div class="col-md-12 col-12">
        <div class="mb-1">
          <label class="form-label" for="comment">Condiciones y consideraciones:</label>
          <textarea class="ckeditor" id="comment" name="comment"  >{{$quotation->comment}}</textarea>
          
        </div>
      </div>  

    </div>    
    <div class="col-12 mt-3">
      <button type="submit" data-token="{{ csrf_token() }}" data-attr="{{ url('quotes',[$quotation->encode_id]) }}" class="btn btn-primary waves-effect waves-float waves-light guardarinfo" value="Delete user"><i id="ajax-icon" class="fa fa-save"></i> Guardar</button>
    </div>        
</form>



@push('scripts')
<script>

$(document).on('click', '.borrar', function(event) {
  event.preventDefault();
  $(this).closest('tr').remove();
});

$('.guardarinfo').click(function(e){

e.preventDefault();
var _target=e.target;
let href = $(this).attr('data-attr');// Don't post the form, unless confirmed
let token = $(this).attr('data-token');

for ( instance in CKEDITOR.instances )
    CKEDITOR.instances[instance].updateElement();

if ($('#name').val() === '') {
    $('#name_alert').text('Ingrese el nombre del cliente').show();
    $('#name').focus();
    return false;
}
if ($('#cellphone').val() === '') {
    $('#cellphone_alert').text('Ingrese el teléfono del cliente').show();
    $('#cellphone').focus();
    return false;
}


if ($('#email').val() === '') {
    $('#email_alert').text('Ingrese el e-mail del cliente').show();
    $('#email').focus();
    return false;
}


if ($('#state').val() === '') {
    $('#state_alert').text('Selecione un estado').show();
    $('#state').focus();
    return false;
}


var validate=false;

$("input[name='item_id[]']").each(function() {
   validate=true;
});

if(validate==false){
  _alertGeneric('info','Información','No hay productos para esta cotización',null);       
  return false;
}
$("input[name='price[]']").each(function() {
    var temp2=$(this).val();
    if(temp2=="" || temp2==null || temp2==0){             
      _alertGeneric('info','Información','El precio debe ser mayor a 0',null);
      return false;
    }
  });
  $("input[name='quantity[]']").each(function() {
    var temp2=$(this).val();
    if(temp2=="" || temp2==null || temp2==0){             
      _alertGeneric('info','Información','La cantidad debe ser mayor a 0',null);
      return false;
    }
  });
  var data=$(e.target).closest('form').serialize();
 
Swal.fire({
title: 'Seguro que desea modificar la cotización',
text: "",
icon: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Aceptar',
cancelButtonText: 'Cancelar',
}).then((result) => {
if (result.isConfirmed) {
  showloader();
  $('#ajax-icon').removeClass('fa fa-save').addClass('fa fa-spin fa-refresh');
    $.ajax({
      url: href,
      headers: {'X-CSRF-TOKEN': token},
      type: 'PUT',
      cache: false,
      data: data,
      success: function (response) {
        hidenloader();
        var json = $.parseJSON(response);
        console.log(json);
        Swal.fire(
            'Muy bien!',
            'Solicitud editada correctamente',
            'success'
            ).then((result) => {
                location.reload();
            });

      },error: function (data) {
        hidenloader();
        var errors = data.responseJSON;
        console.log(errors);

      }
   });

}
})

});

// === Agregar nueva fila de producto ===
$(document).on('click', '#btnAddProduct', function (e) {
  e.preventDefault();

  // Clonar plantilla
  let template = $('#productRowTemplate').html();
  $('table tbody').append(template);

  // Recalcular índices visuales (#)
  $('table tbody tr').each(function (index) {
    $(this).find('th:first').text(index + 1);
  });
});

// === Calcular subtotal dinámicamente ===
$(document).on('input', '.price, .quantity', function () {
  let row = $(this).closest('tr');
  let price = parseFloat(row.find('.price').val()) || 0;
  let quantity = parseFloat(row.find('.quantity').val()) || 0;
  row.find('.total').text(price * quantity);
});

// === Cargar precio del producto automáticamente al seleccionarlo ===
$(document).on('change', '.select-product', function () {
  let productId = $(this).val();
  let row = $(this).closest('tr');

  if (productId !== "") {
    $.ajax({
      url: '/api/products/' + productId, // crearemos este endpoint
      type: 'GET',
      success: function (product) {
        row.find('.price').val(product.price);
        row.find('.total').text(product.price * row.find('.quantity').val());
        row.find('img.image-solicitud').attr('src', '/images/products/thumbnail/list/' + (product.image ?? 'default.png'));
      }
    });
  }
});


</script>
@endpush