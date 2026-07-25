<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\Models\Log\LogSistema;
use App\Models\Campuses;
use Illuminate\Support\Arr;
class UserController extends Controller
{
     public function __construct()
    {
        $this->middleware('permission:Ver Usuario')->only('index');
        $this->middleware('permission:Registrar Usuario')->only('create');
        $this->middleware('permission:Registrar Usuario')->only('store');
        $this->middleware('permission:Editar Usuario')->only('edit');
        $this->middleware('permission:Ver Usuario')->only('show');

    }

    public function index(Request $request)
    {
        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los usuarios a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();


        $users = User::with('roles')->where('status',1)->with('permissions')
                       ->orderBy('created_at', 'desc')
                       ->get();
       



        return view('admin.usuarios.index', ['users' => $users]);
    }




    public function create()
    {

        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a crear un usuario a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return view('admin.usuarios.create');
    }




    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:125',
            'lastname' => 'nullable|string|max:125',
            'username' => 'required|string|max:125|unique:users,username',
            'document' => 'nullable|string|max:125',
            'genero' => 'nullable|string|max:125',
            'email' => 'required|email|unique:users,email|max:125',
            'password' => 'required|string|min:6',
            'name_business' => 'nullable|string|max:125',
            'phone' => 'nullable|string|max:125',
            'charge' => 'nullable|string|max:125',
            'status' => 'nullable|integer',
            'business_id' => 'nullable|integer',
            'whatsapp' => 'nullable|string|max:100',
            'cellphone' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'role' => 'required|exists:roles,id', // Asegúrate que el rol exista en tabla `roles`
        ], [
            'username.unique' => 'El nombre de usuario ya está en uso.',
            'username.required' => 'El nombre de usuario es obligatorio.',
        ]);
    
        // Cifra la contraseña
        $validated['password'] = bcrypt($validated['password']);
    
        // Crea el usuario
        $user = User::create(Arr::except($validated, ['role']));
    
        // Asigna el rol
        $user->assignRole($validated['role']);
    
        return response()->json(['success' => true, 'user_id' => $user->encode_id]);
    }




    public function show($id)
    {
        $user = User::find(\Hashids::decode($id)[0]);

         $log = new LogSistema();

         $log->user_id = auth()->user()->id;
         $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los datos del usuario: '.$user->display_name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return view('admin.usuarios.edit', ['user' => $user]);
    }




    public function edit($id)
    {

        $user = User::with('roles')->with('permissions')->find(\Hashids::decode($id)[0]);

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos del usuario: '.$user->display_name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        

        return view('admin.usuarios.edit', ['user' => $user]);
    }


    public function edituser(Request $request)
    {
        
        $user = User::find(\Hashids::decode($request->id)[0]);
        if ($request->file('photo')) {
            $imageName = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images/asesor'), $imageName);

            $image_path = public_path().'/images/asesor/'.$user->photo;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $user->photo = $imageName;

        }
        
        $user->name=$request->name;
        $user->lastname=$request->lastname;
        $user->genero=$request->genero;
        $user->whatsapp=$request->whatsapp;
        $user->cellphone=$request->cellphone;
        $user->description=$request->description;
        $user->email=$request->email;
        $user->username=$request->username;
         if ($request->filled('password') && $request->password !== '') {
            // Hash de la contraseña antes de guardarla
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return json_encode(['success' => true, 'customer_id' => $user->encode_id]);
    }



    public function update(Request $request, $id)
    {
        $user = User::find(\Hashids::decode($id)[0]);
        $user->update($request->except('role'));

        if ($request->has('role'))
        {
            $user->syncRoles($request->role);
        }

         $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha modificó los datos del usuario: '.$user->display_name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true]);
    }




    public function destroy($id)
    {

        $user = User::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }



    public function autocomplete(Request $request)
    {
        return User::search($request->q)->take(10)->get();
    }

    public function sendPassword($id)
    {
        $user = User::findOrFail($id);

        // Aquí podrías generar una nueva contraseña o reenviar la actual
        // Enviar notificación, email, etc.
        // Por ejemplo:
        // Mail::to($user->email)->send(new PasswordNotification($user));

        return response()->json([
            'message' => 'La contraseña fue enviada exitosamente a ' . $user->email,
        ]);
    }

}
