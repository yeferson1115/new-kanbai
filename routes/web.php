<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeleConsultationController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SubCategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomRequestController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProfileBusinessController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\CartController;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Password;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::middleware(['auth',])->group(function () {

  Route::get('home', 'HomeController@index')->name('home');
  Route::resource('logins', 'LoginController');
  Route::resource('user', 'UserController');
   Route::post('/updateuser', [UserController::class, 'edituser'])->name('updateuser');
  Route::resource('permission', 'PermissionController');
  Route::get('logs', 'HomeController@logs')->name('logs');
  Route::resource('roles', 'RolesController');
  Route::resource('categories', 'CategoriesController');
  Route::post('/updatecategory', [CategoriesController::class, 'update'])->name('updatecategory');
  Route::resource('subcategories', 'SubcategoriesController');
  Route::resource('subcategoriesbanners', 'SubCategoriesBannersController'); 
  Route::post('/updatesubcategory', [SubCategoriesController::class, 'update'])->name('updatesubcategory');
  Route::resource('products', 'ProductsController');
  Route::post('/updateproduct', [ProductsController::class, 'update'])->name('updateproduct');
  Route::resource('productsgallery', 'ProductsGalleryController'); 
  Route::resource('categoriesbanner', 'CaregoriesBannersController'); 
  Route::resource('categoriesbannercommerce', 'CaregoriesBannersCommerceController');
  Route::resource('categoriesimagesattributes', 'CaregoriesImagesAttributesController');
  Route::resource('quotes', 'ProductQuotationController');
  Route::resource('comercio', 'ProfileBusinessController');
  Route::resource('mi-perfil', 'ProfileBusinessController');
  Route::get('mi-informacion', 'ProfileBusinessController@myinformation')->name('myinformation');
  Route::get('usuarios-empresa', 'ProfileBusinessController@usuarios')->name('usuarios');
  Route::get('pedidos-empresa', 'ProjectsController@pedidos')->name('pedidos');
  Route::get('pedidos-empresa/{id}', [ProjectsController::class, 'show'])->name('pedidosempresa.show');
  Route::get('metodos-de-pago', [PaymentMethodController::class, 'index'])->name('payment-methods.index');
  Route::get('metodos-de-pago/agregar', [PaymentMethodController::class, 'create'])->name('payment-methods.create');
  Route::get('metodos-de-pago/{paymentMethod}/editar', [PaymentMethodController::class, 'edit'])->name('payment-methods.edit');
  Route::post('metodos-de-pago', [PaymentMethodController::class, 'store'])->name('payment-methods.store');
  Route::put('metodos-de-pago/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('payment-methods.update');
  
  Route::get('usuariosempresa/{id}/edit', [ProfileBusinessController::class, 'edit'])->name('usuariosempresa.edit');
  Route::get('usuariosempresa/create', [ProfileBusinessController::class, 'create'])->name('usuariosempresa.create');
  Route::post('/usuarioempresaadd', [ProfileBusinessController::class, 'store'])->name('usuarioempresaadd');

  Route::get('/mis-solicitudes', 'ProfileBusinessController@myquotations');
  Route::post('/updateproyect', [ProjectsController::class, 'update'])->name('updateproyect');
  Route::post('/updatesproyect', [ProjectsController::class, 'updates'])->name('updatesproyect');
  Route::get('/mis-solicitudes/{id}', 'ProductQuotationController@show');
  Route::resource('asignar-asesor', 'CustomerUserController');
  Route::get('/templateproject', 'ProjectsController@templateupdate');
  
  Route::get('/templateQuotationVendor', 'ProductQuotationController@templateQuotationVendor');
  Route::get('/sorteo', 'LotteryController@indexadmin');
  Route::post('/updatesorteo', [LotteryController::class, 'update'])->name('updatesorteo');
  Route::post('/aprobar-producto', [ProductsController::class, 'aprobar'])->name('aprobar-producto');
  Route::post('/eliminar-producto', [ProductsController::class, 'eliminar'])->name('eliminar-producto');
  
  Route::get('projects', [ProjectsController::class, 'indexpanel'])->name('projects.index');
  Route::get('easygift', [ProjectsController::class, 'indexpanel'])->defaults('type', 'easygift')->name('easygift.index');

  // Agrega esta línea en tu archivo de rutas (web.php)
Route::get('/projects/export', [ProjectsController::class, 'exportProjects'])->name('projects.export');

  Route::resource('project', 'ProjectsController');
  Route::post('/envios', [ProjectsController::class, 'envios'])->name('envios.store');

  Route::get('project/{id}/manage', [ProjectsController::class, 'manage'])->name('project.manage');

  // POST que recibe la edición vía AJAX (método propio, no PUT)
  Route::post('project/update-ajax', [ProjectsController::class, 'updateAjax'])->name('updateproyect');

 
  Route::get('/project/chat/{id}', 'ProjectChatController@edit');
  Route::resource('projectchat', 'ProjectChatController');
  Route::get('/proyecto/chat/{id}', 'ProjectChatController@chatuser');

  Route::resource('customers', 'CustomersController');
  Route::resource('services', 'ServicesController');
  Route::resource('ordenes', 'OrdersController');
  Route::get('/solicitudes-crear-productos', 'ProductsController@aprovecreate');
  Route::get('/solicitudes-eliminar-productos', 'ProductsController@deleteproduct');
  Route::resource('empresas', 'BusinessController');
  Route::put('/update-empresa', [BusinessController::class, 'update'])->name('update-empresa');
  


  Route::resource('typequote', 'TypeQuoteController');
  Route::resource('quotation', 'QuotationController');
  Route::post('/aprobarsolicitud', [CustomRequestController::class, 'update'])->name('aprobarsolicitud');
  Route::resource('banners', 'BannersController');
  Route::resource('extras', 'ExtrasController');
  Route::resource('novedades', 'NewsController');
  Route::post('/updatenew', [NewsController::class, 'update'])->name('updatenew');

  Route::post('/updatebanner', [BannersController::class, 'update'])->name('updatebanner');

  Route::post('/usuarios', [BusinessController::class, 'storeuser'])->name('usuarios.storeuser');

  Route::get('/usuarios/{id}/edit', [BusinessController::class, 'edituser']);
  Route::put('/usuarios/{id}', [BusinessController::class, 'updateuser']);
  Route::post('/send-password/{id}', function ($id) {
    $user = \App\Models\User::findOrFail($id);

    // Generar manualmente un token de reseteo
    $token = app('auth.password.broker')->createToken($user);

    // Enviar la notificación personalizada
    $user->notify(new CustomResetPasswordNotification($token));

    return response()->json(['message' => 'El enlace de restablecimiento fue enviado a ' . $user->email]);
  });

  Route::post('/pedir-ahora', [ProductsController::class, 'easybuy'])->name('cart.pedir');

Route::get('carrito/secondary', [CartController::class, 'secondary'])->name('carrito.secondary');
Route::post('carrito/easybuy', [CartController::class, 'storeeasybuy'])->name('carrito.easybuy');

  Route::resource('checkoutpayment',   'PaymentController');


  Route::get('/api/products/{id}', function($id) {
    $product = \App\Models\Products::with('gallery')->findOrFail($id);
    return response()->json([
        'id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'image' => $product->gallery->count() > 0 ? $product->gallery[0]->file : null
    ]);
});


Route::post('/solicitar-update', [App\Http\Controllers\UpdateRequestController::class, 'store'])
    ->name('solicitar-update.store');
// En routes/web.php
Route::post('/update-request/vencido', [App\Http\Controllers\UpdateRequestController::class, 'marcarVencido'])
    ->name('update-request.vencido');
Route::get('solicitud-de-update-proyecto/{uid}', [App\Http\Controllers\UpdateRequestController::class, 'solicitudupdate'])->name('update.solicitudupdate');

Route::post('solicitud-de-update/{uid}', [App\Http\Controllers\UpdateRequestController::class, 'storeSolicitudupdate'])
    ->name('update.solicitudupdate.store');

});

Route::get('/templateemail', 'CartController@templateEmail');

Route::get('/catalogo/cotizacion/porducto/{productoid}', 'ProductsController@quotation');
Route::resource('cotizacion', 'ProductQuotationController');
Route::get('ver-cotizacion/{uid}', 'ProductQuotationController@vercotizacion');
Route::get('solicituded-personalizadas', 'CustomRequestController@indexpanel');
Route::resource('solicitud-personalizada', 'CustomRequestController'); 

Route::get('/', 'HomeaplicationController@index')->name('home');
Route::get('/catalogo/{category}/{bubcategory}', 'ProductsController@productsBySubCategory');
Route::get('/catalogo/{category}', 'ProductsController@productsByCategory');

Route::get('/catalogo/producto/{productoid}/{nameproduct}', 'ProductsController@productsByid');

Route::get('/buscar/{search}', 'ProductsController@serachproduct')->name('serachproduct');
Route::get('/search/ajax', [ProductsController::class, 'searchAjax'])->name('search.ajax');




Route::get('customers/cities/{departament}', 'CustomersController@cities');
Route::get('/registro', 'CustomersController@register')->name('registro');
Route::post('registercustomer', 'CustomersController@registercustomer')->name('registercustomer');
Route::post('/validaremail', 'CustomersController@validaremail')->name('validaremail');
Route::post('/cart-add',    'ProductsController@add')->name('cart.add');
Route::post('/mobile-cart-add',    'ProductsController@addmobile')->name('cartmobile.add');
Route::get('/carrito','CartController@index');
Route::post('/actualizar-carrrito',    'CartController@updatecart')->name('carrrito.update');
Route::get('/carrito/checkout','CartController@pay');
Route::resource('/carrito','CartController');
Route::post('/get-price',    'ProductsController@getprice')->name('getprice');
Route::post('/eliminar-item',  'CartController@removeitemadmin')->name('carrito.remove');
Route::resource('inscripcion-sorteo', 'LotteryController');
Route::resource('agendar-reunion', 'ScheduleMeetingController');

Route::get('/estado-orden/{idorder}', 'OrdersController@show');

Route::get('/mis-proyectos/{id}', 'ProfileBusinessController@myprojects')->name('mis-proyectos.show');
Route::get('/rastrea-tu-proyecto', 'TrackProjectsController@index');
Route::post('/validar-rastreo',  'TrackProjectsController@validateproject')->name('rastreo.validar');
Route::get('cities/{departament}', 'CustomersController@cities');

Route::post('register-ajax', [RegisterController::class, 'registerAjax']);

Route::get('/go-back', 'HomeController@goBack')->name('go.back');

Route::get('/agradecimiento', function () {
    return view('site.agradecimiento'); // resources/views/gracias.blade.php
})->name('agradecimiento');
/**Borrar cache */
Route::get('/clear-cache', function () {
  echo Artisan::call('config:clear');
  echo Artisan::call('config:cache');
  echo Artisan::call('cache:clear');
  echo Artisan::call('route:clear');
  echo Artisan::call('view:clear');
});

Route::get('/terminos-y-condiciones', function () {
    return view('site.terminos');
})->name('terminos');
Route::get('/politica-de-privacidad', function () {
    return view('site.privacidad');
})->name('privacidad');

Route::get('/plantilla', function () {
  return view('admin/business/emailcreateuser');
});
