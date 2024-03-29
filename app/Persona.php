<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{

  protected $table = "personas";

  protected $fillable = [
    "Cedula",
    "nombres",
    "apellidos",
    "edad",
    "fecha_nacimiento"
  ];
}
