<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    use ApiResponseTrait;

    // public function __construct()
    // {
    //     $this->middleware(['permission:create-tag'], ['only' => ['store']]);
    //     $this->middleware(['permission:view-tag'], ['only' => ['show']]);
    //     $this->middleware(['permission:update-tag'], ['only' => ['update']]);
    //     $this->middleware(['permission:delete-tag'], ['only' => ['destroy']]);
    //     $this->middleware(['permission:view-tags'], ['only' => ['index']]);
    // }

    public function index()
    {
        try {
            $tags = Tag::all();
            return $this->customeResponse($tags, 'Tags fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreTagRequest $request)
    {
        try {
            $tag = Tag::create($request->validated());
            return $this->customeResponse($tag, 'Tag created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            return $this->customeResponse($tag, 'Tag fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateTagRequest $request, string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->update($request->validated());
            return $this->customeResponse($tag, 'Tag updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $tag = Tag::findOrFail($id);
            $tag->delete();
            return $this->customeResponse(null, 'Tag deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
