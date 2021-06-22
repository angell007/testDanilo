<?php

namespace App\Services;

use App\Cliente;
use App\Models\Viaje as ModelsViaje;
use App\Viaje;

class ResponseViaje
{

    public function index()
    {
        return datatables(ModelsViaje::latest())
            ->addColumn('action', function ($viaje) {
                $button =  '<div class="text-lg-right text-nowrap">';
                $button .=
                    '<a class="btn btn-circle btn-primary mr-1" href="javascript:void(0)" onclick="editarViaje(' . $viaje->id . ')"
                title="Editar">
                <i class="fa fa-edit"></i>
                </a>';
                $button .=
                    '<a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="eliminarViaje(' . $viaje->id . ')"
                title="Eliminar">
                <i class="fa fa-fw fa-trash"></i>
                </a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }

    public function viajesByCliente($cliente)
    {
        return datatables(Cliente::findOrFail($cliente)->viajes())
            ->addColumn('action', function ($viaje) {
                $button =  '<div class="text-lg-right text-nowrap">';
                $button .=
                    '<a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="eliminarViaje(' . $viaje->id . ')"
                title="Eliminar">
                <i class="fa fa-fw fa-trash"></i>
                </a>';
                $button .= '</div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }
}
