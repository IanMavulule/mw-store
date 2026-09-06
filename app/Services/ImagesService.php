<?php

namespace App\Services;

use App\Models\Image;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImagesService
{
    private const MAX_IMAGES = 10;

    public function create(ProductVariant $variant, array $files): Collection
    {
        $atuais = $variant->images()->count();

        if ($atuais + count($files) > self::MAX_IMAGES) {
            throw new \DomainException(
                'Uma variante não pode ter mais de '.self::MAX_IMAGES.' imagens.'
            );
        }

        $next = ($variant->images()->max('sort_order') ?? -1) + 1;
        $stored = [];

        try {
            DB::transaction(function () use ($variant, $files, &$next, &$stored) {
                foreach ($files as $file) {
                    $path = $file->store("variants/{$variant->id}", 'public');
                    $stored[] = $path;

                    $variant->images()->create([
                        'path' => $path,
                        'sort_order' => $next++,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($stored);
            throw $e;
        }

        return $variant->images()->get();
    }

    public function list(ProductVariant $variant): Collection
    {
        return $variant->images()->get();
    }

    public function listById(string $id): Image
    {
        return Image::findOrFail($id);
    }

    public function update(string $id, array $data): Image
    {
        $image = Image::findOrFail($id);
        $image->update($data);

        return $image;
    }

    public function delete(string $id): bool
    {
        $image = Image::findOrFail($id);

        Storage::disk('public')->delete($image->path);

        return $image->delete();
    }
}
