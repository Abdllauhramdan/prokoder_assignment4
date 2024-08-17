<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreSportRequest;
use App\Http\Requests\UpdateSportRequest;
use App\Models\Sport;
use Illuminate\Support\Facades\Log;

class SportController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // $this->middleware(['permission:create-sport'], ['only' => ['store']]);
        // $this->middleware(['permission:view-sport'], ['only' => ['show']]);
        // $this->middleware(['permission:update-sport'], ['only' => ['update']]);
        // $this->middleware(['permission:delete-sport'], ['only' => ['destroy']]);
        // $this->middleware(['permission:view-sports'], ['only' => ['index']]);
        // $this->middleware(['permission:restore-sport'], ['only' => ['restore']]);
        // $this->middleware(['permission:force-delete-sport'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $sports = Sport::all();
            return $this->customeResponse($sports, 'Sports fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreSportRequest $request)
    {
        try {
            $sport = Sport::create($request->only(['name', 'description']));
            return $this->customeResponse($sport, 'Sport created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $sport = Sport::findOrFail($id);
            return $this->customeResponse($sport, 'Sport fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateSportRequest $request, string $id)
    {
        try {
            $sport = Sport::findOrFail($id);
            $sport->update($request->only(['name', 'description']));
            return $this->customeResponse($sport, 'Sport updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $sport = Sport::findOrFail($id);
            $sport->delete();
            return $this->customeResponse(null, 'Sport deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $sport = Sport::withTrashed()->findOrFail($id);
            $sport->restore();
            return $this->customeResponse($sport, 'Sport restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $sport = Sport::withTrashed()->findOrFail($id);
            $sport->forceDelete();
            return $this->customeResponse(null, 'Sport permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
