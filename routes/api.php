<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('get-task', [TaskController::class, 'index']);  //http://127.0.0.1:8000/api/get-task  --viewing all the tasks. 
Route::post('store-task', [TaskController::class, 'store']); //http://127.0.0.1:8000/api/store-task param:{ 'name', 'description'} --creating the task.
Route::get('get-one-task/{id}', [TaskController::class, 'show']);  //http://127.0.0.1:8000/api/get-one-task/2 --viewing a single task
Route::put('update-task-status/{id}', [TaskController::class, 'update']);   //http://127.0.0.1:8000/api/update-task-status/6 param{'status['pending', 'completed', 'cancelled']'} --updating the status of the task 
Route::get('get-task-status/{status}', [TaskController::class, 'taskStatus']);  //http://127.0.0.1:8000/api/get-task-status/cancelled --getting the tasks via the status of the task
Route::get('delete-all-tasks', [TaskController::class, 'deleteTasks']); http://127.0.0.1:8000/api/delete-all-tasks --deleting all the tasks. 
Route::delete('delete-task/{id}', [TaskController::class, 'delete']); //http://127.0.0.1:8000/api/delete-task/6 --deleting a task by id