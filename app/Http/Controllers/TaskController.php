<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
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
        $tasks = TaskService::getListAndFilterTasks();
        $users = User::has('AssignedTasks')->get();
        $tags = Tag::has('tasks')->get();
        $statuses = TaskStatus::has('tasks')->get();
        if (empty($tasks)) {
            flash('No records found')->warning()->important();
        }

        return view('tasks.index', [
            'tasks' => $tasks,
            'users' => $users,
            'tags' => $tags,
            'statuses' => $statuses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $executors = User::all();

        return view('tasks.create', compact('executors'));
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
        $tagsStr = TaskService::getValidTagString($request->tags_string);
        try {
            $tagsIds = TaskService::getTagsIdsFromStr($tagsStr);
        } catch (\Exception $e) {
            flash($e->getMessage())->error()->important();

            return back();
        }
        $task = new Task();
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status()->associate(TaskStatus::find(TaskStatus::NEW_STATUS_ID));
        $task->creator()->associate(Auth::user());
        $task->assignedTo()->associate(User::find($request->assigned_to_id));
        $task->save();
        $task = Task::find($task->id);
        $task->tags()->attach($tagsIds);

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

        return view('tasks.edit', compact('task', 'statuses', 'executors'));
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
        $tagsStr = TaskService::getValidTagString($request->tags);
        $tagsIds = TaskService::getTagsIdsFromStr($tagsStr);
        $task->name = $request->name;
        $task->description = $request->description;
        $task->status()->associate(TaskStatus::find($request->status_id));
        $task->assignedTo()->associate($assignedUser);
        $task->tags()->sync($tagsIds);
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
        $task = Task::findOrFail($id);
        $task->tags()->detach();
        $task->delete();
        flash('Task - ' . $task->name . ' deleted successfully!')->warning()->important();

        return redirect()->route('task.index');
    }
}
