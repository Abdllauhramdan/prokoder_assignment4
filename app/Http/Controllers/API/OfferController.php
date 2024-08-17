<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Models\Offer;
use Illuminate\Support\Facades\Log;

class OfferController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // $this->middleware(['permission:create-offer'], ['only' => ['store']]);
        // $this->middleware(['permission:view-offer'], ['only' => ['show']]);
        // $this->middleware(['permission:update-offer'], ['only' => ['update']]);
        // $this->middleware(['permission:delete-offer'], ['only' => ['destroy']]);
        // $this->middleware(['permission:view-offers'], ['only' => ['index']]);
        // $this->middleware(['permission:restore-offer'], ['only' => ['restore']]);
        // $this->middleware(['permission:force-delete-offer'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $offers = Offer::all();
            return $this->customeResponse($offers, 'Offers fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StoreOfferRequest $request)
    {
        try {
            $offer = Offer::create($request->only([
                'name', 
                'description', 
                'discount_percentage', 
                'start_date', 
                'end_date'
            ]));
            return $this->customeResponse($offer, 'Offer created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $offer = Offer::findOrFail($id);
            return $this->customeResponse($offer, 'Offer fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdateOfferRequest $request, string $id)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->update($request->only([
                'name', 
                'description', 
                'discount_percentage', 
                'start_date', 
                'end_date'
            ]));
            return $this->customeResponse($offer, 'Offer updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $offer = Offer::findOrFail($id);
            $offer->delete();
            return $this->customeResponse(null, 'Offer deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $offer = Offer::withTrashed()->findOrFail($id);
            $offer->restore();
            return $this->customeResponse($offer, 'Offer restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $offer = Offer::withTrashed()->findOrFail($id);
            $offer->forceDelete();
            return $this->customeResponse(null, 'Offer permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
