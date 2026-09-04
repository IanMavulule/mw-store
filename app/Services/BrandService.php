<?php

namespace App\Services;

use App\Models\Brand;

class BrandService
{
    public function create(array $data) {
        $brand = Brand::create($data);

        return $brand;
    }

    public function list() {
        $brands = Brand::all();
        return $brands;
    }

    public function listById(string $id) {
        $brand = Brand::findOrFail($id);
        return $brand;
    }

    public function delete($id) {
        $brand = Brand::findOrFail($id);
        return $brand->delete();       
    }

    public function update(string $id, array $data) {
        $brand = Brand::findOrFail($id);
        $brand->update($data);

        return $brand;
    }
}