<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\GeneralSettingRepository;

class CategoryController extends Controller
{
    public function index()
    {
        $shop = auth()->user()?->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $categories = CategoryRepository::query()->where('shop_id', $shopId)->orderByDesc('id')->get();
        return view('category.index', compact('categories'));
    }

    public function store(CategoryRequest $request)
    {
        CategoryRepository::storeByRequest($request);
        return back()->with('success', 'Category inserted successfully');
    }

    public function update(CategoryRequest $request, Category $category)
    {
        CategoryRepository::updateByRequest($request, $category);
        return back()->withSuccess('Category updated successfully');
    }
    public function delete(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted successfully');
    }

    public function downloadSample()
    {
        return response()->download(public_path('import/sample_category.csv'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv'
        ]);
        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));
        $user = auth()->user();
        try {
            foreach ($csvData as $key => $row) {
                if ($key > 0) {
                    $category = CategoryRepository::query()->where('name', $row[1])->first();
                    Category::create([
                        'created_by' => $user->id,
                        'shop_id' => $user->shop->id ?? $user->shop_id,
                        'name' => $row[0],
                        'parent_id' => $category?->id,
                    ]);
                }
            }
            return back()->with('success', 'Categories import successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Please provide valid data in the csv file!');
        }
    }

    public function categoryPrint(Request $request)
    {
        $shop = auth()->user()->shop;
        if ($shop) {
            $shopId = $shop->id;
        } else {
            $shopId = auth()->user()?->shop_id;
        }
        $categories = CategoryRepository::query()->limit($request->length)->get();
        $generalsettings = GeneralSettingRepository::query()->where('shop_id', $shopId)->first();
        return view('category.categoryPrint', compact('categories', 'generalsettings'));
    }
}
