<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /* public function index()
    {
        return Task::all();
    }*/

    public function index()
    {
        $tasks = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('users', 'users.id', '=', 'tasks.developer_id')
            ->select('users.name', 'users.lname', 'users.image', 'projects.title as title', 'tasks.*')
            ->get();

        return ($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request, $id)
    {
        $file = $request->file('task');
        $task = new Task();

        if ($request->hasFile('task')) {
            $fileName = $file->getClientOriginalName();
            $file->move(public_path('/storage/Tasks'), $fileName);
            $task->file = $fileName;
        }
        $task->text = $request->description;
        $task->developer_id = $id;
        $task->project_id = $request->project_id;
        $task->owner_id = $request->owner_id;
        $task->submitted = $request->submitted;

        $task->save();
    }
    public function download($fileName)
    {
        return response()->download(public_path('/storage/Tasks/' . $fileName));
    }

    function makeAccepted( $id)
    {
        // $task = new Task() ;
        // $task = Task::where($project_id) ;
        $task = Task::where('project_id', $id)->update(['accepted' => 1]);
        return $task ;
         

        // $task->accepted = 1;
        // $task->save();
        // return $task ;

    }






    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /* public function show($id)
    {
        return project::find($id);
    }*/

    public function getTask($id)
    {
        $task = Task::join('projects', 'tasks.project_id', '=', 'projects.id')
            ->join('users', 'users.id', '=', 'tasks.developer_id')
            ->where('tasks.project_id', $id)
            ->select('users.name', 'users.lname', 'users.image', 'projects.title as title', 'tasks.*')
            ->first();
        return $task;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {

        $task = Task::find($id);
        return $task->update($request->all());
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Task::destroy($id);
    }
}
