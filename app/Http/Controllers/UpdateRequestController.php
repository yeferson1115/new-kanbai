<?php

namespace App\Http\Controllers;

use App\Models\UpdateRequest;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Intervention\Image\Facades\Image;


class UpdateRequestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'vendedor_id' => 'required|exists:users,id',
            'correo_vendedor' => 'required|email',            
            'fecha_limite' => 'required|date',
        ]);

        // Obtener el ID real del proyecto
        $project = Projects::with('timeline', 'productos', 'comercio')->where('id',\Hashids::decode($validated['project_id'])[0] )->first();
        
        $updateRequest = UpdateRequest::create([
            'project_id' => $project->id,
            'vendedor_id' => $validated['vendedor_id'],
            'correo_vendedor' => $validated['correo_vendedor'],            
            'fecha_limite' => $validated['fecha_limite'],
            'estado' => 'pendiente',
        ]);

        // Aquí puedes agregar lógica para enviar correo al vendedor
        // Mail::to($validated['correo_vendedor'])->send(new UpdateRequestMail($updateRequest));
        
        Mail::send('site.projects.templatesolicitudupdate', [
            'project' => $project,            
            'data' => $updateRequest
        ], function ($message) use ($updateRequest) {
            $message->to($updateRequest->correo_vendedor,)
                ->subject('Solicitud update proyecto No.' . $updateRequest->id)
                ->from('ventas@kanbai.co', 'Kanbai');
        });

        return response()->json([
            'success' => true,
            'message' => 'Solicitud de update enviada correctamente',
            'data' => $updateRequest,
            'uid' => $updateRequest->uid
        ]);
    }


    public function solicitudupdate($uid)
    {       
        
        $updateRequest = UpdateRequest::with('project')
            ->where('uid', $uid)
            //->where('estado', 'pendiente')
            ->first();
            if (!$updateRequest) {
                abort(404, 'Solicitud no encontrada');
            }
            if ($updateRequest->estado === 'completado') {
                return view('site.projects.solicitud-update', [
                    'updateRequest' => $updateRequest,
                    'project' => $updateRequest->project,
                    'mostrarCronometro' => false,
                    'tiempoRestante' => null,
                    'tiempoExpirado' => false,
                    'uid' => $uid
                ]);
            }
        
        // Calcular tiempo restante
        $ahora = now();
        
        $fechaLimite = \Carbon\Carbon::parse($updateRequest->fecha_limite);
        $tiempoRestante = null;
        $mostrarCronometro = false;
        $tiempoExpirado = false;

        if ($fechaLimite->greaterThan($ahora)) {
            $mostrarCronometro = true;
            $tiempoRestante = $ahora->diffInSeconds($fechaLimite, false);
        } else {
            // Si el tiempo ya expiró, marcar como vencido
            $updateRequest->estado = 'vencido';
            $updateRequest->save();
            $tiempoExpirado = true;
        }

        return view('site.projects.solicitud-update', [
            'updateRequest' => $updateRequest,
            'project' => $updateRequest->project,
            'mostrarCronometro' => $mostrarCronometro,
            'tiempoRestante' => $tiempoRestante,
            'tiempoExpirado' => $tiempoExpirado,
            'uid' => $uid
        ]);
    }

    /**
     * Guardar la respuesta desde la vista pública
     */
    public function storeSolicitudUpdate(Request $request, $uid)
{
    $validated = $request->validate([
        'descripcion' => 'required|string|min:10',
        'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    $updateRequest = UpdateRequest::with(['project'])
        ->where('uid', $uid)
        ->where('estado', 'pendiente')
        ->firstOrFail();

    // Verificar que no haya expirado
    if (now()->greaterThan($updateRequest->fecha_limite)) {
        return back()->with('error', 'El tiempo para responder ha expirado.');
    }

    $project = $updateRequest->project;
    $projectId = $project->id;

    // Procesar imágenes
    $images = $request->file('imagenes');
    $imageNames = [];

    if ($images) {
        // Si viene una sola imagen, la convertimos en array para tratar igual que múltiples
        if (!is_array($images)) {
            $images = [$images];
        }

        foreach ($images as $image) {
            if ($image->isValid()) {
                $imagen = Image::make($image);
                $imageName = time() . '_' . $image->getClientOriginalName();
                
                // Redimensionar y guardar la imagen
                $imagen->resize(500, 500, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(public_path('images/projects/' . $imageName));

                $imageNames[] = $imageName;
            }
        }
    }



    // También guardar en ProjectUpdates si existe esa tabla
    if (class_exists('App\Models\ProjectUpdates')) {
        \App\Models\ProjectUpdates::create([
            'project_id' => $projectId,
            'description' => $validated['descripcion'],
            'file' => isset($imageNames[0]) ? $imageNames[0] : null
        ]);
    }

    // Marcar la solicitud como completada
    $updateRequest->estado = 'completado';
    $updateRequest->save();

    // Calcular total del proyecto
    $total = 0;
    if ($project->productos) {
        foreach ($project->productos as $item) {
            $total += ($item->price * $item->quantity);
        }
    }

    // Preparar datos para el correo
    $newdata = [
        'description' => $validated['descripcion'],
        'vendedor' => $updateRequest->correo_vendedor,
        'fecha_limite' => $updateRequest->fecha_limite,
        'uid' => $updateRequest->uid
    ];

    // Enviar correo con adjuntos
    try {
        /*Mail::send('site.projects.templateprojectupdate', [
            'project' => $project,
            'total' => $total,
            'data' => $newdata,
            'updateRequest' => $updateRequest
        ], function ($message) use ($project, $imageNames, $updateRequest) {
            $message->to($project->email_customer ?? 'ventas@kanbai.co', $project->customer ?? 'Cliente Kanbai')
                ->subject('Update del Proyecto No. ' . $project->id . ' - ' . $updateRequest->uid)
                ->from('ventas@kanbai.co', 'Kanbai')
                ->replyTo($updateRequest->correo_vendedor, 'Vendedor');

            // Adjuntar todas las imágenes
            foreach ($imageNames as $name) {
                $message->attach(public_path('images/projects/' . $name));
            }
        });*/

        // También enviar notificación al vendedor si es necesario
        if ($updateRequest->correo_vendedor != $project->email_customer) {
            /*Mail::send('site.projects.templateupdateconfirmation', [
                'project' => $project,
                'updateRequest' => $updateRequest,
                'descripcion' => $validated['descripcion']
            ], function ($message) use ($updateRequest, $project) {
                $message->to($updateRequest->correo_vendedor)
                    ->subject('Confirmación - Update enviado para Proyecto #' . $project->id)
                    ->from('ventas@kanbai.co', 'Kanbai');
            });*/
        }

    } catch (\Exception $e) {
        // Log del error pero continuar con el proceso
        \Log::error('Error al enviar correo: ' . $e->getMessage());
    }

    // Redireccionar con mensaje de éxito
    return back()->with('success', '¡Update enviado exitosamente! Se ha notificado al cliente.');
}
}