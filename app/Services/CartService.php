<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    public function add(User $client, array $data): Cart
    {
        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        $cart = Cart::where('client_id', $client->id)
            ->where('product_variant_id', $variant->id)
            ->first();

        $quantity = ($cart?->quantity ?? 0) + $data['quantity'];

        if ($quantity > $variant->stock) {
            throw new \DomainException('Quantidade indisponível em stock.');
        }

        if ($cart) {
            $cart->update(['quantity' => $quantity]);

            return $cart;
        }

        return Cart::create([
            'client_id' => $client->id,
            'product_variant_id' => $variant->id,
            'quantity' => $data['quantity'],
        ]);
    }

    public function list(User $client): Collection
    {
        return Cart::where('client_id', $client->id)
            ->with(['productVariant.product', 'productVariant.size', 'productVariant.color', 'productVariant.images'])
            ->get();
    }

    public function remove(string $id, User $client): bool
    {
        $cart = Cart::where('client_id', $client->id)->findOrFail($id);

        return $cart->delete();
    }

    public function increment(string $id, User $client, int $quantity): Cart
    {
        $cart = Cart::where('client_id', $client->id)->findOrFail($id);

        $newQuantity = $cart->quantity + $quantity;

        if ($newQuantity > $cart->productVariant->stock) {
            throw new \DomainException('Quantidade indisponível em stock.');
        }

        $cart->update(['quantity' => $newQuantity]);

        return $cart;
    }

    public function decrement(string $id, User $client, int $quantity): Cart|bool
    {
        $cart = Cart::where('client_id', $client->id)->findOrFail($id);

        $newQuantity = $cart->quantity - $quantity;

        if ($newQuantity <= 0) {
            return $cart->delete();
        }

        $cart->update(['quantity' => $newQuantity]);

        return $cart;
    }
}
