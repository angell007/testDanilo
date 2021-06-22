<?php

namespace App;

use App\Models\Viaje;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'barrio',
        'direccion',
        'telefono',

    ];
    protected $primaryKey = 'id';

    protected $appends = ['fullname'];

    public function getFullnameAttribute()
    {
        return $this->attributes['nombre'] . ' ' . $this->attributes['apellidos'];
    }

    public function viajes()
    {
        return $this->hasMany(Viaje::class);
    }
}
