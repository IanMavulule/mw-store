<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Size\SizeRequest;
use App\Services\SizeService;
use App\Traits\ApiResponse;

class SizeController extends Controller
{
    use ApiResponse;

    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->sizeService->list();

            return $this->success([
                'data' => $data,
                'mensagem' => 'Tamanhos',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SizeRequest $request)
    {
        try {
            $data = $this->sizeService->create($request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Tamanho adicionado',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $data = $this->sizeService->listById($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Tamanho',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SizeRequest $request, string $id)
    {
        try {
            $data = $this->sizeService->update($id, $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Tamanho atualizado',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $data = $this->sizeService->delete($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Tamanho removido',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
