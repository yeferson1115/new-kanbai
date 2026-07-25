<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Products;
use App\Models\Projects;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        if(auth()->user()->hasRole('Empresa')){
            return redirect()->to('/comercio');
         }
         if(auth()->user()->hasRole('Usuario')){
            return redirect()->to('/mi-perfil');
         }


        //dd(LogSistema::get());
        $date_current = Carbon::now()->toDateTimeString();

        $prev_date1 = $this->getPrevDate(1);
        $prev_date2 = $this->getPrevDate(2);
        $prev_date3 = $this->getPrevDate(3);
        $prev_date4 = $this->getPrevDate(4);

        //$prev_date12 = $this->getPrevDate(12);

        //dd($prev_date0);
        $emp_count_1  = User::whereBetween('created_at',[$prev_date1,$date_current])->count();
        $emp_count_2  = User::whereBetween('created_at',[$prev_date2,$prev_date1])->count();
        $emp_count_3  = User::whereBetween('created_at',[$prev_date3,$prev_date2])->count();
        $emp_count_4  = User::whereBetween('created_at',[$prev_date4,$prev_date3])->count();


        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado al home del sistema a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $products=null;
        $projects=null;
        $totalSum=0;
        if(auth()->user()->hasrole('Comercio')){
            $products = Products::where('user_id',auth()->user()->id)->where('state','!=',9)
            ->with('productcategories','productcategories.category')
            ->with('productsubcategories','productsubcategories.subcategory')->with('gallery','user')->count();   
            $projects = Projects::with('comercio')->where('seller_id',auth()->user()->id)->orderBy('created_at', 'desc')->count(); 
            $totalSum = Projects::where('seller_id', auth()->user()->id)->sum('total');
        
        }

        
        return view('admin.home.index', compact('emp_count_1',
                                                'emp_count_2',
                                                'emp_count_3',
                                                'emp_count_4',
                                                'products',
                                                'projects',
                                                'totalSum'
                                                ));
    }

    public function logs()
    {
        //dd(LogSistema::get());

        $logs= LogSistema::get();

        return view('admin.home.logs', compact('logs'));
    }

     private function getPrevDate($num){
        return Carbon::now()->subMonths($num)->toDateTimeString();
    }

    public function goBack()
    {
        return back(); 
    }

}
