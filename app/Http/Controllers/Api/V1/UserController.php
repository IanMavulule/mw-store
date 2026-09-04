<?php

namespace App\Http\Controllers\Api\V1;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    use ApiResponse;

    public function __construct(UserService $userService) 
    {
        $this->userService = $userService;
    }

    public function store(CreateUserRequest $data): JsonResponse {
        try {
            $user = $this->userService->create($data->validated());
            return $this->success([
                'data' => $user, 
                'Mensagem' => 'User criado com sucesso', 
            ]);

        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function index(): JsonResponse {
        try {
            $users = $this->userService->list();
            return $this->success([
                'data' => $users, 
                'Mensagem' => 'Todos os usuários Gestores e administradores', 
            ]);

        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function show(string $id): JsonResponse {
        try {
            $user = $this->userService->listById($id);
            return $this->success([
                'data' => $user, 
                'Mensagem' => 'Usuário pelo Id', 
            ]);

        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function destroy(Request $request, string $id): JsonResponse {
        try {
            $user = $this->userService->delete($id, $request->user());
            return $this->success([
                'data' => $user, 
                'Mensagem' => 'Usuário deletado', 
            ]);

        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function update(UpdateUserRequest $data, string $id): JsonResponse {
        try {
            $user = $data->validated();
        // dd($datta);
            $user = $this->userService->update($id, $user, $data->user());
            return $this->success([
                'data' => $user, 
                'Mensagem' => 'Usuário atualizado', 
            ]);

        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function generateNewPass(Request $request, string $id) {
        try {

        $data = $request->validated;
            $user = $this->userService->generateNewPass($id, $request->user());
            return $this->success([
                'data' => $user, 
                'Mensagem' => 'Este usuário foi atribuido uma nova Senha', 
            ]);

        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
