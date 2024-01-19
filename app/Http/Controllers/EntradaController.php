<?php

namespace App\Http\Controllers;

use App\Models\Entrada;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class EntradaController extends Controller
{
    //ver
    public function show(Entrada $entradas, Request $request)
    {
        $user_id = (isset($_GET['user_id'])) ? $_GET['user_id'] : '' ;
        $categoria_id = (isset($_GET['categoria_id'])) ? $_GET['categoria_id'] : '' ;
        $search = (isset($_GET['search'])) ? $_GET['search'] : '' ;
        $fecha = (isset($_GET['fecha'])) ? $_GET['fecha'] : '' ;

        //Inicializamos el query
        $consulta = Entrada::query();
        // Filtramos si recibimos el parametro
        if($user_id != '') {$consulta->where('user_id', $user_id);}
        if($categoria_id != '') {$consulta->where('categoria_id', $categoria_id);}
        if($search != '') {
            $consulta->where('titulo', 'like', '%' . $search . '%')
            ->orWhere('subtitulo', 'like', '%' . $search . '%');
        }
        if($fecha != '') {$consulta->whereDate('created_at', $fecha);}

        //Traemos de a 20
        $consulta->latest()->paginate(20);   

        // Obtenemos los datos
        $entradas = $consulta->get();

        // Los retornamos
        return response()->json([
            'error' => '0',
            'entradas' => $entradas,
        ], 201);

    }

    //crear
    public function store(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'titulo' => 'required|max:255',
            'subtitulo' => 'required|max:255',
            'texto' => 'required',
            'imagen' => 'required',
            'cover' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        // Crear un nuevo usuario
        $entrada = Entrada::create([
            'titulo' => $request->input('titulo'),
            'subtitulo' => $request->input('subtitulo'),
            'texto' =>$request->input('texto'),
            'imagen' =>$request->input('imagen'),
            'cover' =>$request->input('cover'),
            'user_id' =>$request->input('user_id'),
            'categoria_id' =>$request->input('categoria_id'),
        ]);
        // Puedes agregar más lógica aquí, como enviar correos electrónicos de confirmación, generar tokens, etc.

        return response()->json([
            'message' => 'Entrada creada con éxito'
        ], 201);

    }

}
