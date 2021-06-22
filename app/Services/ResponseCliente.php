<?php

namespace App\Services;

use App\Cliente;

class ResponseCliente
{

    public function index($filters)
    {
        return datatables(Cliente::latest())
            ->filter(function ($query) use ($filters) {

                if ($filters->exists('id') && !empty($filters->id)) {
                    $query->where('id', 'like', "%{$filters->get('id')}%");
                }
                if ($filters->exists('nombre') && !empty($filters->nombre)) {
                    $query->where('nombre', 'like', "%{$filters->get('nombre')}%");
                }
                if ($filters->exists('email') && !empty($filters->email)) {
                    $query->where('email', 'like', "%{$filters->get('email')}%");
                }
            })
            ->addColumn('action', function ($cliente) {
                $button =  '<div class="text-lg-right text-nowrap">';
                $button .=
                    '<a class="btn btn-circle btn-primary mr-1" href="javascript:void(0)" onclick="verViajes(' . $cliente->id . ')"
                title="Ver viajes">
                <i class="fa fa-eye"></i>
                </a>';
                $button .=
                    '<a class="btn btn-circle btn-primary mr-1" href="javascript:void(0)" onclick="editarCliente(' . $cliente->id . ')"
                title="Editar">
                <i class="fa fa-edit"></i>
                </a>';
                $button .=
                    '<a class="btn btn-circle btn-danger" href="javascript:void(0)" onclick="eliminarCliente(' . $cliente->id . ')"
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
