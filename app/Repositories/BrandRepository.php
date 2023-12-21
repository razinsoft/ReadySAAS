<?php

namespace App\Repositories;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandRepository extends Repository
{
    private static $path = '/brand';

    public static function model()
    {
        return Brand::class;
    }

    public static function storeByRequest(BrandRequest $request)
    {
        $thumbnailId = null;
        if ($request->hasFile('image')) {
            $thumbnail = MediaRepository::storeByRequest($request->image, self::$path);
            $thumbnailId = $thumbnail->id;
        }
        $user = auth()->user();
        $create = self::create([
            'created_by' => $user->id,
            'shop_id' => $user->shop->id ?? $user->shop_id,
            'title' => $request->title,
            'thumbnail_id' => $thumbnailId
        ]);

        return $create;
    }

    public static function updateByRequest(BrandRequest $request, Brand $brand)
    {
        $thumbnail = null;
        if ($request->hasFile('image')) {
            $thumbnail = MediaRepository::updateOrCreateByRequest(
                $request->image,
                self::$path,
                'Image',
                $brand->thumbnail
            );
        }
        $update = self::update($brand, [
            'title' => $request->title,
            'thumbnail_id' => $thumbnail ? $thumbnail->id : $brand->thumbnail_id,
        ]);

        return $update;
    }
}
