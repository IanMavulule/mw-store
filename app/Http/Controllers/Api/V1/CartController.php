<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\CartQuantityRequest;
use App\Http\Requests\Cart\CartRequest;
use App\Services\CartService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use ApiResponse;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $data = $this->cartService->list($request->user());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Carrinho',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request): JsonResponse
    {
        try {
            $data = $this->cartService->add($request->user(), $request->validated());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto adicionado ao carrinho',
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
            $data = $this->cartService->remove($id, $request->user());

            return $this->success([
                'data' => $data,
                'mensagem' => 'Produto removido do carrinho',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Add a quantity to the specified cart item.
     */
    public function increment(CartQuantityRequest $request, string $id): JsonResponse
    {
        try {
            $data = $this->cartService->increment($id, $request->user(), $request->validated('quantity'));

            return $this->success([
                'data' => $data,
                'mensagem' => 'Quantidade adicionada ao carrinho',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    /**
     * Remove a quantity from the specified cart item.
     */
    public function decrement(CartQuantityRequest $request, string $id): JsonResponse
    {
        try {
            $data = $this->cartService->decrement($id, $request->user(), $request->validated('quantity'));

            return $this->success([
                'data' => $data,
                'mensagem' => 'Quantidade removida do carrinho',
            ]);
        } catch (\DomainException $e) {
            return $this->error($e->getMessage(), 422);
        }
    }
}
