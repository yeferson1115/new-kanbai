<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Departaments;
use App\Models\Business;
use Illuminate\Http\Request;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $departments = Departaments::all();
        return view('auth.register', compact('departments'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'company_name' => ['required', 'string', 'max:255'],
            'nit' => ['required', 'string', 'max:20'],
            'billing_email' => ['required', 'string', 'email', 'max:255'], 
            'address' => ['required', 'string', 'max:255'],
            'department_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'name.*' => ['required', 'string', 'max:255'],
            'document.*' => ['required', 'string', 'max:20'],
            'charge.*' => ['required', 'string', 'max:50'],
            'phone.*' => ['required', 'string', 'max:20'],
            'email.*' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password.*' => ['required', 'string', 'min:8'], // Validate password and confirmation for each user
            'password_confirmation.*' => ['required', 'string', 'min:8'],
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(Request $request)
    {
        
        $business = Business::create([
            'company_name' => $request->company_name,
            'nit' => $request->nit,
            'billing_email' => $request->billing_email,
            'address' => $request->address,
            'department_id' => $request->department_id,
            'city_id' => $request->city_id
        ]);
    
        // Crear usuarios
        foreach ($request->input('email') as $key => $email) {
            $user=User::create([
                'name' => $request->input('name')[$key],
                'email' => $email,
                'username' => $email,
                'password' => Hash::make($request->input('password')[$key]),
                'genero' => null,
                'phone'=> $request->input('phone')[$key],
                'charge'=> $request->input('charge')[$key],
                'status'=>1,
                'business_id' => $business->id, // Asignar el ID del negocio
                // Otros campos necesarios
            ]);
            $user->assignRole(6);
        }
        
        return $user;
    }

     /**
     * Handle the registration request via AJAX.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerAjax(Request $request)
    {
        // Validate the data
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);  // 422 for validation errors
        }

        // Create the user
        $user = $this->create($request);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Registration successful!',
            'redirect_url' => route('login') // Redirect URL after successful registration
        ]);
    }
}
