<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\ArticleRequest;
use App\Services\ArticleService;
use App\Traits\ApiResponse;

class ArticleController extends Controller
{
    use ApiResponse;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data = $this->articleService->list();

            return $this->success([
                'data' => $data,
                'mensagem' => 'Artigos',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(ArticleRequest $data)
    {
        try {
            $data = $this->articleService->create($data->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Artigo adicionado',
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
            $data = $this->articleService->listById($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Artigo',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, string $id)
    {
        try {
            $data = $this->articleService->update($id, $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Artigo atualizado',
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
            $data = $this->articleService->delete($id);

            return $this->success([
                'data' => $data,
                'mensagem' => 'Artigo removido',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
