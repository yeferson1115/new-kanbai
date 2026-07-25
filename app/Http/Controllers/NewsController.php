<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\News;


use Illuminate\Support\Str;

use Image;

class NewsController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Novedades')->only('index');
        $this->middleware('permission:Crear Novedades')->only('create');
        $this->middleware('permission:Crear Novedades')->only('store');
        $this->middleware('permission:Editar Novedades')->only('update');
        $this->middleware('permission:Editar Novedades')->only('edit');
        $this->middleware('permission:Eliminar Novedades')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver las novedades: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $news = News::get();
        return view ('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/news'), $imageName);
        
       
        $new = News::create([
                'title'=>$request->title,
                'image'=>$imageName,
                'description'=>$request->description,
                'link'=>$request->link,
                                 
            ]);  

        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha guardado una nueva novedad en el sistema: '.$new->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true, 'id' => $new->encode_id]);
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
        //dd('ddd');
        $new = News::find(\Hashids::decode($id)[0]);
        

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la novedad: '.$new->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        return view('admin.news.edit', ['new' => $new]);
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
        
        $new = News::find(\Hashids::decode($request->id)[0]);
        if ($request->file('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/news'), $imageName);

            $image_path = public_path().'/images/news/'.$new->image;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $new->file = $imageName;

        }
        


        $new->title=$request->title;
        $new->description=$request->description;
        $new->link=$request->link;
        $new->save();

        return json_encode(['success' => true, 'customer_id' => $new->encode_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $new = News::find(\Hashids::decode($id)[0]);
        $image_path = public_path().'/images/news/'.$new->image;
        if (@getimagesize($image_path)) {
            unlink($image_path);
        }

        
        News::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
    
}
