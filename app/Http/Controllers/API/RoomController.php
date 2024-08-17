<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // $this->middleware(['permission:create-room'], ['only' => ['store']]);
        // $this->middleware(['permission:view-room'], ['only' => ['show']]);
        // $this->middleware(['permission:update-room'], ['only' => ['update']]);
        // $this->middleware(['permission:delete-room'], ['only' => ['destroy']]);
        // $this->middleware(['permission:view-rooms'], ['only' => ['index']]);
        // $this->middleware(['permission:restore-room'], ['only' => ['restore']]);
        // $this->middleware(['permission:force-delete-room'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $rooms = Room::all();
            return $this->customeResponse($rooms, 'Rooms fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreRoomRequest $request)
    {
        try {
            $room = Room::create($request->only(['name', 'description']));
            return $this->customeResponse($room, 'Room created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $room = Room::findOrFail($id);
            return $this->customeResponse($room, 'Room fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateRoomRequest $request, string $id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->update($request->only(['name', 'description']));
            return $this->customeResponse($room, 'Room updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $room = Room::findOrFail($id);
            $room->delete();
            return $this->customeResponse(null, 'Room deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $room = Room::withTrashed()->findOrFail($id);
            $room->restore();
            return $this->customeResponse($room, 'Room restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $room = Room::withTrashed()->findOrFail($id);
            $room->forceDelete();
            return $this->customeResponse(null, 'Room permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
