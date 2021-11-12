<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $catagories=Category::all();

        return  $catagories;
    }

    
    public function show($name){
        $users = User::join('categories', 'users.category_id', '=', 'categories.id')
        ->select('users.*', 'categories.name')
        ->where('users.type','developer')
        ->where('categories.name' ,$name)
        ->get();

        return $users  ;
    }
}
