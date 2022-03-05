<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\MessageSent;
use App\Events\GreetingSent;
use Illuminate\Http\Request;

class ChatController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /** showChat
     * @return [view]
     */
    public function showChat(){

        return view('chat.show');
    }

    /** messageRecieve
     * @param Request $request
     * 
     * @return [json]
     */
    public function messageRecieve(Request $request){
        $rules = ['message'=>'required'];
        $request->validate($rules);
        broadcast(new MessageSent($request->user(), $request->message));
        return response()->json('Message BroadCasted');
    }

    public function greetRecieved(Request $request, $id)
    {
        $user = User::find($id);
        broadcast( new GreetingSent( $user, "{$request->user()->name} greeted You") );
        broadcast( new GreetingSent( $request->user(), "You greeted {$user->name}" ) );
        return  "Greeting {$user->name} from {$request->user()->name}";
    }
    
}
