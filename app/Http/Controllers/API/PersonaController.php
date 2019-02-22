<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\StorePersona;
use App\Http\Controllers\Controller;
use App\Persona;

class PersonaController extends Controller
{

  private $StorePersona;

  public function store(Request $request) {
    $res = $this->StorePersona->rules($arr);

    if ($res->code != 200) {
      return response()->json(['error'=>$res->message], 403);
    }

    $res = $this->StorePersona->persist($arr);

    if (!$res->success) {
      return response()->json(['error'=>$res->message], 403);
    }

     # return success response
     return response()->json(['success' => $res->success, 'message'=>$res->message, 'payload' => $res->payload], $this->successStatus);
  }
}
