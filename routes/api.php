<?php
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\OfferController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\TagController;
use App\Http\Controllers\API\SportController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\FacilityController;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\SubscriptionController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {
   // CategoryController Routes
Route::get('categories', [CategoryController::class, 'index']); 
Route::post('categories', [CategoryController::class, 'store']); 
Route::get('categories/{category}', [CategoryController::class, 'show']); 
Route::put('categories/{category}', [CategoryController::class, 'update']); 
Route::delete('categories/{category}', [CategoryController::class, 'destroy']); 
Route::post('categories/{id}/restore', [CategoryController::class, 'restore']); 
Route::delete('categories/{category}/force', [CategoryController::class, 'forceDelete']); 

// FacilityController Routes
Route::get('facilities', [FacilityController::class, 'index']);
Route::post('facilities', [FacilityController::class, 'store']);
Route::get('facilities/{facility}', [FacilityController::class, 'show']); 
Route::put('facilities/{facility}', [FacilityController::class, 'update']); 
Route::delete('facilities/{facility}', [FacilityController::class, 'destroy']); 

// MemberController Routes
Route::get('members', [MemberController::class, 'index']); 
Route::post('members', [MemberController::class, 'store']); 
Route::get('members/{member}', [MemberController::class, 'show']); 
Route::put('members/{member}', [MemberController::class, 'update']); 
Route::delete('members/{member}', [MemberController::class, 'destroy']); 

// OfferController Routes
Route::get('offers', [OfferController::class, 'index']); 
Route::post('offers', [OfferController::class, 'store']); 
Route::get('offers/{offer}', [OfferController::class, 'show']); 
Route::put('offers/{offer}', [OfferController::class, 'update']); 
Route::delete('offers/{offer}', [OfferController::class, 'destroy']); 
// PaymentController Routes
Route::get('payments', [PaymentController::class, 'index']); 
Route::post('payments', [PaymentController::class, 'store']); 
Route::get('payments/{payment}', [PaymentController::class, 'show']); 
Route::put('payments/{payment}', [PaymentController::class, 'update']); 
Route::delete('payments/{payment}', [PaymentController::class, 'destroy']); 

// RoomController Routes
Route::get('rooms', [RoomController::class, 'index']); 
Route::post('rooms', [RoomController::class, 'store']); 
Route::get('rooms/{room}', [RoomController::class, 'show']); 
Route::put('rooms/{room}', [RoomController::class, 'update']); 
Route::delete('rooms/{room}', [RoomController::class, 'destroy']); 

// SportController Routes
Route::get('sports', [SportController::class, 'index']); 
Route::post('sports', [SportController::class, 'store']);
Route::get('sports/{sport}', [SportController::class, 'show']); 
Route::put('sports/{sport}', [SportController::class, 'update']);
Route::delete('sports/{sport}', [SportController::class, 'destroy']); 
// SubscriptionController Routes
Route::get('subscriptions', [SubscriptionController::class, 'index']); 
Route::post('subscriptions', [SubscriptionController::class, 'store']); 
Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show']); 
Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update']); 
Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy']);

// TagController Routes
Route::get('tags', [TagController::class, 'index']); 
Route::post('tags', [TagController::class, 'store']); 
Route::get('tags/{tag}', [TagController::class, 'show']); 
Route::put('tags/{tag}', [TagController::class, 'update']); 
Route::delete('tags/{tag}', [TagController::class, 'destroy']); 

});

