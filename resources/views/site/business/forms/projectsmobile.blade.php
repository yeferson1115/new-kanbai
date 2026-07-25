<ul class="list-group list-group-flush">
    @foreach($projects as $item)
    <li class="list-group-item">
        <div class="row">
            <div class="col-6">{{$item->created_at}}</div>
            <div class="col-6">Orden #{{$item->id}} <a class="bt-kanbai-page" href="/mis-proyectos/{{$item->encode_id}}">Gestionar</a></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-4">
            @if($item->type==2)
                <input type="hidden" value="{{$customRequest = App\Models\CustomRequest::where('id',$item->id_type)->first()}}">
                <img style="max-width: 100%; border-radius: 20px;"     height="100" class="mb-1" src="{{ asset('images/custom_request/'.$customRequest->file.'') }}">
            @endif
            @if($item->type==1)
                <input type="hidden" value="{{$quotation = App\Models\ProductQuotation::with('producto','producto.gallery')->where('id',$item->id_type)->first()}}">
                <img style="max-width: 100%; border-radius: 20px;" height="100" class="mb-1" src="{{ asset('images/products/thumbnail/list/'.$quotation->producto->gallery[0]->file.'') }}">
            @endif
            </div>
            <div class="col-8">
                <p class="p-info"><strong>{{$item->name}}</strong></p>
                <p class="p-info"><strong>Total:</strong> ${{number_format($item->price, 0, 0, '.')}}</p>
                <p class="p-info"><strong>Cantidad:</strong> {{$item->quantity}}</p>
                <p class="p-info">
                @if($item->state==0) <span class="badge  text-white bg-warning">En Espera</span> @endif
                @if($item->state==1) <span class="badge  text-white bg-warning">En Ejecución</span> @endif
                @if($item->state==9) <span class="badge  text-white bg-success">Finalizado</span> @endif
                @if($item->state==2) <span class="badge  text-white bg-danger">Cancelado</span> @endif
                </p>

            </div>
        </div>
    </li>
    @endforeach
</ul>