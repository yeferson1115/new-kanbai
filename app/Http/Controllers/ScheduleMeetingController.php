<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Log\LogSistema;
use App\Models\ScheduleMeeting;


use Illuminate\Support\Str;


use Mail;
set_time_limit(300);

class ScheduleMeetingController extends Controller
{
    
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $reunion = ScheduleMeeting::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'organization'=>$request->organization                                
            ]);
            $data = array(
                'name'=>$request->name,
                'email'=>$request->email,
                'phone'=>$request->phone,
                'organization'=>$request->organization,
            );
            Mail::send('site.mail.templateemail', $data, function($message) use ($reunion){
                $message->to('admin@almadelascosas.com', 'Solicitud de reunión');
                $message->subject('Solicitud de reunión No. '.$reunion->id);
                $message->from('ventas@kanbai.co','Kanbai');
           });

            return json_encode(['success' => true, 'id' => $reunion->encode_id]);
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
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      
    }
    
}
