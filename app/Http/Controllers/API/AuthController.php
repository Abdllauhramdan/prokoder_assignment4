<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Traits\ApiResponseTrait;

class AuthController extends Controller
{
    use ApiResponseTrait;

    /**
     * AuthController constructor.
     *
     * Apply middleware to controller methods.
     */
    public function __construct()
    {
        // Apply 'auth:api' middleware to all methods except 'login' and 'register'
        $this->middleware('auth:api', ['except' => ['login', 'register']]);

        // Apply 'permission:view-users' middleware to the 'index' and 'show' methods
        $this->middleware(['permission:view-users'], ['only' => ['index', 'show']]);

        // Apply 'permission:create-user' middleware to the 'register' method
        $this->middleware(['permission:create-user'], ['only' => ['register']]);

        // Apply 'permission:update-user' middleware to the 'update' method
        $this->middleware(['permission:update-user'], ['only' => ['update']]);

        // Apply 'permission:delete-user' middleware to the 'destroy' method
        $this->middleware(['permission:delete-user'], ['only' => ['destroy']]);

        // Apply 'permission:restore-user' middleware to the 'restoreUser' method
        $this->middleware(['permission:restore-user'], ['only' => ['restoreUser']]);

        // Apply 'permission:force-delete-user' middleware to the 'forceDeleteUser' method
        $this->middleware(['permission:force-delete-user'], ['only' => ['forceDeleteUser']]);
    }

    /**
     * Authenticate a user and return a JSON response with user info and token.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        if (!$token) {
            return $this->customeResponse(null, 'Unauthorized', 401);
        }

        $user = Auth::user();
        return $this->customeResponse([
            'user' => $user,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 'Logged in successfully', 200);
    }

    /**
     * Register a new user and return a JSON response with user info and token.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $user->assignRole('client'); // Assign a default role

            $token = Auth::login($user);

            return $this->customeResponse([
                'user' => $user,
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => Auth::factory()->getTTL() * 60
            ], 'User registered successfully', 201);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Server error', 500);
        }
    }

    /**
     * Return the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->customeResponse(Auth::user(), 'User data retrieved successfully', 200);
    }

    /**
     * Logout the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return $this->customeResponse(null, 'Successfully logged out', 200);
    }

    /**
     * Refresh the authentication token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = Auth::refresh();
        return $this->customeResponse([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ], 'Token refreshed successfully', 200);
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        try {
            return $this->customeResponse($user, 'User data retrieved successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Server error', 500);
        }
    }

    /**
     * Update the specified user.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->update($request->only([
                'name', 'email', 'password'
            ]));

            return $this->customeResponse($user, 'User updated successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Server error', 500);
        }
    }

    /**
     * Soft delete the specified user.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return $this->customeResponse(null, 'User deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Server error', 500);
        }
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restoreUser(string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);

            if (!$user->trashed()) {
                return $this->customeResponse(null, 'User is not deleted. No need to restore.', 404);
            }

            $user->restore();
            return $this->customeResponse($user, 'User restored successfully', 200);
        } catch (\Throwable $th) {
            Log::error("Error restoring user: " . $th->getMessage());
            return $this->customeResponse(null, 'Server error', 500);
        }
    }

    /**
     * Force delete the specified user.
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDeleteUser(Request $request, string $id)
    {
        try {
            $user = User::withTrashed()->findOrFail($id);

            if (!$user->trashed()) {
                return $this->customeResponse(null, 'User is not soft deleted. Use delete first.', 400);
            }

            $user->forceDelete();
            return $this->customeResponse(null, 'User force deleted successfully', 200);
        } catch (\Throwable $th) {
            Log::error($th);
            return $this->customeResponse(null, 'Server error', 500);
        }
    }
}
