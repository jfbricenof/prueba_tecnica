<?php

namespace App\Http\Controllers;

use App\Asesor;
use Illuminate\Http\Request;

class AsesorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return Asesor::where('user_id', auth()->id())->get();
        }else{
            return view('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $asesor = new Asesor();
        $asesor->nombre = $request->nombre;
        $asesor->cedula = $request->cedula;
        $asesor->telefono = $request->telefono;
        $asesor->edad = $request->edad;
        $asesor->genero = $request->genero;
        $asesor->cliente = $request->cliente;
        $asesor->sede = $request->sede;
        $asesor->user_id = auth()->id();
        $asesor->save();

        return $asesor;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $asesor = Asesor::find($id);
        $asesor->nombre = $request->nombre;
        $asesor->cedula = $request->cedula;
        $asesor->telefono = $request->telefono;
        $asesor->edad = $request->edad;
        $asesor->genero = $request->genero;
        $asesor->cliente = $request->cliente;
        $asesor->sede = $request->sede;
        $asesor->save();
        return $asesor;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asesor = Asesor::find($id);
        $asesor->delete();
    }
}
