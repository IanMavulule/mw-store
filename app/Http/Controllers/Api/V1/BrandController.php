<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Http\Requests\Brand\BrandRequest;
use App\Services\BrandService;

class BrandController extends Controller
{   
    use ApiResponse;

    public function __construct(BrandService $brandService) 
    {
        $this->brandService = $brandService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->brandService->list();
            return $this->success([
                'data' => $data,
                'mensagem' => 'Marcas',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(BrandRequest $data)
    {
        try {
            $data = $this->brandService->create($data->validated());
            return $this->success([
                'data' => $data,
                'mensagem' => 'Marca adicionada',
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
            $data = $this->brandService->listById($id);
            return $this->success([
                'data' => $data,
                'mensagem' => 'Marca',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, String $id)
    {
        try {
            $data = $this->brandService->update($id, $request->validated());
            return $this->success([
                'data' => $data,
                'mensagem' => 'Brand updated',
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
            $data = $this->brandService->delete($id);
            return $this->success([
                'data' => $data,
                'mensagem' => 'Marcas',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
