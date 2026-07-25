<?php

namespace App\Http\Controllers;

use App\Models\Banners;
use Illuminate\Http\Request;
use App\Models\Log\LogSistema;

class BannersController extends Controller
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
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver las publicidades: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $banners = Banners::get();
        return view ('admin.banners.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageNamedesk = time().'.'.$request->imagedesk->extension();
        $request->imagedesk->move(public_path('images/banners/desktop/'), $imageNamedesk);

        $imageNamemobile = time().'.'.$request->imagemobile->extension();
        $request->imagemobile->move(public_path('images/banners/mobile/'), $imageNamemobile);
       
       
        $banners = Banners::create([
                'imagedesk'=>$imageNamedesk,
                'imagemobile'=>$imageNamemobile,
                'url'=>$request->url
        ]);

        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha guardado un nuevo banner en el sistema: '.$banners->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true, 'id' => $banners->encode_id]);
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
        $banner = Banners::find(\Hashids::decode($id)[0]);
       
        

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos del banner: '.$banner->id.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        return view('admin.banners.edit', ['banner' => $banner]);
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
        
        $banner = Banners::find(\Hashids::decode($request->id)[0]);
        if ($request->file('imagedesk')) {
            $imageNamedesk = time().'.'.$request->imagedesk->extension();
            $request->imagedesk->move(public_path('images/banners/desktop/'), $imageNamedesk);

            $image_path = public_path().'/images/banners/desktop/'.$banner->imagedesk;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $banner->imagedesk = $imageNamedesk;

        }

        if ($request->file('imagemobile')) {
            $imageNamemobile = time().'.'.$request->imagemobile->extension();
            $request->imagemobile->move(public_path('images/banners/mobile/'), $imageNamemobile);

            $image_path = public_path().'/images/banners/mobile/'.$banner->imagemobile;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $banner->imagemobile = $imageNamemobile;

        }

        $banner->url_desk=$request->url_desk;
        $banner->url_mobile=$request->url_mobile;
        $banner->save();

        return json_encode(['success' => true, 'customer_id' => $banner->encode_id]);


       
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banners  $banners
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $banner=Banners::find(\Hashids::decode($id)[0]);

        $image_path = public_path().'/images/banners/desktop/'.$banner->imagedesk;
        if (@getimagesize($image_path)) {
            unlink($image_path);
        }
        $image_path1 = public_path().'/images/banners/mobile/'.$banner->imagemobile;
        if (@getimagesize($image_path1)) {
            unlink($image_path1);
        }
        Banners::find($banner->id)->delete();

        return json_encode(['success' => true]);
    }
}
