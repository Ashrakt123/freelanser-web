<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $message = Message::join('users' , 'users.id' , '=' , 'messages.sender_id')
        ->select('messages.*' , 'users.fname' , 'users.lname')
        ->get();

        return $message;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        return Message::create($request->all());
    }

    public function getmessage($id1 , $id2)
    {

        $message = Message::where(function ($query ) use($id1 , $id2) {
            $query->where('sender_id', $id1)
                ->where('reciever_id', $id2);
        })->orWhere(function($query) use ($id1 , $id2) {
            $query->where('sender_id', $id2)
            ->where('reciever_id', $id1);	
        });
        
        $message = $message->join('users as sender' , 'messages.sender_id' , '=' , 'sender.id')
        ->join('users as reciever' , 'messages.reciever_id' , '=' , 'reciever.id')
        ->select('messages.*' , 'reciever.fname' , 'reciever.lname')
        ->get();

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
