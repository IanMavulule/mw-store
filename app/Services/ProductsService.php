<?php

namespace App\Services;

use App\Models\Products;

class ProductsService
{
    public function create(array $data)
    {
        $product = Products::create($data);

        return $product;
    }

    public function list()
    {
        $products = Products::with('brand', 'article')->get();

        return $products;
    }

    public function listById(string $id)
    {
        $product = Products::with('brand', 'article')->findOrFail($id);

        return $product;
    }

    public function delete($id)
    {
        $product = Products::findOrFail($id);

        return $product->delete();
    }

    public function update(string $id, array $data)
    {
        $product = Products::findOrFail($id);
        $product->update($data);

        return $product;
    }
}
