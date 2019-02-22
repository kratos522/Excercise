<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Persona;

class StorePersona extends FormRequest
{

  private $response;
  private $nue_type;

  public function __construct()
  {
      $this->init();
  }

  private function init() {
      $this->response = new \stdClass;
      $this->response->code = 200;
      $this->response->success = true;
      $this->response->message = null;
      $this->response->payload = new \stdClass;
      $this->response->payload->id = null;
  }

  public function rules($arr)
  {
     $validator = Validator::make($arr   , [
      "token" => "required",
      // "anexos" => "required",
      // "anexos.documento_id" => "required",

      "personas" => "required",
      "personas.Cedula" => "required",
      "personas.nombres" => "required",
      "personas.apellidos" => "required",
   ]);

     if ($validator->fails()) {
       $this->response->code = 403;
       $this->response->message = $validator->errors();
       return $this->response;
     }

     return $this->response;
  }

  public function persist($arr) {
      try {
          $persona = $this->set_persona($arr);
          $this->log::alert(json_encode($persona));

          $this->init();
          $this->response->message = "persona Creada Exitosamente";
          $this->response->payload->id = $persona->id;
      } catch (Exception $e) {
          $this->log::error($e);
          $this->init();
          $this->response->code = 403;
          $this->response->success = false;
          $this->response->message = "persona no creada";
          return $this->response;
      }

      return $this->response;
  }

  public function set_persona($arr) {
      $persona_arr = [
        "Cedula" => $arr["personas"]["Cedula"],
        "nombres" => $arr["personas"]["nombres"],
        "apellidos" => $arr["personas"]["apellidos"],
        "edad" => $arr["personas"]["edad"],
        "fecha_nacimiento" => $arr["personas"]["fecha_nacimiento"],
      ];


      $persona = new Persona($persona_arr);
      $persona->save();
      return $persona;
  }
}
