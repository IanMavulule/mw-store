<?php

namespace App\Services;

use App\Models\Size;

class SizeService
{
    public function create(array $data)
    {
        $size = Size::create($data);

        return $size;
    }

    public function list()
    {
        $sizes = Size::all();

        return $sizes;
    }

    public function listById(string $id)
    {
        $size = Size::findOrFail($id);

        return $size;
    }

    public function delete($id)
    {
        $size = Size::findOrFail($id);

        return $size->delete();
    }

    public function update(string $id, array $data)
    {
        $size = Size::findOrFail($id);
        $size->update($data);

        return $size;
    }
}
