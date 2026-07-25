<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\CustomerUser;
use App\Models\User;


use Image;

class CustomerUserController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Asignación')->only('index');
        $this->middleware('permission:Crear Asignación')->only('create');
        $this->middleware('permission:Crear Asignación')->only('store');
        $this->middleware('permission:Editar Asignación')->only('update');
        $this->middleware('permission:Editar Asignación')->only('edit');
        $this->middleware('permission:Eliminar Asignación')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $relacionEloquent = 'roles';
        $users = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Asesor');
        })->get();
        return view ('admin.customerUser.index', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        return view ('admin.customerUser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
       

        return json_encode(['success' => true, 'id' => $customeruser->encode_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param   $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->with('permissions')->find(\Hashids::decode($id)[0]);
        return view('admin.customerUser.edit', ['user' => $user]);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customeruser = CustomerUser::find(\Hashids::decode($id)[0]);
        
      
        $customeruser->user_id=$request->user_id;   
        $customeruser->customer_user_id=$request->customer_user_id; 
        $customeruser->whatsapp=$request->whatsapp; 
        $customeruser->description=$request->description;   
        $customeruser->save();

        return json_encode(['success' => true, 'customer_id' => $customeruser->encode_id]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $user = User::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
    
}
