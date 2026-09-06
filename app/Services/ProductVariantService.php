<?php

namespace App\Services;

use App\Models\ProductVariant;

class ProductVariantService
{
    public function create(array $data)
    {
        $productVariant = ProductVariant::create($data);

        return $productVariant;
    }

    public function list()
    {
        $productVariants = ProductVariant::with(['product', 'size', 'color', 'secondColor', 'images'])->get();

        return $productVariants;
    }

    public function listById(string $id)
    {
        $productVariant = ProductVariant::with(['product', 'size', 'color', 'secondColor'])->findOrFail($id);

        return $productVariant;
    }

    public function delete($id)
    {
        $productVariant = ProductVariant::findOrFail($id);

        return $productVariant->delete();
    }

    public function update(string $id, array $data)
    {
        $productVariant = ProductVariant::findOrFail($id);
        $productVariant->update($data);

        return $productVariant;
    }
}
