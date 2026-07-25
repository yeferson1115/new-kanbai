<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Departaments;
use Illuminate\Http\Request;
use App\Http\Requests\V1\PostRequest;
use Illuminate\Support\Facades\Auth;

class DepartamentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Departaments  $departaments
     * @return \Illuminate\Http\Response
     */
    public function show(Departaments $departaments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Departaments  $departaments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departaments $departaments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Departaments  $departaments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departaments $departaments)
    {
        //
    }
}
