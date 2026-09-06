<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Favorite\FavoriteRequest;
use App\Services\FavoriteService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    use ApiResponse;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->favoriteService->list($request->user());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Favoritos',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FavoriteRequest $request): JsonResponse
    {
        try {
            $data = $this->favoriteService->add($request->user(), $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto adicionado aos favoritos',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        try {
            $data = $this->favoriteService->remove($id, $request->user());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto removido dos favoritos',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Move the specified favorite to the client's cart.
     */
    public function moveToCart(Request $request, string $id): JsonResponse
    {
        try {
            $data = $this->favoriteService->moveToCart($id, $request->user());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto movido para o carrinho',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
