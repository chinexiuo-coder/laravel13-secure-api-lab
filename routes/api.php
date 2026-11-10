<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

// Protected routes
Route::middleware('auth:sanctum')->group(function () {

    // Authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Profile route
    Route::get('/profile', function (Request $request) {
        return response()->json([
            'message' => 'This is a protected route.',
            'user' => $request->user(),
        ]);
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Admin and Student access
    Route::middleware('role:admin,student')->group(function () {
        Route::get('/students', function (Request $request) {
            return response()->json([
                'message' => 'Welcome to the students route.',
                'user' => $request->user(),
            ]);
        });
    });

    // Admin-only dashboard
    Route::middleware('admin')->group(function () {
        Route::get('/admin/dashboard', function (Request $request) {
            return response()->json([
                'message' => 'Welcome to the admin dashboard.',
                'user' => $request->user(),
            ]);
        });
    });

    // Student-only dashboard
    Route::middleware('role:student')->group(function () {
        Route::get('/student/dashboard', function (Request $request) {
            return response()->json([
                'message' => 'Welcome to the student dashboard.',
                'user' => $request->user(),
            ]);
        });
    });
});

// Sample route for testing
Route::get('/sample', function () {
    return response()->json([
        'message' => 'This is a sample route.',
    ]);
});
