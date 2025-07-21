<?php

use App\Http\Controllers\API\TaskController;

Route::middleware('auth:sanctum')->apiResource('task', TaskController::class);