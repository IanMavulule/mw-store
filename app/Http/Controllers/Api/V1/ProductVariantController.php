<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductVariant\ProductVariantRequest;
use App\Services\ProductVariantService;
use App\Traits\ApiResponse;

class ProductVariantController extends Controller
{
    use ApiResponse;

    public function __construct(ProductVariantService $productVariantService)
    {
        $this->productVariantService = $productVariantService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->productVariantService->list();

            return $this->success([
                'data' => $data,
                'mensagem' => 'Variantes de produto',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductVariantRequest $request)
    {
        try {
            $data = $this->productVariantService->create($request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Variante de produto adicionada',
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
            $data = $this->productVariantService->listById($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Variante de produto',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductVariantRequest $request, string $id)
    {
        try {
            $data = $this->productVariantService->update($id, $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Variante de produto atualizada',
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
            $data = $this->productVariantService->delete($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Variante de produto removida',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
