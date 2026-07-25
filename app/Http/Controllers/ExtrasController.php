<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\ProductsExtra;
use App\Models\ProductsExtrasItems;
use App\Models\ProductsExtrasItemsValues;


use Illuminate\Support\Str;

use Image;

class ExtrasController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
public function store(Request $request)
{
    // 1. Guardar EXTRA PRINCIPAL
    $extra = ProductsExtra::create([
        'name' => $request->display_name,
        'state' => 1,
        'product_id' => $request->product_id,
    ]);

    // 2. Procesar cada extra con sus valores
    if (isset($request->name_extra)) {

        foreach ($request->name_extra as $index => $extraName) {

            // Crear item principal (nombre del extra)
            $item = ProductsExtrasItems::create([
                'name' => $extraName,
                'product_extra_id' => $extra->id
            ]);

            // El nombre del contenedor en el form
            $key = "extra_" . ($index + 1);

            if (isset($request->qty_min[$key])) {

                foreach ($request->qty_min[$key] as $k => $qtyMin) {

                    ProductsExtrasItemsValues::create([
                        'products_extras_items_id' => $item->id,
                        'qty_min'  => $qtyMin,
                        'qty_max'  => $request->qty_max[$key][$k] ?? null,
                        'price'    => $request->price_extra[$key][$k] ?? 0,
                    ]);
                }
            }
        }
    }

    // 3. LOG
    

    // 4. Devuelvo el extra con todo cargado
    $extraguardado = ProductsExtra::with('items.values')->find($extra->id);

    return response()->json([
        'success' => true,
        'extra' => $extraguardado
    ]);
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
        $category = Categories::with('banners')->find(\Hashids::decode($id)[0]);

        $log = new LogSistema();
        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a editar los datos de la categoría: '.$category->display_name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        return view('admin.categories.edit', ['category' => $category]);
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
        
        $category = Categories::find(\Hashids::decode($request->id)[0]);
        if ($request->file('file')) {
            $imageName = time().'.'.$request->file->extension();
            $request->file->move(public_path('images/categories'), $imageName);

            $image_path = public_path().'/images/categories/'.$category->file;
            if (@getimagesize($image_path)) {
                unlink($image_path);
            }
            $category->file = $imageName;

        }
        if($request->file('banners')){
            $links=$request->links;
            foreach($request->file('banners') as $key=>$image){
                $nametem=Str::random(7);
                $imageName = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/banners/' . $imageName));
               
                $banners = CaregoriesBanners::create([
                    'file'=>$imageName,
                    'category_id'=>\Hashids::decode($request->id)[0],
                    'url'=>$links[$key],
                    'type'=>1                               
                ]); 
            }

        }

        if($request->file('bannersmobile')){
            $links=$request->linksmobile;
            foreach($request->file('bannersmobile') as $key=>$image){
                $nametem=Str::random(7);
                $imageName = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/banners/' . $imageName));
               
                $banners = CaregoriesBanners::create([
                    'file'=>$imageName,
                    'category_id'=>\Hashids::decode($request->id)[0],
                    'url'=>$links[$key],
                    'type'=>2                               
                ]); 
            }

        }
        $url=strtolower($request->name);
        $url=str_replace(" ", "-", $url);
        $category->name=$request->name;   
        $category->slug=$url; 
        $category->state=$request->state;   
        $category->is_menu=$request->is_menu;    
        $category->save();

        return json_encode(['success' => true, 'customer_id' => $category->encode_id]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Categories::find(\Hashids::decode($id)[0]);
        $image_path = public_path().'/images/categories/'.$category->file;
        if (@getimagesize($image_path)) {
            unlink($image_path);
        }

        
        ProductsCategories::where('category_id',$category->id)->delete();
        $subcategory=SubCategories::where('category_id',$category->id)->first();
        ProductsSubcategories::where('subcategory_id',$subcategory->id)->delete();
        SubCategories::where('category_id',$category->id)->delete();
        Categories::find(\Hashids::decode($id)[0])->delete();

        return json_encode(['success' => true]);
    }
    
}
