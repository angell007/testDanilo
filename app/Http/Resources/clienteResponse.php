<?php

namespace App\Http\Resources;

use App\Cliente;
use App\Equipo;
use App\Estado;
use App\Marca;
use App\Modo;
use App\Producto;
use App\Razon;
use App\Reparacion;
use App\Tipo;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class clienteResponse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toResponse($request)
    {
        return  Cliente::toBase()->get();
    }
}
