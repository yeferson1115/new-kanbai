@extends('layouts.app')
@section('title', 'Registro')
@section('content')

@section('content')
<section class="section-agents section-t8 mt-5 product-desk">
    <div class="container">
        <div class="row mt-5">

        <div class="d-flex align-items-start mt-5">
            
            <div class="nav flex-column nav-pills me-3 wth-30" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <div class="row">
                    <div class="col-4 icon-profile">
                        <label class="content-icon-profile"><i class="bi bi-person"></i></label>
                    </div>
                    <div class="col-8">
                        <h4 class="mb-0">Hola, {{ Auth::user()->name}} </h4>
                    </div>
                
                </div>
                <hr>
                
                <button class="nav-link menu-user" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true"><i class="fa fa-square squere-menu-user" aria-hidden="true"></i> Mi Información <i class="fa fa-chevron-right float-right icon-net-menu-user" aria-hidden="true"></i></button>
                <button class="nav-link menu-user" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false"><i class="fa fa-square squere-menu-user" aria-hidden="true"></i> Mis Proyectos <i class="fa fa-chevron-right float-right icon-net-menu-user" aria-hidden="true"></i></button>
                <button class="nav-link menu-user" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false"><i class="fa fa-square squere-menu-user" aria-hidden="true"></i> Balance Financielo <i class="fa fa-chevron-right float-right icon-net-menu-user" aria-hidden="true"></i></button>
                <button  onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link menu-user" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                    <i class="fa fa-square squere-menu-user" aria-hidden="true"></i> Cerrar Sesión <i class="fa fa-chevron-right float-right icon-net-menu-user" aria-hidden="true"></i>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </button>
            </div>
            <div class="tab-content wth-70 back-tap" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-prject" role="tabpanel" aria-labelledby="v-pills-prject-tab">
                <div class="col-md-12">
                <a  style="color: #7F00FF;" href="/mis-proyectos/{{$project->encode_id}}" title="Volver al Proyecto">< Volver al Proyecto </a>
                            <div class="card card-bordered mt-3">
                                <div class="card-header">
                                    <h4 class=""><strong>Notas del Proyecto #{{$project->id}}</strong></h4>                                        
                                </div>
                                <div class="ps-container ps-theme-default ps-active-y" id="chat-content" >
                                    @foreach($project->chat as $item)
                                    @if($item->type_sender==1)
                                    <div class="media media-chat media-chat-recive">                                       
                                        <div class="media-body">
                                            <p>{{$item->message}}</p> 
                                            @if($item->file!=null)
                                                <img style="max-width: 50%; border-radius: 30px;float: left;clear: left; border-radius: 30px;" class="mb-1" src="{{ asset('images/chats/'.$item->file.'') }}">
                                            @endif 
                                            <p class="meta"><time datetime="{{$item->created_at}}">{{$item->created_at}}</time></p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($item->type_sender==2)                                    
                                    <div class="media media-chat media-chat-reverse">
                                        <div class="media-body">
                                            <p>{{$item->message}}</p> 
                                            @if($item->file!=null)
                                                <img style="max-width: 50%; border-radius: 30px;float: right;clear: right; border-radius: 30px;" class="mb-1" src="{{ asset('images/chats/'.$item->file.'') }}">
                                            @endif                                           
                                            <p class="meta"><time datetime="{{$item->created_at}}">{{$item->created_at}}</time></p>
                                        </div>
                                    </div> 
                                    @endif
                                    @endforeach
                                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                                    </div>
                                </div>
                                <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form-chat" autocomplete="off">
                                    <input type="hidden" id="_url" value="{{ url('projectchat') }}">
                                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="type_sender" name="type_sender" value="2">
                                    <input type="hidden" id="project_id" name="project_id" value="{{$project->id}}">
                                    <div class="publisher bt-1 border-light">
                                        <img class="avatar avatar-xs" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                                        <input class="publisher-input" type="text" placeholder="Mensaje" name="message">
                                        <span class="missing_alert text-danger" id="message_alert"></span>
                                        <span class="publisher-btn file-group" style="display: none;">
                                            <i class="fa fa-paperclip file-browser"></i>                                            
                                        </span>
                                        <input type="file" id="imagechat" style="display: none;" name="image">
                                        <a class="publisher-btn" href="#" data-abc="true"><i class="fa fa-smile"></i></a>
                                        <button type="submit" class="publisher-btn text-info" id="submit"><i class="fa fa-paper-plane"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
                <div class="tab-pane fade show " id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                @include('site.business.forms.edituser',['user'=>$user])
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                @include('site.business.forms.projects',['projects'=>$projects])
                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">...</div>
            </div>
        </div>

        </div>
    </div>
</section>

<section class="section-agents section-t8 mt-5 profile-mobile">
    <div class="container">
        <div class="row ">
        <a  style="color: #7F00FF;" href="/mis-proyectos/{{$project->encode_id}}" title="Volver al Proyecto">< Volver al Proyecto </a>

            <div class=" mt-2">
            
                                
              <div class="col-md-12">

              <div class="card card-bordered mt-3">
                                <div class="card-header">
                                    <h4 class=""><strong>Notas del Proyecto #{{$project->id}}</strong></h4>                                        
                                </div>
                                <div class="ps-container ps-theme-default ps-active-y" id="chat-content" >
                                    @foreach($project->chat as $item)
                                    @if($item->type_sender==1)
                                    <div class="media media-chat media-chat-recive">                                       
                                        <div class="media-body">
                                            <p>{{$item->message}}</p> 
                                            @if($item->file!=null)
                                                <img style="max-width: 50%; border-radius: 30px;float: left;clear: left; border-radius: 30px;" class="mb-1" src="{{ asset('images/chats/'.$item->file.'') }}">
                                            @endif 
                                            <p class="meta"><time datetime="{{$item->created_at}}">{{$item->created_at}}</time></p>
                                        </div>
                                    </div>
                                    @endif
                                    @if($item->type_sender==2)                                    
                                    <div class="media media-chat media-chat-reverse">
                                        <div class="media-body">
                                            <p>{{$item->message}}</p> 
                                            @if($item->file!=null)
                                                <img style="max-width: 50%; border-radius: 30px;float: right;clear: right; border-radius: 30px;" class="mb-1" src="{{ asset('images/chats/'.$item->file.'') }}">
                                            @endif                                           
                                            <p class="meta"><time datetime="{{$item->created_at}}">{{$item->created_at}}</time></p>
                                        </div>
                                    </div> 
                                    @endif
                                    @endforeach
                                    <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                        <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                    </div>
                                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                                        <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;"></div>
                                    </div>
                                </div>
                                <form class="form" role="form" action="javascript:void(0)" enctype="multipart/form-data" id="main-form-chat" autocomplete="off">
                                    <input type="hidden" id="_url" value="{{ url('projectchat') }}">
                                    <input type="hidden" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="type_sender" name="type_sender" value="2">
                                    <input type="hidden" id="project_id" name="project_id" value="{{$project->id}}">
                                    <div class="publisher bt-1 border-light">
                                        <img class="avatar avatar-xs" src="https://img.icons8.com/color/36/000000/administrator-male.png" alt="...">
                                        <input class="publisher-input" type="text" placeholder="Mensaje" name="message">
                                        <span class="missing_alert text-danger" id="message_alert"></span>
                                        <span class="publisher-btn file-group" style="display: none;">
                                            <i class="fa fa-paperclip file-browser"></i>                                            
                                        </span>
                                        <input type="file" id="imagechat" style="display: none;" name="image">
                                        <a class="publisher-btn" style="display: none;" href="#" data-abc="true"><i class="fa fa-smile"></i></a>
                                        <button type="submit" class="publisher-btn text-info" id="submit"><i class="fa fa-paper-plane"></i></button>
                                    </div>
                                </form>
                            </div>

              </div>  
              
            </div>               
        </div>
    </div>
</section>
@endsection

@push('scripts')
    
    <script src="{{ asset('js/app/projectChat/create.js') }}"></script>
    <script>
    $('.file-group').click(function() {
        console.log('hola');
        //$('#image').click();
        //$("#imagechat").trigger("click");
        open_file()
    });
    function open_file(){
      $('#imagechat').click();
  }
</script>
@endpush
