<p class="mt-3 price-unit"><label class="price-unit">${{number_format($pricemax, 0, 0, '.')}}</label> valor por unidad</p>
 
<form action="javascript:void(0)" id="main-form-mobile" autocomplete="off">
        <input type="hidden" name="producto_id" value="{{$product->id}}">
        <input type="hidden" name="producto_id" id="producto_id" value="{{$product->id}}">
        <input type="hidden" id="_url-m" value="{{route('cartmobile.add')}}">
        <input type="hidden" id="_token-m" value="{{ csrf_token() }}"> 
        <input type="hidden" id="minima-m" value="{{$cantidadminima}}">
        <input type="hidden" id="color_mobile" name="color" >
        <input type="hidden" id="size_mobile" name="size" >
        @foreach($product->adicional as $additional)
            <div class="row mt-2 mb-2">  
                <div class="col-md-12">
                    <label for="exampleInputEmail1" class="form-label">{{$additional->extra->name}} (Opcional)</label>
                    <select class="form-select extramobile" style="border-radius: 15px;"  name="extras[]">
                        <option value="" selected>Seleccione una opción</option>
                            @foreach($additional->extra->items as $i)
                                <option value="{{$i->id}}">{{$i->name}}</option>
                            @endforeach
                                
                    </select>
                </div>
            </div> 
        @endforeach
        <div class="mb-3 row">
            <label for="quantity" class="col-8 col-form-label label-cantidad">Escribe la cantidad:</label>
            <div class="col-4">
                <input type="number" class="form-control" style="border-radius: 15px;" id="quantity-m" name="quantity_m" min="{{$cantidadminima}}" >
            </div>
        </div>
        <div class="row mt-3 mb-5">  
            @guest
                <div class="col-md-12 mt-3 mb-3">
                    <button type="submit" id="btn-cotizar-m" class="btn btn-add-cart mt-2" style="font-weight: 700;">Solicitar cotización</button>
                </div>
            @endguest            
            @auth
            <div class="col-md-12 mb-4">                                                               
                <button type="submit" name="btn" id="btn-cotizar-m" class="btn btn-add-cart-border mt-2" style="font-weight: 700;">Solicitar cotización</button>
            </div>
            <div class="col-md-12">
                <button type="submit" id="btn-pedir-ahora-m" class="btn btn-add-cart mt-2" style="font-weight: 700;">Pedir ahora</button>
            </div>
             @endauth
        </div>
</form>

    
@push('scripts')
<script src="{{ asset('js/app/cart/addcartmobile.js').'?'.rand() }}"></script>
<script>

$("#quantity-m").keyup(function(){
    Getpricemobile();
});
$("#quantity-m").on( "blur", function() {
    Getpricemobile();
});
$(document).on('change', '.extramobile', function () {
   Getpricemobile();
});
function Getpricemobile() {
    var min={{$cantidadminima}};
    if(min>$('#quantity-m').val()){
        //_alertGeneric('info','Información','Debes ingresar la cantidad minima requerida',null);
        $('.text-price').text('$'+formatNumber(0));
        $('.price-unit').text('$'+formatNumber(0)+' valor por unidad');
        return false;
    }
    $.ajax({
            url: "{{route('getprice')}}",
            headers: {'X-CSRF-TOKEN': $('#_token-m').val()},
            type: 'POST',
            data: {quantity:$('#quantity-m').val(),producto_id:$('#producto_id').val(),extras: $("select[name='extras[]']").length
                ? $("select[name='extras[]']").map(function () { return $(this).val(); }).get()
                : []},
            success: function (response) {
                var json = $.parseJSON(response);
                if(json.success){
                    console.log(json);
                    $('.text-price').text('$'+formatNumber(json.price*$('#quantity-m').val()));
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
