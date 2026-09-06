<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CreateClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Services\ClientService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use ApiResponse;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function index(): JsonResponse
    {
        try {
            $clients = $this->clientService->list();

            return $this->success([
                'data' => $clients,
                'mensagem' => 'Lista de clientes',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function store(CreateClientRequest $request): JsonResponse
    {
        try {
            $client = $this->clientService->create($request->validated());

            return $this->success([
                'data' => $client,
                'mensagem' => 'Cliente registado com sucesso',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function show(Request $request, string $id): JsonResponse
    {
        try {
            $client = $this->clientService->listById($id, $request->user());

            return $this->success([
                'data' => $client,
                'mensagem' => 'Dados do cliente',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function update(UpdateClientRequest $request, string $id): JsonResponse
    {
        try {
            $client = $this->clientService->update($id, $request->validated(), $request->user());

            return $this->success([
                'data' => $client,
                'mensagem' => 'Cliente atualizado',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        try {
            $client = $this->clientService->delete($id, $request->user());

            return $this->success([
                'data' => $client,
                'mensagem' => 'Conta de cliente eliminada',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
