<ul class="list-group list-group-flush">
    @foreach($productquotation as $item)
    <li class="list-group-item item-quotations-user mb-4">
        <div class="row">
            <div class="col-7 title-quotations-user"><strong>Cotizacion #{{$item->id}}</strong></div>
            <div class="col-5 text-rigth"><a class="bt-kanbai-page" href="/mis-solicitudes/{{$item->encode_id}}">Gestionar</a></div>
        </div>
        <hr>
        <div class="row">
            <!--<div class="col-sm-3 col-4"> 
                <img style="max-width: 100%; border-radius: 20px;" height="100" class="mb-1" src="{{ asset('images/products/thumbnail/list/') }}">
          
            </div>-->
            <div class="col-sm-10 col-6">
                <p class="p-info"><strong>Sub Total:</strong> ${{number_format($item->total, 0, 0, '.')}}</p>
                <p class="p-info"><strong>Envio:</strong> ${{number_format($item->price_shiping, 0, 0, '.')}}</p>
                <p class="p-info"><strong>Total:</strong> ${{number_format($item->total+$item->price_shiping, 0, 0, '.')}}</p>
                <p class="p-info"><strong>Cantidad de Productos:</strong> {{count($item->items)}}</p>
                <p class="p-info">
              
                </p>

            </div>
            <div class="col-2 col-sm-2">
                @if($item->file!=null)
                <a href="{{ asset('cotizaciones/'.$item->file.'') }}" class="btn btn-dowload-user" target="_blank"><i class="fa fa-download" aria-hidden="true"></i></a>
                @endif
            </div>
        </div>
    </li>
    @endforeach
</ul>