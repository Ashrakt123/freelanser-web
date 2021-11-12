<?php

namespace App\Http\Controllers;

use App\Events\Messages;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChatController extends Controller
{
    public function message(Request $request , $reciever_id){
        // if(!Auth::check()){
        //     return response('Forbidden', 403);
        // }
        // $newMessage = new Message();
        // $newMessage->sender_id = Auth::id();
        // $newMessage->message = $request->message;
        // $newMessage->reciever_id = $reciever_id;
        // $newMessage->save();
        
        event(new Messages($request->input('message') , $request->input('sender_id'), $request->input('reciever_id') , $request->input('username')));

        // broadcast(new Messages($request->input('reciever_id') , $request->input('message'), $request->input('sender_id')))->toOthers();

        // $this->pusher->trigger('private-chat' . $reciever_id, 'message', $newMessage);
        $newMessage =  Message::create($request->all());
        
        return $newMessage;
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
        ->select('messages.*' , 'sender.username')
        ->get();

        return $message;
    }

    // public function authorizeUser(Request $request) {
 
    //     $fields = $request->validate ([
    //         'email' => ['required', 'string', 'email'],
    //         'password' => ['required', 'string', 'min:8'],
    //     ]);

    //     $user=User::where('email', $fields['email'])->first();
    //     if(!$user || !Hash::check($fields['password'], $user->password)){
    //         return response([
    //             'message'=>"Unauthorised"
    //         ],401);

    //     }
     
    //     echo pusher->socket_auth(
     
    //         $request->input('channel_name'), 
     
    //         $request->input('socket_id')
     
    //     );

     
    // }

   
}
