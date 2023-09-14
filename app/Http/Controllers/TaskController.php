<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class TaskController extends Controller
{


    public function index()
    {
        $tasks = $this->getTasks();

        return view('tasks.index', compact('tasks'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:100',
        ]);

        $tasks = $this->getTasks();
        $tasks[] = [
            'title' => $validatedData['title'],
            'date_added' => now()->toDateTimeString(),
        ];

        $this->saveTasks($tasks);

        $response = [
            'title' => $validatedData['title'],
            'index' => count($tasks) - 1,
            'message' => 'Task added successfully.',
        ];

        return response()->json($response);
    }
    public function destroy($id)
    {
        $tasks = $this->getTasks();

        if (isset($tasks[$id])) {
            $deletedTask = $tasks[$id];
            unset($tasks[$id]);
            $this->saveTasks($tasks);

            $response = [
                'message' => 'Task deleted successfully.',
                'deletedTask' => $deletedTask,
            ];

            return response()->json($response);
        } else {
            $response = [
                'error' => 'Task not found.',
            ];

            return response()->json($response, 404);
        }
    }

    private function getTasks()
    {
        $tasksJson = Storage::get('tasks.json');
        $tasks = json_decode($tasksJson, true);

        return $tasks ?? [];
    }

    private function saveTasks($tasks)
    {
        $tasksJson = json_encode($tasks);
        Storage::put('tasks.json', $tasksJson);
    }
}
