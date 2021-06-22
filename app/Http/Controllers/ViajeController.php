<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Requests\ViajeUpdateRequest;
use App\Models\Viaje;
use App\Services\ResponseViaje;
use Exception;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    public function __construct(ResponseViaje $responseViaje)
    {
        $this->responseViaje = $responseViaje;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->expectsJson()) {
            return $this->responseViaje->index();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            if (request()->hasFile('file')) {

                $xmlString = file_get_contents(request()->file('file'));
                $xmlObject = simplexml_load_string($xmlString);
                $json = json_encode($xmlObject);
                $phpArray = json_decode($json, true);

                foreach ($phpArray['viaje'] as $item) {
                    $item['fecha'] = Date($item['fecha']);
                    $id_cleinte = (Cliente::firstWhere('email', $item['email']))['id'];
                    if (!$id_cleinte) {
                        throw new Exception("Error Processing Request", 400);
                    }
                    $item['cliente_id'] =  $id_cleinte;
                    Viaje::create($item);
                }
                return response()->json('Viaje actualizado correctamente', 200);
            }
        } catch (\Throwable $th) {
            return response()->json('No se pudo realizar la operacion', 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Transportes\Viaje  $viaje
     * @return \Illuminate\Http\Response
     */
    public function show($cliente)
    {
        if (request()->expectsJson()) {
            return $this->responseViaje->viajesByCliente($cliente);
        }
        return view('viajes.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ViajeUpdateRequest $request)
    {
        if (request()->expectsJson()) {
            try {
                $viaje = Viaje::findOrFail($request->id);
                $viaje->update(request()->all());
                return response()->json('Viaje actualizado correctamente', 200);
            } catch (\Throwable $th) {
                return  response()->json($th->getMessage(), 400);
            }
        }
        return abort(404);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Transportes\Viaje  $viaje
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->expectsJson()) {
            try {
                $viaje = Viaje::findOrFail($id);
                $viaje->delete();
                return response()->json('Viaje eliminado correctamente.');
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 400);
            }
        }
        return abort(404);
    }
}
