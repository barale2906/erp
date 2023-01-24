<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    protected $fillable = [
        'usu_id', 'firmadoPor', 'certificado', 'salario_id', 'usu_gen',
   ];
}
