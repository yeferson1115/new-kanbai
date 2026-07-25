<p class="mt-3 price-unit"><label class="price-unit">${{number_format($pricemax, 0, 0, '.')}}</label> valor por unidad</p>
<form  action="javascript:void(0)" id="main-form" autocomplete="off">
    <input type="hidden" name="producto_id" id="producto_id" value="{{$product->id}}">
    <input type="hidden" id="_url" value="{{route('cart.add')}}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="minima" value="{{$cantidadminima}}">
    <input type="hidden" id="color" name="color" >
    <input type="hidden" id="size" name="size" >

    @foreach($product->adicional as $additional)
        <div class="row mt-2 mb-2">  
            <div class="col-md-12">
                <label for="exampleInputEmail1" class="form-label">{{$additional->extra->name}} (Opcional)</label>
                <select class="form-select extra" style="border-radius: 15px;"  name="extras[]">
                    <option value="" selected>Seleccione una opción</option>
                        @foreach($additional->extra->items as $i)
                            <option value="{{$i->id}}">{{$i->name}}</option>
                        @endforeach
                            
                </select>
            </div>
        </div> 
    @endforeach
        
    <div class="mt-5 mb-3 row">
        <label for="quantity" class="col-sm-6 col-form-label label-cantidad">Escribe la cantidad:</label>
            <div class="col-sm-6">
            <input type="number" class="form-control" style="border-radius: 15px;" id="quantity" name="quantity" min="{{$cantidadminima}}" >
        </div>
    </div>
    <div class="row mt-3 mb-5">  
        @guest
            <div class="col-md-12 mt-3 mb-3">
                 <button type="submit" id="btn-cotizar" class="btn btn-add-cart mt-2" style="font-weight: 700;">Solicitar cotización</button>
            </div>
        @endguest
        @auth
            <div class="col-md-12 mb-3">
                <button type="submit" id="btn-cotizar" class="btn btn-add-cart-border mt-2" style="font-weight: 700;">Solicitar cotización</button>
            </div>
            <div class="col-md-12">
                <button type="submit" id="btn-pedir-ahora" class="btn btn-add-cart mt-2" style="font-weight: 700;">Pedir ahora</button>
            </div>
        @endauth
    </div>
</form>

@push('scripts')
<script src="{{ asset('js/app/cart/addcart.js').'?'.rand() }}"></script>
<script>
$("#quantity").keyup(function(){
    Getprice();
});
$("#quantity").on( "blur", function() {
    Getprice();
});

$(document).on('change', '.extra', function () {
   Getprice();
});

function Getprice(){
    var min={{$cantidadminima}};
    if(min>$('#quantity').val()){
        //_alertGeneric('info','Información','Debes ingresar la cantidad minima requerida',null);
        //$('#quantity').val('');
        $('.text-price').text('$'+formatNumber(0));
        $('.price-unit').text('$'+formatNumber(0)+' valor por unidad');
        return false;
    }
    $.ajax({
            url: "{{route('getprice')}}",
            headers: {'X-CSRF-TOKEN': $('#_token').val()},
            type: 'POST',
            data: {quantity:$('#quantity').val(),producto_id:$('#producto_id').val(),extras: $("select[name='extras[]']").length
                ? $("select[name='extras[]']").map(function () { return $(this).val(); }).get()
                : []},
            success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                    console.log(json);
                    $('.text-price').text('$'+formatNumber(json.price*$('#quantity').val()));
                    $('.price-unit').text('$'+formatNumber(json.price)+' valor por unidad');
                }
            },error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                    $.each( errors.errors, function( key, value ) {
                    toastr.error(value);
                    return false;
                    });
                    $('input').iCheck('enable');
                    $('#main-form input, #main-form button').removeAttr('disabled');
                    $('#ajax-icon').removeClass('fa fa-spin fa-refresh').addClass('fa fa-save');
            }
        });  
}
function formatNumber (n) {
    n = String(n).replace(/\D/g, "");
    return n === '' ? n : Number(n).toLocaleString("es-CO");
}
   
</script>
@endpush
