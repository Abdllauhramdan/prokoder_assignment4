<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // $this->middleware(['permission:create-category'], ['only' => ['store']]);
        // $this->middleware(['permission:view-category'], ['only' => ['show']]);
        // $this->middleware(['permission:update-category'], ['only' => ['update']]);
        // $this->middleware(['permission:delete-category'], ['only' => ['destroy']]);
        // $this->middleware(['permission:view-categories'], ['only' => ['index']]);
        // $this->middleware(['permission:restore-category'], ['only' => ['restore']]);
        // $this->middleware(['permission:force-delete-category'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $categories = Category::all();
            return $this->customeResponse($categories, 'Categories fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create($request->only(['name', 'description']));
            return $this->customeResponse($category, 'Category created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            return $this->customeResponse($category, 'Category fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateCategoryRequest $request, string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->update($request->only(['name', 'description']));
            return $this->customeResponse($category, 'Category updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();
            return $this->customeResponse(null, 'Category deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->restore();
            return $this->customeResponse($category, 'Category restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $category = Category::withTrashed()->findOrFail($id);
            $category->forceDelete();
            return $this->customeResponse(null, 'Category permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
