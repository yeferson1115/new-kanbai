<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\Departaments;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Mail;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver las empresas: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $business = Business::with('departaments','cities','asesor')->where('state',1)->get();
        
        return view ('admin.business.index', compact('business'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = Departaments::all();
        $relacionEloquent = 'roles';
        $users = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Asesor');
        })->get();
        return view ('admin.business.create', compact('departments','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $business = Business::create([
            'company_name' => $request->company_name,
            'nit' => $request->nit,
            'billing_email' => $request->billing_email,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'city_id' => $request->city_id,
            'user_id' => $request->user_id,
            'term' => $request->term,
        ]);
    
       

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'id'=>$business->encode_id
        ]);
    }

    public function storeuser(Request $request)
{
    // Validación de los datos
    $request->validate([
        'name' => 'required|string|max:255',
        'document' => 'required|string|max:20',
        'charge' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => [
            'required',
            'email',
            Rule::unique('users')->whereNull('deleted_at'),
        ],
        'password' => 'required|string|min:6',
        'business_id' => 'required|integer|exists:business,id',
    ]);

    // Buscar si el email ya existe, incluso si está eliminado
    $user = User::withTrashed()->where('email', $request->email)->first();

    if ($user) {
        // Si el usuario está eliminado (soft deleted), restaurarlo
        if ($user->trashed()) {
            $user->restore();
        }

        // Actualizar los datos del usuario restaurado
        $user->update([
            'name' => $request->name,
            'username' => $request->email,
            'document' => $request->document,
            'charge' => $request->charge,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'business_id' => $request->business_id,
            'status' => 1,
        ]);
        
        // Asignar el rol correspondiente
        $user->syncRoles([6]);

        // Devolver respuesta indicando que se restauró un usuario
        
    } else {
        // Si el usuario no existe, creamos uno nuevo
        $user = User::create([
            'name' => $request->name,
            'username' => $request->email,
            'document' => $request->document,
            'charge' => $request->charge,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'business_id' => $request->business_id,
            'status' => 1,
        ]);

        // Asignar el rol correspondiente
        $user->assignRole(6);

      
    }
    $user->contrasena=$request->password;

    Mail::send('admin/business/emailcreateuser', ['user' => $user], function($message) use ($user){
        $message->to($user->email, $user->name);
        $message->subject('Se ha creado una nueva cuenta en Kanbai');
        $message->from('ventas@kanbai.co','Kanbai');
   });

    return response()->json(['restored' => true]);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function show(Banners $banners)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $busine = Business::with('departaments','cities','users')->find(\Hashids::decode($id)[0]);
        $departments = Departaments::all();

        $usuariosempresa=User::where('business_id',$busine->id)->get();
        $relacionEloquent = 'roles';
        $users = User::whereHas($relacionEloquent, function ($query) {
                return $query->where('name', '=', 'Asesor');
        })->get();
        return view('admin.business.edit', ['busine' => $busine,'departments'=>$departments,'users'=>$users,'usuariosempresa'=>$usuariosempresa]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $business = Business::find($request->id);
        
        $business->company_name = $request->company_name;
        $business->nit = $request->nit;
        $business->billing_email = $request->billing_email;
        $business->address = $request->address;
        $business->department_id = $request->department_id;
        $business->city_id = $request->city_id;
        $business->user_id= $request->user_id;
        $business->term=$request->term;
        $business->save();

        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect_url' => route('login') // Redirect URL after successful registration
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $busine=business::find(\Hashids::decode($id)[0]);
        $busine->state=0;
        $busine->save();

        $users=User::where('business_id',$busine->id)->get();
        foreach($users as $item){
            $user=User::find($item->id);
            $user->status=0;
            $user->save();
        }
        //business::find($busine->id)->delete();

        return json_encode(['success' => true]);
    }

    public function edituser($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function updateuser(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'document' => 'required|string|max:20',
        'charge' => 'required|string|max:50',
        'phone' => 'nullable|string|max:20',
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'password' => 'nullable|min:6',
    ]);

    $user = User::findOrFail($id);
    $user->update(array_filter($validated, fn ($val) => $val !== null && $val !== ''));

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
        $user->save();
    }

    return response()->json(['message' => 'Usuario actualizado correctamente.']);
}
}
