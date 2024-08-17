<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Subscription;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    use ApiResponseTrait;

    // public function __construct()
    // {
    //     $this->middleware(['permission:create-subscription'], ['only' => ['store']]);
    //     $this->middleware(['permission:view-subscription'], ['only' => ['show']]);
    //     $this->middleware(['permission:update-subscription'], ['only' => ['update']]);
    //     $this->middleware(['permission:delete-subscription'], ['only' => ['destroy']]);
    //     $this->middleware(['permission:view-subscriptions'], ['only' => ['index']]);
    //     $this->middleware(['permission:restore-subscription'], ['only' => ['restore']]);
    //     $this->middleware(['permission:force-delete-subscription'], ['only' => ['forceDelete']]);
    // }

    public function index()
    {
        try {
            $subscriptions = Subscription::all();
            return $this->customeResponse($subscriptions, 'Subscriptions fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreSubscriptionRequest $request)
    {
        try {
            $subscription = Subscription::create($request->only(['member_id', 'plan', 'start_date']));
            return $this->customeResponse($subscription, 'Subscription created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            return $this->customeResponse($subscription, 'Subscription fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateSubscriptionRequest $request, string $id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->update($request->only(['member_id', 'plan', 'start_date']));
            return $this->customeResponse($subscription, 'Subscription updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $subscription = Subscription::findOrFail($id);
            $subscription->delete();
            return $this->customeResponse(null, 'Subscription deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $subscription = Subscription::withTrashed()->findOrFail($id);
            $subscription->restore();
            return $this->customeResponse($subscription, 'Subscription restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $subscription = Subscription::withTrashed()->findOrFail($id);
            $subscription->forceDelete();
            return $this->customeResponse(null, 'Subscription permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
