<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Projects;
use App\Models\ProductQuotation;
use App\Models\CustomerUser;

use Illuminate\Http\Request;

class TrackProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view ('site.trackprojects.login');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('asdasd');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function myinformation(){
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        $projects = Projects::with('timeline')->where('user_request_id',auth()->user()->id)->get();
        return view ('site.business.myinformation', compact('user','projects'));
    }
    public function myprojects($id){
        $project = Projects::with('timeline','productos','comercio','updates')->find($id);
        $total=0;
        foreach($project->productos as $item){
            $total=$total+($item->price*$item->quantity);
        }
        return view ('site.projects.index', compact('project','total'));
        dd($project);
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        $projects = Projects::with('timeline')->where('user_request_id',auth()->user()->id)->get();
        return view ('site.business.myprojects', compact('user','projects'));
    }

    public function myquotations(){
        $user = User::with('roles')->with('permissions')->find(auth()->user()->id);
        //$productquotation = ProductQuotation::with('producto','producto.gallery','history','user')->where('user_request_id',auth()->user()->id)->get();
        $productquotation = ProductQuotation::with('items','items.producto','items.producto.gallery','history','user')->where('user_request_id',auth()->user()->id)->get();
        //dd($productquotation);
        return view ('site.business.myquotations', compact('user','productquotation'));

    }

    public function validateproject(Request $request){
        $project = Projects::where('no_project',$request->no_project)
        ->where('email_customer',$request->email_customer)
        ->with('timeline','productos','comercio','updates')->first();
        if($project){
            //return redirect()->route('mis-proyectos.show', ['id' => $project->id]);   
            return json_encode(['success' => true, 'id' => $project->id]);        
        }else{
            return json_encode(['success' => false, 'id' =>0]);
        }
        dd( $project);
        $total=0;
        foreach($project->productos as $item){
            $total=$total+($item->price*$item->quantity);
        }
        return view ('site.projects.index', compact('project','total'));
    }
}
