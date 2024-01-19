<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    
    //Register
    public function store(Request $request) 
    {
        // Validación
        $validator = Validator::make(request()->all(), [
            'name' => 'required|max:30',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        // Puedes agregar más lógica aquí, como enviar correos electrónicos de confirmación, generar tokens, etc.

        return response()->json([
            'message' => 'Usuario registrado con éxito'
        ], 201);
    }
}
