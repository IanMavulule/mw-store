<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Products\ProductsRequest;
use App\Services\ProductsService;
use App\Traits\ApiResponse;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    use ApiResponse;

    public function __construct(ProductsService $productsService)
    {
        $this->productsService = $productsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->productsService->list();

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produtos',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductsRequest $request)
    {
        try {
            $data = $this->productsService->create($request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto adicionado',
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
            $data = $this->productsService->listById($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductsRequest $request, string $id)
    {
        try {
            $data = $this->productsService->update($id, $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto atualizado',
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
            $data = $this->productsService->delete($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto removido',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
