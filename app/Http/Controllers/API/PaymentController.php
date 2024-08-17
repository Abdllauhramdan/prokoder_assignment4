<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    use ApiResponseTrait;

    public function __construct()
    {
        // $this->middleware(['permission:create-payment'], ['only' => ['store']]);
        // $this->middleware(['permission:view-payment'], ['only' => ['show']]);
        // $this->middleware(['permission:update-payment'], ['only' => ['update']]);
        // $this->middleware(['permission:delete-payment'], ['only' => ['destroy']]);
        // $this->middleware(['permission:view-payments'], ['only' => ['index']]);
        // $this->middleware(['permission:restore-payment'], ['only' => ['restore']]);
        // $this->middleware(['permission:force-delete-payment'], ['only' => ['forceDelete']]);
    }

    public function index()
    {
        try {
            $payments = Payment::with('member')->get();
            return $this->customeResponse($payments, 'Payments fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function store(StorePaymentRequest $request)
    {
        try {
            $payment = Payment::create($request->only(['member_id', 'amount', 'payment_date']));
            return $this->customeResponse($payment, 'Payment created successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function show(string $id)
    {
        try {
            $payment = Payment::with('member')->findOrFail($id);
            return $this->customeResponse($payment, 'Payment fetched successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function update(UpdatePaymentRequest $request, string $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->update($request->only(['member_id', 'amount', 'payment_date']));
            return $this->customeResponse($payment, 'Payment updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();
            return $this->customeResponse(null, 'Payment deleted successfully', 204);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function restore(string $id)
    {
        try {
            $payment = Payment::withTrashed()->findOrFail($id);
            $payment->restore();
            return $this->customeResponse($payment, 'Payment restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }

    public function forceDelete(string $id)
    {
        try {
            $payment = Payment::withTrashed()->findOrFail($id);
            $payment->forceDelete();
            return $this->customeResponse(null, 'Payment permanently deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Error, Something went wrong', 500);
        }
    }
}
