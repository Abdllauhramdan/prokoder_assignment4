<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Models\Facility;
use Illuminate\Support\Facades\Log;

class FacilityController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
    //     $this->middleware(['permission:create-facility'], ['only' => ['store']]);
    //     $this->middleware(['permission:view-facility'], ['only' => ['show']]);
    //     $this->middleware(['permission:update-facility'], ['only' => ['update']]);
    //     $this->middleware(['permission:delete-facility'], ['only' => ['destroy']]);
    //     $this->middleware(['permission:view-facilities'], ['only' => ['index']]);
    //     $this->middleware(['permission:restore-facility'], ['only' => ['restore']]);
    //     $this->middleware(['permission:force-delete-facility'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $facilities = Facility::all();
            return $this->customeResponse($facilities, 'Facilities fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreFacilityRequest $request)
    {
        try {
            $facility = Facility::create($request->only(['name', 'description']));
            return $this->customeResponse($facility, 'Facility created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $facility = Facility::findOrFail($id);
            return $this->customeResponse($facility, 'Facility fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateFacilityRequest $request, string $id)
    {
        try {
            $facility = Facility::findOrFail($id);
            $facility->update($request->only(['name', 'description']));
            return $this->customeResponse($facility, 'Facility updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $facility = Facility::findOrFail($id);
            $facility->delete();
            return $this->customeResponse(null, 'Facility deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $facility = Facility::withTrashed()->findOrFail($id);
            $facility->restore();
            return $this->customeResponse($facility, 'Facility restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $facility = Facility::withTrashed()->findOrFail($id);
            $facility->forceDelete();
            return $this->customeResponse(null, 'Facility permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
