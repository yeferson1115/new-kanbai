<p class="mt-3 price-unit">
    <label class="price-unit">${{ number_format($pricemax, 0, 0, '.') }}</label> valor por unidad
</p>

{{-- Visualización de Precio Grande (Figma Style) --}}
<div class="price-main-display mb-3">
    <span class="text-price">${{ number_format($pricemax, 0, 0, '.') }}</span>
    <span class="tax-label">IVA Incl.</span>
</div>

<form action="javascript:void(0)" id="main-form" autocomplete="off">
    <input type="hidden" name="producto_id" id="producto_id" value="{{ $product->id }}">
    <input type="hidden" id="_url" value="{{ route('cart.add') }}">
    <input type="hidden" id="_token" value="{{ csrf_token() }}">
    <input type="hidden" id="minima" value="{{ $cantidadminima }}">
    <input type="hidden" id="color" name="color">
    <input type="hidden" id="size" name="size">

    {{-- Opciones adicionales --}}
    @foreach($product->adicional as $additional)
        <div class="row mt-2 mb-2">  
            <div class="col-md-12">
                <label for="extra_{{ $additional->extra->id }}" class="form-label fw-bold">{{ $additional->extra->name }} (Opcional)</label>
                <select class="form-select extra custom-input-rounded" id="extra_{{ $additional->extra->id }}" name="extras[]">
                    <option value="" selected>Seleccione una opción</option>
                    @foreach($additional->extra->items as $i)
                        <option value="{{ $i->id }}">{{ $i->name }}</option>
                    @endforeach
                </select>
            </div>
        </div> 
    @endforeach

    {{-- Fila de Cantidad y Botones --}}
    <div class="frame-1000004990 mt-4">
        <div class="frame-1000004512">
            <label for="quantity" class="cantidad2">Cantidad:</label>
            <div class="frame-1000004506">
                <input type="number" 
                       class="form-control border-0 text-center fw-bold p-0 _1" 
                       id="quantity" 
                       name="quantity" 
                       value="{{ $cantidadminima }}"
                       min="{{ $cantidadminima }}">
            </div>
        </div>

        <div class="buttons-action-container flex-grow-1">
            @guest
                <button type="submit" id="btn-cotizar" class="btn btn-add-cart buttons-primary-text-icon w-100">
                    Solicitar cotización
                </button>
            @endguest
            
            @auth
                <div class="d-flex flex-column gap-2 w-100">
                    <button type="submit" id="btn-cotizar" class="btn btn-add-cart-border buttons-outline-text-icon w-100">
                        Solicitar cotización
                    </button>
                    <button type="submit" id="btn-pedir-ahora" class="btn btn-add-cart buttons-primary-text-icon w-100">
                        Pedir ahora
                    </button>
                </div>
            @endauth
        </div>
    </div>
</form>

@push('scripts')
<script src="{{ asset('js/app/cart/addcart.js').'?'.rand() }}"></script>
<script>
$("#quantity").keyup(function(){
    Getprice();
});
$("#quantity").on("blur", function() {
    Getprice();
});

$(document).on('change', '.extra', function () {
   Getprice();
});

function Getprice(){
    var min = {{ $cantidadminima }};
    if(min > $('#quantity').val()){
        $('.text-price').text('$'+formatNumber(0));
        $('.price-unit').text('$'+formatNumber(0)+' valor por unidad');
        return false;
    }
    $.ajax({
        url: "{{ route('getprice') }}",
        headers: {'X-CSRF-TOKEN': $('#_token').val()},
        type: 'POST',
        data: {
            quantity: $('#quantity').val(),
            producto_id: $('#producto_id').val(),
            extras: $("select[name='extras[]']").length
                ? $("select[name='extras[]']").map(function () { return $(this).val(); }).get()
                : []
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.success){
                $('.text-price').text('$'+formatNumber(json.price*$('#quantity').val()));
                $('.price-unit').text('$'+formatNumber(json.price)+' valor por unidad');
            }
        },
        error: function (data) {
            var errors = data.responseJSON;
            if(errors && errors.errors) {
                $.each(errors.errors, function( key, value ) {
                    toastr.error(value);
                    return false;
                });
            }
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