<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\TasksResource;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TasksResource::collection(
            // the 'user_id' in the Task table needs to be equal to the authenticated user; then grab this user id and get him.
            Task::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return TasksResource
     */
    public function store(StoreTaskRequest $request)
    {
        // here we are validating the data coming from the request
        $request->validated($request->all());

        // once the validation has passed, we want to define a new task
        $task = Task::create([
            'user_id' => Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority
        ]);

        // now once a task has been created we got to return a new TasksResource which is in json format,
        // and we are going to pass in the variable of $task, so that the created task will be shown to
        // the user once the data has been submitted
        return new TasksResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return TasksResource|\Illuminate\Http\JsonResponse
     */
    public function show(Task $task)
    {
        // check if the authenticated user is not equal to the $task->user_id
        // if it isn't, return an error message
        if (Auth::user()->id !== $task->user_id)
        {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
        return new TasksResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return TasksResource|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        if (Auth::user()->id !== $task->user_id)
        {
            return $this->error('', 'You are not authorized to make this request', 403);
        }

        $task->update($request->all());
        return new TasksResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
