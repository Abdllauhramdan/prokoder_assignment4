<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        $this->middleware(['permission:create-article'], ['only' => ['store']]);
        $this->middleware(['permission:view-article'], ['only' => ['show']]);
        $this->middleware(['permission:update-article'], ['only' => ['update']]);
        $this->middleware(['permission:delete-article'], ['only' => ['destroy']]);
        $this->middleware(['permission:view-articles'], ['only' => ['index']]);
        $this->middleware(['permission:restore-article'], ['only' => ['restore']]);
        $this->middleware(['permission:force-delete-article'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $articles = Article::with(['category', 'tags'])->get();
            return $this->customeResponse($articles, 'Articles fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreArticleRequest $request)
    {
        try {
            $article = Article::create($request->only(['title', 'content', 'category_id']));
            if ($request->has('tags')) {
                $article->tags()->sync($request->tags);
            }
            return $this->customeResponse($article->load('tags'), 'Article created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $article = Article::with(['category', 'tags'])->findOrFail($id);
            return $this->customeResponse($article, 'Article fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateArticleRequest $request, string $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->update($request->only(['title', 'content', 'category_id']));
            if ($request->has('tags')) {
                $article->tags()->sync($request->tags);
            }
            return $this->customeResponse($article->load('tags'), 'Article updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $article = Article::findOrFail($id);
            $article->delete();
            return $this->customeResponse(null, 'Article deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $article = Article::withTrashed()->findOrFail($id);
            $article->restore();
            return $this->customeResponse($article, 'Article restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $article = Article::withTrashed()->findOrFail($id);
            $article->forceDelete();
            return $this->customeResponse(null, 'Article permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
