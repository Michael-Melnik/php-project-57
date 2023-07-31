<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\{AllowedFilter, QueryBuilder};
use App\Models\{Task, TaskStatus, User, Label};
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])->orderBy('id')->paginate(10);
        $taskStatusesForFilterForm = TaskStatus::pluck('name', 'id');
        $usersForFilterForm = User::pluck('name', 'id')->sort();
        $filterQueryString = $request->input('filter');

        return view('task.index', compact(
            'tasks',
            'taskStatusesForFilterForm',
            'usersForFilterForm',
            'filterQueryString'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Task::class);
        return view('task.create', [
            'task' => new Task(),
            'taskStatuses' => TaskStatus::all(),
            'labels' => Label::all(),
            'users' => User::all(),
            'taskLabels' => [],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $this->validate(
            $request,
            [
                'name' => 'required|unique:tasks',
                'status_id' => 'required|exists:task_statuses,id',
                'description' => 'nullable|string',
                'assigned_to_id' => 'nullable|exists:users,id',
                'labels' => 'nullable|array'
            ],
            [
                'name.unique' => __('validation.task.unique')
            ]
        );

        $currentUser = Auth::user();
        $task = $currentUser->createdTasks()->make($validated);
        $task->save();
        if (array_key_exists('labels', $validated) && !is_null($validated['labels'][0])) {
            $task->labels()->sync($validated['labels']);
        }

        flash(__('flashes.tasks.store.success'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $users = User::all();
        $taskStatuses = TaskStatus::all();
        $labels = Label::all();
        return view('task.edit', compact('task', 'users', 'taskStatuses', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $validated = $this->validate(
            $request,
            [
                'name' => 'required|unique:tasks,name,' . $task->id,
                'description' => 'nullable|string',
                'assigned_to_id' => 'nullable|integer',
                'status_id' => 'required|integer',
            ],
            [
                'name.unique' => __('validation.task.unique')
            ]
        );

        $task->fill($validated);
        $task->save();
        if (($request->input('labels')) !== null) {
            $labelId = array_filter($request->input('labels'));
            $task->labels()->attach($labelId);
        }
        flash(__('flashes.tasks.updated'))->success();

        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->labels()->detach();
        $task->delete();
        flash(__('flashes.tasks.deleted'))->success();

        return redirect()->route('tasks.index');
    }
}
