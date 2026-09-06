<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Favorite;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FavoriteService
{
    public function __construct(private CartService $cartService) {}

    public function add(User $client, array $data): Favorite
    {
        $variant = ProductVariant::findOrFail($data['product_variant_id']);

        $exists = Favorite::where('client_id', $client->id)
            ->where('product_variant_id', $variant->id)
            ->exists();

        if ($exists) {
            throw new \DomainException('Este produto já está nos favoritos.');
        }

        return Favorite::create([
            'client_id' => $client->id,
            'product_variant_id' => $variant->id,
        ]);
    }

    public function list(User $client): Collection
    {
        return Favorite::where('client_id', $client->id)
            ->with(['productVariant.product', 'productVariant.size', 'productVariant.color', 'productVariant.images'])
            ->get();
    }

    public function remove(string $id, User $client): bool
    {
        $favorite = Favorite::where('client_id', $client->id)->findOrFail($id);

        return $favorite->delete();
    }

    public function moveToCart(string $id, User $client): Cart
    {
        $favorite = Favorite::where('client_id', $client->id)->findOrFail($id);

        $cart = $this->cartService->add($client, [
            'product_variant_id' => $favorite->product_variant_id,
            'quantity' => 1,
        ]);

        $favorite->delete();

        return $cart;
    }
}
