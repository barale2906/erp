<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmpresaUser extends Model
{
    protected $fillable = [
        'user_id', 'name', 'empresa_id', 'role_id', 'sucursal_id', 'sucursal', 'area_id', 'area', 'estado',
    ];
}
