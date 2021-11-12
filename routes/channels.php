<?php

use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\AuthController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat.{reciever_id}', function ($user, $reciever_id) {
    // $fields = $request->validate ([
    //     'email' => ['required', 'string', 'email'],
    //     'password' => ['required', 'string', 'min:8'],
    // ]);

    // $user=User::where('email', $fields['email'])->first();
    // if(!$user || !Hash::check($fields['password'], $user->password)){
    //     return response([
    //         'message'=>"Unauthorised"
    //     ],401);

    // }
//     if ($user->has(tokens())){
//         return ['id' => $user->id , 'name' =>$user->fname];
//     }
// });

// Broadcast::channel('user.{userId}', function ($user, $userId) {
//     return $user->id === $userId;
//   });
