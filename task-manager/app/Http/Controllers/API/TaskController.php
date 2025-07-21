<?php

namespace App\Http\Controllers\API;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TaskController extends Controller
{
    public function index() { return Task::where('user_id', auth()->id())->get(); }
    public function store(Request $request) {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'status' => 'in:todo,in_progress,done',
            'due_date' => 'nullable|date',
            'priority' => 'integer|min:1|max:5'
        ]);
        $data['user_id'] = auth()->id();
        return Task::create($data);
    }

    public function show(Task $task) {
        $this->authhorize('view', $task);
        return $task;
    }

    public function update(Request $request, Task $task) {
        $this->authorize('update', $task);
        $task->update($request->only(['title', 'descrption', 'status', 'due_date', 'priority']));
        return $task;
    }

    public function destroy(Task $task) {
        $this->authorize('delete', $task);
        $task->delete();
        return response()->noContent();
    }
}
