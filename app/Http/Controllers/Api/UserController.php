<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Mockery\Expectation;

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
        //Recupera os usuarios do banco de dados, ordenado pelo id (podemos ursar uma ' , ' e passar um 'DESC' da vida, para ser ordenado de forma decresente ) o paginados  " ->paginate(2) "
        $usuarios = User::orderBy('id')->get();

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
     * Criar novo usuario 
     * com os dados fornecidos na requisição
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


    /**
     * Atualizar os dados 
     * de um usuario existente com base nos dados fornecido na requisição
     * 
     *   @param \App\Http\Requests\UserRequest  $request O objeto de requisição contendo os dados do usuario
     * a ser atualizado.
     * 
     *   @param \App\Models\User $user O usuario a ser atualizado
     *   @return \Illuminate|Http\JsonResponse
     */

    public function update(UserRequest $request, User $user) : JsonResponse
    {

        // Iniciar a transação
        DB::beginTransaction();

        try {

                //Editando os registro do bando 
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);

                //concluir a ediçãp
            DB::commit();

                //Retornando os dados do usuarios editando e retornando uma msg de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuario editado com sucesso'
            ], 200);

        } catch (Expectation $e) {

                //Nao confirma a operação
            DB::rollBack();
                //Retorna a msg de erro 400
            return response()->json([
                'status' => false,
                'message' => 'Usuario nao editado!'
            ], 400);
        }

    }


    /**
     * Excluir usuario 
     * do banco de dados
     * 
     *  @param \App\Models\User  $user O usuario a ser excluido
     *  @return \Illuminate\Http\JsonResponse
     */

    public function destroy(User $user) : JsonResponse
    {
        try {

                //apagar o registro do banco de dado
            $user->delete();

                //Retornando os dados do usuario apagado e a uma msg de sucesso com o status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => 'Usuario deletado com sucesso'
            ], 200);

        } catch (Expectation $e) {

            return response()->json([
                'status' => false,
                'message' => 'Erro ao deletar usuario'
            ], 400);
        }
    }
}
