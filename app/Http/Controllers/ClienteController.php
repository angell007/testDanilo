<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Http\Requests\ClienteSaveRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Services\ResponseCliente;
use Exception;
use Illuminate\Support\Facades\File;


class ClienteController extends Controller
{
    public function __construct(ResponseCliente $responseCliente)
    {
        $this->responseCliente = $responseCliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->expectsJson()) {
            return $this->responseCliente->index(request());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteSaveRequest $request)
    {
        if (request()->expectsJson()) {

            try {
                $cliente = Cliente::create(request()->all());
                if ($request->file('file')) {
                    $filename = '_' . time() . '.' . $request->file('file')->getClientOriginalExtension();
                    $request->file('file')->move(public_path() . "/img_perfiles", $filename);
                    $cliente->foto = $filename;
                    $cliente->save();
                }
                return response('Registrado exitosamente', 200);
            } catch (\Throwable $th) {
                return response($th->getMessage());
            }
        }
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Transportes\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        if (request()->expectsJson()) {
            return response($cliente);
        }
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteUpdateRequest $request)
    {

        if (request()->expectsJson()) {
            try {
                $cliente = Cliente::findOrFail($request->id);
                $cliente->update(request()->all());
                return response()->json('Cliente actualizado correctamente', 200);
            } catch (\Throwable $th) {
                return  response()->json($th->getMessage(), 400);
            }
        }
        return abort(404);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \Transportes\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (request()->expectsJson()) {
            try {
                $cliente = Cliente::findOrFail($id);
                $cliente->viajes()->delete();
                File::delete(public_path('/img_perfiles/' . $cliente->foto));
                $cliente->delete();
                return response()->json('Cliente eliminado correctamente.');
            } catch (\Throwable $th) {
                return response()->json($th->getMessage(), 400);
            }
        }
        return abort(404);
    }
}
