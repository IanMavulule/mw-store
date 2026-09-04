<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Color\ColorRequest;
use App\Services\ColorService;
use App\Traits\ApiResponse;

class ColorController extends Controller
{
    use ApiResponse;

    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->colorService->list();

            return $this->success([
                'data' => $data,
                'mensagem' => 'Cores',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColorRequest $request)
    {
        try {
            $data = $this->colorService->create($request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Cor adicionada',
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
            $data = $this->colorService->listById($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Cor',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ColorRequest $request, string $id)
    {
        try {
            $data = $this->colorService->update($id, $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Cor atualizada',
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
            $data = $this->colorService->delete($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Cor removida',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
