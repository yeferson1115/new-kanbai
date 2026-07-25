<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use App\Models\ProjectChat;
use App\Models\User;


use App\Models\Log\LogSistema;

use Image;

class ProjectChatController extends Controller
{

   
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        $projects = Projects::with('timeline')->where('user_request_id',auth()->user()->id)->get();
        $project = Projects::with('timeline')->find(\Hashids::decode($id)[0]);
//dd($project);
        return view ('site.projects.index', compact('user','projects','project'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function indexpanel()
    {
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los proyectos: '.date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();    

        $todos = Projects::get();
        $ejecucion = Projects::where('state',1)->get(); 
        $cancelados = Projects::where('state',2)->get(); 
        $finalizadas = Projects::where('state',9)->get(); 
        return view('admin.projects.index', compact('todos','ejecucion','cancelados','finalizadas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $imageName=null;
        if($request->image){    
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/chats'), $imageName);
         
        }
        $projectChat = ProjectChat::create([
            'project_id'=>$request->project_id,
            'message'=>$request->message,
            'file'=>$imageName,
            'type_sender'=>$request->type_sender,            
            'state'=>0                             
        ]);

        $imagen=asset('images/chats/'.$projectChat->file.'');
        
        return json_encode(['success' => true, 'data' => $projectChat,'imagen'=>$imagen]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function show(CustomRequest $CustomRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Projects::with('chat')->find(\Hashids::decode($id)[0]);
        
        return view('admin.projectCahts.edit', ['project' => $project]);
    }

    public function chatuser($id)
    {
        $project = Projects::with('chat')->find(\Hashids::decode($id)[0]);
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        $projects = Projects::with('timeline')->where('user_request_id',auth()->user()->id)->get();
        
        return view ('site.projectchat.index', compact('user','projects','project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $CustomRequest = Projects::find(\Hashids::decode($request->id)[0]);
        
        if(isset($request->description)){
            $images=$request->image;
            foreach($request->description as $key=>$item){
                $imageName=null;
                if(isset($images[$key])){
                    $imagen = Image::make($images[$key]);
                    $imageName = time().'_'.$images[$key]->getClientOriginalName().'.'.$images[$key]->extension();
                    $imagen->resize(500, 500, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })->save(public_path('images/projects/' . $imageName));
                }
                ProjectTimeLine::create([
                    'project_id'=>\Hashids::decode($request->id)[0],
                    'description'=>$item,
                    'file'=>$imageName
                ]);
                
            }
        }
        $CustomRequest->state = $request->state;     
       
       
       
       
        $CustomRequest->save();

        return json_encode(['success' => true, 'campuse_id' => $CustomRequest->encode_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CustomRequest  $CustomRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        CustomRequest::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
}
