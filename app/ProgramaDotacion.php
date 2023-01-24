<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProgramaDotacion extends Model
{
    protected $fillable = [
        'usu_id', 'fechaEntrega', 'texto', 'estado',
   ];
}
