<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
header('Access-Control-Allow-Origin: *');

class ProjectController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $project = Project::join('categories', 'projects.category_id', '=', 'categories.id')
            ->join('users', 'users.id', '=', 'projects.owner_id')
            ->select('users.name', 'users.lname','users.type','users.email','users.image as avatar','users.rate as user_rate','categories.name as cat_name', 'projects.*')
            ->get();

        return $project;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
        // return project::create($request->all());
        $file = $request->file('file');
        $project = new Project() ;

        if($request->hasFile('file')){
            $fileName=$file->getClientOriginalName() ;
            $file->move(public_path('/storage/projects/files'),$fileName) ;
            $project->file = $fileName ;
        }
            $project->title = $request->title;
            $project->description = $request->description;
            $project->budget = $request->budget;
            $project->location =  $request->location;
            $project->category_id = $request->categeory;
            $project->owner_id = $id ;
            $project->save();
        }

        public function download($fileName){
            return response()->download(public_path('/storage/projects/files/'.$fileName));
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
   public function gettProject($id)
    {
        $project = Project::join('categories', 'projects.category_id', '=', 'categories.id')
            ->join('users', 'users.id', '=', 'projects.owner_id')
            ->where('projects.id', $id)
            ->select('users.name', 'users.lname','users.image as avatar','users.rate as user_rate','categories.name as cat_name', 'projects.*')
            ->first();
        return $project;
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
        $project = project::find($id);
        $project->update($request->all());
        return $project ;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return project::destroy($id);
    }

    public function getMostProjects()
    {
        $projects = Project::join('categories', 'projects.category_id', '=', 'categories.id')
            ->join('users', 'users.id', '=', 'projects.developer_id')
            ->join('reviews' , 'projects.id' , '=' , 'reviews.project_id')
            ->select('users.name', 'users.lname', 'categories.name as cat_name', 'projects.*' , 'reviews.rate as project_rate')
            ->orderBy('reviews.rate')
            ->limit(3)
            ->get();

        return ($projects);
    }

    //get count of projects
    public function count($id, $status)
    {
        $count = project::where('developer_id', $id)->where('status', $status)->count();
        return $count;
    }

    //get active projects related with the developer
    public function active($id)
    {
        return DB::table('projects')->where('developer_id', $id)->where('projects.status','processing')->get();
    }

    public function recent($category_id)
    {
        $projects = Project::join('users', 'projects.owner_id', '=', 'users.id')
        ->where('projects.category_id', $category_id)
        ->where('projects.status', 'pending')
        ->select('projects.id','projects.title' ,'projects.description','projects.created_at','users.image' , 'users.name','users.lname' )
        ->limit(5)
        ->get();

        return $projects ;
    }


}
