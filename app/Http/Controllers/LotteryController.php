<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\Lottery;


use Illuminate\Support\Str;

use Image;

class LotteryController extends Controller
{
    public function __construct()
    {        
        $this->middleware('permission:Ver Participantes')->only('indexadmin');
        $this->middleware('permission:Editar Participantes')->only('update');
        $this->middleware('permission:Editar Participantes')->only('edit');
        $this->middleware('permission:Eliminar Participantes')->only('destroy');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexadmin()
    {
        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los particioantes: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $categories = Lottery::get();
        return view ('admin.lottery.index',compact('categories'));
    }

    public function index()
    {
        return view ('site.lottery.create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                    'document' => ['required', 'string', 'unique:Lottery'],
                    'email' => ['required', 'string', 'email', 'max:255', 'unique:Lottery'],                        
            ],[
                'document.unique'=>'El número de identificación ya se encuentra registrado',
                'email.unique'=>'El E-mail ya se encuentra registrado'
            ]);
            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images/lottery'), $imageName);        
        
            $lottery = Lottery::create([
                    'name'=>$request->name,
                    'file'=>$imageName,
                    'email'=>$request->email,
                    'document'=>$request->document,
                    'phone'=>$request->phone,
                    'organization'=>$request->organization,
                    'state'=>1,
                                    
                ]);

            return json_encode(['success' => true, 'id' => $lottery->encode_id]);
        }catch (exception $e) {
            
        }
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
        $lottery = Lottery::find(\Hashids::decode($id)[0]);

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos del sorteo: '.$lottery->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        return view('admin.lottery.edit', ['lottery' => $lottery]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $lottery = Lottery::find(\Hashids::decode($request->id)[0]);       
        $lottery->state=$request->state;
        $lottery->save();

        return json_encode(['success' => true, 'customer_id' => $lottery->encode_id]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lottery = Lottery::find(\Hashids::decode($id)[0]);
        $image_path = public_path().'/images/lottery/'.$lottery->file;
        if (@getimagesize($image_path)) {
            unlink($image_path);
        }
        
        Lottery::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
    
}
