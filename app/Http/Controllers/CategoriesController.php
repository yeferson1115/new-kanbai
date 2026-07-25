<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\Categories;
use App\Models\SubCategories;
use App\Models\CaregoriesBanners;
use App\Models\ProductsCategories;
use App\Models\ProductsSubcategories;
use App\Models\CaregoriesCommercialBanners;
use App\Models\CaregoriesImagesAttributes;

use Illuminate\Support\Str;

use Image;

class CategoriesController extends Controller
{

    public function __construct()
    {        
        $this->middleware('permission:Ver Categorías')->only('index');
        $this->middleware('permission:Crear Categoría')->only('create');
        $this->middleware('permission:Crear Categoría')->only('store');
        $this->middleware('permission:Editar Categoría')->only('update');
        $this->middleware('permission:Editar Categoría')->only('edit');
        $this->middleware('permission:Eliminar Categoría')->only('destroy');
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
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha ingresado a ver los servicios: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();
        $categories = Categories::get();
        return view ('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imageName = time().'.'.$request->file->extension();
        $request->file->move(public_path('images/categories'), $imageName);
        $url=strtolower($request->name);
        $url=str_replace(" ", "-", $url);
       
        $Category = Categories::create([
                'name'=>$request->name,
                'file'=>$imageName,
                'slug'=>$url,
                'state'=>$request->state,
                'is_menu'=>$request->is_menu,
                                 
            ]);

            if($request->file('banners')){
                $links=$request->links;
                foreach($request->file('banners') as $key=>$image){
                    $nametem=Str::random(7);
                    $imageName = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                    $imagen = Image::make($image);
                    $imagen->save(public_path('images/categories/banners/' . $imageName));
                   
                    $banners = CaregoriesBanners::create([
                        'file'=>$imageName,
                        'category_id'=>$Category->id,
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
                        'category_id'=>$Category->id,
                        'url'=>$links[$key],
                        'type'=>2
                    ]);
                }
    
            }

            if($request->file('bannersp')){
                $linksp=$request->linksp;
                foreach($request->file('bannersp') as $key=>$image){
                    $nametem=Str::random(7);
                    $imageNamep = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                    $imagen = Image::make($image);
                    $imagen->save(public_path('images/categories/commerce/desk/' . $imageNamep));
                   
                    $banners = CaregoriesCommercialBanners::create([
                        'file'=>$imageNamep,
                        'category_id'=>$Category->id,
                        'url'=>$linksp[$key],
                        'type'=>1
                    ]); 
                }
    
            }
    
            if($request->file('bannersmobilep')){
                $linksmobilep=$request->linksmobilep;
                foreach($request->file('bannersmobilep') as $key=>$image){
                    $nametem=Str::random(7);
                    $imageNamep = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                    $imagen = Image::make($image);
                    $imagen->save(public_path('images/categories/commerce/mobile/' . $imageNamep));
                   
                    $banners = CaregoriesCommercialBanners::create([
                        'file'=>$imageNamep,
                        'category_id'=>$Category->id,
                        'url'=>$linksmobilep[$key],
                        'type'=>2
                    ]);
                }
    
            }

            if($request->file('atributo')){
                $title=$request->title;
                foreach($request->file('atributo') as $key=>$image){
                    $nametem=Str::random(7);
                    $imageNameat = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                    $imagen = Image::make($image);
                    $imagen->save(public_path('images/categories/attributes/' . $imageNameat));
                   
                    $banners = CaregoriesImagesAttributes::create([
                        'file'=>$imageNameat,
                        'category_id'=>$Category->id,
                        'title'=>$title[$key]
                    ]);
                }
    
            }
            

        $log = new LogSistema();

        $log->user_id = auth()->user()->id;
        $log->tx_descripcion = 'El usuario: '.auth()->user()->display_name.' Ha guardado una nueva categoría en el sistema: '.$request->name.' a las: '
        . date('H:m:i').' del día: '.date('d/m/Y');
        $log->save();

        return json_encode(['success' => true, 'id' => $Category->encode_id]);
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
        $category = Categories::with('banners','bannerscommerce','imagesattributes')->find(\Hashids::decode($id)[0]);
        

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

        if($request->file('bannersp')){
            $linksp=$request->linksp;
            foreach($request->file('bannersp') as $key=>$image){
                $nametem=Str::random(7);
                $imageNamep = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/commerce/desk/' . $imageNamep));
               
                $banners = CaregoriesCommercialBanners::create([
                    'file'=>$imageNamep,
                    'category_id'=>\Hashids::decode($request->id)[0],
                    'url'=>$linksp[$key],
                    'type'=>1
                ]); 
            }

        }

        if($request->file('bannersmobilep')){
            $linksmobilep=$request->linksmobilep;
            foreach($request->file('bannersmobilep') as $key=>$image){
                $nametem=Str::random(7);
                $imageNamep = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/commerce/mobile/' . $imageNamep));
               
                $banners = CaregoriesCommercialBanners::create([
                    'file'=>$imageNamep,
                    'category_id'=>\Hashids::decode($request->id)[0],
                    'url'=>$linksmobilep[$key],
                    'type'=>2
                ]);
            }

        }

        if($request->file('atributo')){
            $title=$request->title;
            foreach($request->file('atributo') as $key=>$image){
                $nametem=Str::random(7);
                $imageNameat = time().'_'.$nametem.'_'.$image->getClientOriginalName();
                $imagen = Image::make($image);
                $imagen->save(public_path('images/categories/attributes/' . $imageNameat));
               
                $banners = CaregoriesImagesAttributes::create([
                    'file'=>$imageNameat,
                    'category_id'=>\Hashids::decode($request->id)[0],
                    'title'=>$title[$key]
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
