<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;




class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        $user['projectProcesses'] = Project::where('developer_id', $user->id)->where('status', 'processing')->count();
        // $user->projectDevelopers->where('status', 'processing')->count()

        $user['projectDone'] = Project::where('developer_id', $user->id)->where('status', 'done')->count();
        // $user->projectClients->where('status', 'done')->count()

       /* $projects = Project::where('developer_id', $user->id)->count();

        $user['projectDonePercent'] = ($user['projectDone'] / $projects) * 100;
        $user['projectProcessesPercent'] = ($user['projectProcesses'] / $projects) * 100;

        $user['avrRate'] = (int)Project::where('developer_id', $user->id)->avg('rate');*/

        return $user;
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
        $user = User::find($id);
        return $user->update($request->except('image'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return User::destroy($id);
    }


    public function getDevelopers(){
        $users = User::join('categories', 'users.category_id', '=', 'categories.id')
        ->join('reviews' , 'users.id' , '=' , 'reviews.ratee_id')
        ->select('users.*', 'categories.name')
        ->where('users.type','developer')
        ->orderBy('reviews.rate', 'DESC')
        ->limit(4)
        ->get();

        return $users  ;
    }



    public function getCategory($user_id){
        return User::select('category_id')->where('id',$user_id)->get();
    }


}
