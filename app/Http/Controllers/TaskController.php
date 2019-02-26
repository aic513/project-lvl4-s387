<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Task;
use App\TaskStatus;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::paginate(5);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statuses = TaskStatus::all();
        $executors = User::all();
        $tags = Tag::all();

        return view('tasks.create', [
            'statuses' => $statuses,
            'executors' => $executors,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status()->associate(TaskStatus::find($request->status_id));
        $task->creator()->associate(Auth::user());
        $task->assignedTo()->associate(User::find($request->assigned_to_id));
        $task->save();

        flash("Task # {$task->id} created successfully!")->success()->important();

        return redirect()->route('task.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        $statuses = TaskStatus::all();
        $executors = User::all();
        $tags = Tag::all();

        return view('tasks.edit', compact('task', 'statuses', 'executors', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task = Task::findOrFail($id);
        $assignedUser = User::find($request->assigned_to_id);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status()->associate(TaskStatus::find($request->status_id));
        $task->assignedTo()->associate($assignedUser);
        $task->save();
        flash("Task # {$task->id} updated successfully!")->success()->important();

        return redirect()->route('task.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        $task->delete();
        flash('Task - ' . $task->name . ' deleted successfully!')->warning()->important();

        return redirect()->route('task.index');
    }
}
