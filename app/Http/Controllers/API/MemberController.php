<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // $this->middleware(['permission:create-member'], ['only' => ['store']]);
        // $this->middleware(['permission:view-member'], ['only' => ['show']]);
        // $this->middleware(['permission:update-member'], ['only' => ['update']]);
        // $this->middleware(['permission:delete-member'], ['only' => ['destroy']]);
        // $this->middleware(['permission:view-members'], ['only' => ['index']]);
        // $this->middleware(['permission:restore-member'], ['only' => ['restore']]);
        // $this->middleware(['permission:force-delete-member'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $members = Member::all();
            return $this->customeResponse($members, 'Members fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreMemberRequest $request)
    {
        try {
            $member = Member::create($request->only(['name', 'email', 'phone']));
            return $this->customeResponse($member, 'Member created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $member = Member::findOrFail($id);
            return $this->customeResponse($member, 'Member fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateMemberRequest $request, string $id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->update($request->only(['name', 'email', 'phone']));
            return $this->customeResponse($member, 'Member updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $member = Member::findOrFail($id);
            $member->delete();
            return $this->customeResponse(null, 'Member deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $member = Member::withTrashed()->findOrFail($id);
            $member->restore();
            return $this->customeResponse($member, 'Member restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $member = Member::withTrashed()->findOrFail($id);
            $member->forceDelete();
            return $this->customeResponse(null, 'Member permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
