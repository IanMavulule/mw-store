<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\ImageRequest;
use App\Models\ProductVariant;
use App\Services\ImagesService;
use App\Traits\ApiResponse;

class ImageController extends Controller
{
    use ApiResponse;

    public function __construct(ImagesService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(ProductVariant $variant)
    {
        try {
            $data = $this->imageService->list($variant);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Imagens',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ImageRequest $request, ProductVariant $variant)
    {
        try {
            $data = $this->imageService->create($variant, $request->file('images'));

            return $this->success([
                'data' => $data,
                'mensagem' => 'Imagem adicionada',
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
            $data = $this->imageService->listById($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Imagem',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ImageRequest $request, string $id)
    {
        try {
            $data = $this->imageService->update($id, $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Imagem atualizada',
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
            $data = $this->imageService->delete($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Imagem removida',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
