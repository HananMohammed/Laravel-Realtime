<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
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

    
}
