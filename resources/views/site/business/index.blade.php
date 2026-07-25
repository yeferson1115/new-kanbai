@extends('layouts.appuser')
@section('title', 'Mi perfil')
@section('content')

@section('content')
<section class="row">
    <div class="col-md-12" style="padding: 0px 30px;">
    <div class="desk-user" style="margin-top: 10px;">
            <div class="row cont-indicator-user">
                <div class="col-md-2" style="font-size: 18px;
    color: #231B72;
    font-weight: 600;
    padding-top: 5px;">
                    Resumen
               </div>
               <div class="col-md-10">
                    <div class="row"  onclick="location.href='{{ URL::to('/') }}/pedidos-empresa'">                    
                        <div class="col-12" style="text-align: right;cursor: pointer;">
                            <label class="icon-indicator-user icon-indicator-user-blue" >
                               <i class="fa-solid fa-list-check"></i> <span style="color: #636363;"> Total Pedidos: {{count($projects)}}</span>
                            </label>
                            <label class="icon-indicator-user icon-indicator-user-aguamarina">
                                <i class="fa-solid fa-user"></i> <span> Usuarios: {{count($users)}}</span>
                            </label>
                        </div>                       
                    </div>
               </div>
               
            </div>
        <div class="row mt-3">
            <div class="col-md-7">
               @if(count($news) > 0)
                <div class="novedades">
                    @foreach($news as $index => $item)
                    <div class="row mb-4 border-bottom" data-bs-toggle="modal" data-bs-target="#modal{{ $index }}">
                        <div class="col-4 mb-3">
                            <!-- Asegúrate de tener una imagen, puedes reemplazar 'foto' con una URL de imagen -->
                            <img src="{{ asset('images/news/'.$item->image.'') }}" alt="{{ $item->title }}" class="img-fluid image-novedades" />
                        </div>
                        <div class="col-8">
                            <h4>{{ $item->title }}</h4>
                            <p>{{ \Illuminate\Support\Str::limit($item->description, 40) }}</p>
                            @if($item->link != null)
                            <div class="text-end mb-3">
                                <a class="btn btn-novedades" href="{{ $item->link }}">Ver más</a>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="modal{{ $index }}" tabindex="-1" aria-labelledby="modalLabel{{ $index }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel{{ $index }}">{{ $item->title }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ asset('images/news/'.$item->image.'') }}" alt="{{ $item->title }}" class="img-fluid mb-3" />
                                    <p>{{ $item->description }}</p>
                                </div>
                                @if($item->link != null)
                                <div class="modal-footer">
                                    <a class="btn btn-novedades" href="{{ $item->link }}">Ver más</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
            </div>
            <div class="col-md-5 pr-0">
                <div class="infoasesor">
                    <h4 class="title-my-asesor">Mi asesor/a</h4>
                    
                    <label class="icon-image-user">
                        @if($busine->asesor!=null && $busine->asesor->photo!=null)
                        <img src="{{ asset('images/asesor/'.$busine->asesor->photo.'') }}" class="img-fluid mb-3"  style="width: 130px;
    border-radius: 50%;
    height: 130px;"/>
                        @else
                        <i class="fa fa-circle" aria-hidden="true"></i>
                        @endif

                    </label>
                    @if($busine->asesor!=null)
                    <label class="name-asesor">{{$busine->asesor->name}} {{$busine->asesor->lastname}}</label>
                    <p class="description-asesor">{{$busine->asesor->description}}</p>
                    <a class="whatsapp-asesor mb-3" target="_blank" href="https://api.whatsapp.com/send?phone={{$busine->asesor->whatsapp}}&text=Hola, ...">Contactar vía Whatsapp <i class="fa-brands fa-whatsapp"></i></a>
                    <a class="email-asesor mb-3" target="_blank" href="{{$busine->asesor->email}}">Correo <i class="fa fa-envelope-o" aria-hidden="true"></i></a>
                    @else
                    <p class="description-asesor">Aún no se ha asignado un asesor</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <div class="mobile-user">
            <div class="row mt-5">                
                <div class="col-sm-12">
                @include('layouts.partials.menuuser')
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/app/user/create.js') }}"></script>
@endpush
