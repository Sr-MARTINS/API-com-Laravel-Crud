<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     *  Retorna uma lista paginada de usuarios
     * 
     * Este metodo recupera uma lista paginada de usuarios do banco de dados e 
     * o retorna como uma resposta JSOM
     */

    public function index() : JsonResponse
    {
        //Recupera os usuarios do banco de dados, ordenado pelo id (podemos ursar uma ' , ' e passar um 'DESC' da vida, para ser ordenado de forma decresente ) o paginados
        $usuarios = User::orderBy('id')->paginate(2);

        // Retorna os usuarios recuperados como uma resposta JSON 
        return response()->json([
            'status' => true,
            'usuarios' => $usuarios
        ], 200);
    }

    public function show(User $user) : JsonResponse
    {
        return response()->json([
            'status' => true,
            'user' => $user
        ], 200);
    }


    /**
     * Criar novo usuario com os dados fornecidos na requisição
     * 
     *   @param \App\http\Requests\UserRequest $request o objeto de requisição contendo os dados do usuario
     * a ser criado
     *    @return \Illuminate\Http\JsonResponse
     */

    public function store(UserRequest $request) : JsonResponse
    {
        // Iniciar a transação
        DB::beginTransaction();

        try {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

            // Operação é concluida
            DB::commit();

            return response()->json([
                'status'  => true,
                'user'    => $user,
                'message' => 'Usuario cadastrado com sucesso!'
            ], 201);

        } catch (Exception $e) {
            
            // Operação nao é concluida
            DB::rollBack();

            // Retonar uma msg de erro com status 400
            return response()->json([
                'status' => false,
                'message' => 'Usuario não cadastrado!'
            ], 400);
        }
    }

    
}
