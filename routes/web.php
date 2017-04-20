<?php

use App\Cita;
use App\Estilista;
use Carbon\Carbon;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/galeria', function () {
    return view('galeria');
});

Route::get('/staff', function () {
    return view('staff');
});

Route::get('/servicios', function () {
    return view('servicios');
});

Route::get('/contacto', function () {
    return view('contacto');
});

Route::get('/contador', function () {
    return view('contador');
});

Route::get('/disponibilidad', function(){
    $llegada = Carbon::createFromFormat('m/d/Y H:i:s',Input::get('llegada') . '00:00:00');
    $salida = Carbon::createFromFormat('m/d/Y H:i:s',Input::get('salida') . '00:00:00');
    $cabana_type = Input::get('cabana_type');

    $num_cabanas = Estilista::where('tipo', $cabana_type)->count();

    $reservaciones = Cita::whereBetween('fecha_llegada', [$llegada, $salida])->orWhereBetween('fecha_salida', [$llegada, $salida])->get();

    $reservaciones = $reservaciones->filter(function($reservacion, $key) use ($cabana_type){
        return $reservacion->getOriginal('tipo') == $cabana_type ? $reservacion : null;
    });

    $disponibilidad = $reservaciones->count() >= $num_cabanas ? false : true;

    return response()->json($disponibilidad, 200);
});

Route::post('/reservar', function(Request $request){
    $llegada = Carbon::createFromFormat('m/d/Y H:i:s', $request->fecha_llegada . '00:00:00');
    $salida = Carbon::createFromFormat('m/d/Y H:i:s', $request->fecha_salida . '00:00:00');
    $request['fecha_llegada'] = $llegada;
    $request['fecha_salida'] = $salida;

    Cita::create($request->all());

    //Send email to administrator
    Mail::to('kuamatzin@gmail.com')->send(new NuevaCitaAdministradorEmail($request->all()));
    Mail::to('contacto@entradaalasierra.com')->send(new NuevaCitaAdministradorEmail($request->all()));

    //Send email to contact
    Mail::to($request->email)->send(new CitaEmail($request->all()));

    return response()->json(true, 200);
});

Route::post('/reservar/{id}/edit', function(Request $request){
    $reservacion = Cita::findOrFail($request->id);
    $reservacion->anticipo = $request->anticipo;
    $reservacion->save();

    return redirect()->back();
});

Route::delete('/reservar', function(Request $request){
    Cita::destroy($request->id);

    return redirect('admin');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
