@extends('layouts.appuser')
@section('title', 'Usuarios')
@section('content')

@section('content')

<section class="row">
    <div class="col-md-12" style="padding: 0px 30px;">
        <a href="javascript:history.back()" class="previos-profile">
            <i class="bi bi-arrow-left-circle"></i> Volver
        </a>
        @foreach ($projects as $item) 
        <div class="card content-user mb-4">  
        <div class="card-header" style="padding-top: 15px; background-color: transparent !important;">
            <div class="row">
                <div class="col-md-4">
                    {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('F j, Y') }}
                </div>
                <div class="col-md-4">
                    Orden #{{ $item->no_project }}
                </div>
                <div class="col-md-4 text-end">
                    <a class="mb-1 btn btn-warning waves-effect waves-float waves-light btn-edit-user"
                    style="border-radius: 30px;"
                    href="{{ route('pedidosempresa.show', $item->encode_id) }}"
                    title="Ver detalles">
                    Ver detalles
                    </a>
                </div>
            </div>
        </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <table>
                        @foreach($item->productos as $key=>$product)                                                
                            <tr>
                                <td >
                                    @if($item->easybuy==1)
                                    <img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="{{ asset('images/products/'.$product->imagen.'') }}"> 
                                    @else
                                    <img style="max-width: 150px;; border-radius: 7px;" class="mb-1" src="{{ asset('images/custom_request/'.$product->imagen.'') }}"> 
                                    @endif
                                </td>
                                <td style="padding: 15px;">
                                    <label style="display: block;"><b>{{$product->producto}}</b></label>
                                    <label style="display: block;">{{$product->quantity}} uds</label>
                                    <label style="display: block;"><b>${{number_format($product->price, 0, 0, '.')}}</b></label>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                    </div>
                    <div class="col-md-12">
                    @if($item->state==0) <span class="badge  text-white bg-warning stado">En Ejecución</span> @endif
                    @if($item->state==1) <span class="badge  text-white bg-success stado">Finalizado</span> @endif
                    @if($item->state==2) <span class="badge  text-white bg-danger stado">Cancelado</span> @endif
                    </div>
                </div>
                
                    </div>
                </div>
        @endforeach
        
    </div>
</section>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/app/user/create.js') }}"></script>
@endpush
