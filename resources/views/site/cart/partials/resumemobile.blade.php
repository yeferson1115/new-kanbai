<div class="detail-mobile mt-4">
    <p class="resume-check text-center" >Total Pedido: <span>${{number_format(Cart::getTotal()+$totalextras, 0, 0, '.')}}</span></p>
    <div class="accordion accordion-flush mt-3" id="productsdesktap1">
        <div class="accordion-item back-trans">
            <h2 class="accordion-header" id="productstap1">
            <button class="accordion-button collapsed btn-products-cart" type="button" data-bs-toggle="collapse" data-bs-target="#product_tap1" aria-expanded="false" aria-controls="flush-collapseOne">
                Productos carrito
            </button>
                                            </h2>
                                            <div id="product_tap1" class="accordion-collapse collapse" aria-labelledby="productstap1" data-bs-parent="#productsdesktap1">
                                                <div class="accordion-body">
                                                @foreach (Cart::getContent() as $item)
                                                <div class="row">
                                                    <div class="col-4">
                                                        <img class="image-cart-detail" src="{{ asset('images/products/thumbnail/'.$item->attributes->urlfoto.'') }}" />
                                                    </div>
                                                    <div class="col-8">
                                                        <h5 class="title-product-cart" style="font-size: 18px;">{{$item->name}}</h5>
                                                        <p class="info-product-cart f-14"><img style="width: 20px;" src="{{ asset('images/Precio_Icono.png') }}" alt="Rango" class="img-d img-fluid"> Precio: <span class="resume-item">${{number_format($item->price, 0, 0, '.')}}</span></p>
                                                        <p class="info-product-cart f-14" ><i class="fa fa-cart-plus c-green" aria-hidden="true"></i> Cantidad: <span class="resume-item">{{$item->quantity}} Unidades</span></p>
                                                        <input type="hidden" value="{{$product = App\Models\Products::find($item->id)}}">
                                                        @if(!is_null($product->delivery_time))
                                                        <p class="info-product-cart f-14" ><i class="fa fa-truck c-green" aria-hidden="true"></i> Tiempo de Entrega: <span class="resume-item">{{$product->delivery_time}}</span></p>
                                                        @endif
                                                    </div>
                                                </div>
                                                @endforeach
                                                </div>
                                            </div>
                                        </div> 
                                    </div>
</div>