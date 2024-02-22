<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        if ($tasks->isEmpty()) {
            $response = [
                'message' => 'No Task Available'
            ];
        } else {
            $response = [
                'message' => 'Successful',
                'tasks' => $tasks,
            ];
        }
        return response()->json($response);    
    }

    public function store(Request $request)
    {
        // Validate the incomping data
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tasks|max:255',
            'description' => 'required|max:1000',
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // store the tasks
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->save();
        
        if ($task) {
            $response = [
                'message' => 'Successful',
                'task' => $task,
            ];
        } else {
            $response = [
                'message' => 'Failed'
            ];        
        }
        return response()->json($response); 
    }

    public function show($id)
    {
        // Viewing a single task
        $task = Task::find($id);
        if ($task) {
            $response = [
                'message' => 'Successful',
                'task' => $task,
            ];
        } else {
            $response = [
                'message' => 'Task Does Not Exist'
            ];        
        }
        return response()->json($response);  
    }

    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        // Check if status is available
        $allowedStatuses = ['pending', 'completed', 'cancelled'];
        if (!in_array($request->status, $allowedStatuses)) {
            return response()->json(['error' => 'Invalid status provided'], 422);
        }

        if ($task) {
            $task->update(['status' => $request->status]);
            $response = [
                'message' => 'Status Changed To '.$request->status,
                'task' => $task,
            ];
        } else {
            $response = [
                'message' => 'Task Does Not Exist'
            ];        
        }
        return response()->json($response);
    }

    public function taskStatus($status) 
    {
        // Check if status is available
        $allowedStatuses = ['pending', 'completed', 'cancelled'];
        if (!in_array($status, $allowedStatuses)) {
            return response()->json(['error' => 'Invalid status provided'], 422);
        }

        $tasks = Task::where('status', $status)->get();
        if ($tasks->isEmpty()) {
            $response = [
                'message' => 'Tasks With Status '.$status.' Does Not Exist'
            ];        
        } else {
            $response = [
                'message' => 'Successful',
                'tasks' => $tasks,
            ];
        }
        return response()->json($response);
    }

    public function deleteTasks()
    {
        $tasks = Task::all();

        foreach ($tasks as $task) {
            $task->delete();
        }
        $response = [
            'message' => 'All tasks deleted successfully'
        ];
        return response()->json($response);
    }

    public function delete($id)
    {
        // Delete single Task
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            $response = [
                'message' => 'Task Deleted Successfully'
            ];
        } else {
            $response = [
                'message' => 'Task Does Not Exist'
            ];        
        }
        return response()->json($response);
    }
}
