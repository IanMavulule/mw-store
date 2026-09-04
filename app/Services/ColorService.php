<?php

namespace App\Services;

use App\Models\Color;

class ColorService
{
    public function create(array $data)
    {
        $color = Color::create($data);

        return $color;
    }

    public function list()
    {
        $colors = Color::all();

        return $colors;
    }

    public function listById(string $id)
    {
        $color = Color::findOrFail($id);

        return $color;
    }

    public function delete($id)
    {
        $color = Color::findOrFail($id);

        return $color->delete();
    }

    public function update(string $id, array $data)
    {
        $color = Color::findOrFail($id);
        $color->update($data);

        return $color;
    }
}
