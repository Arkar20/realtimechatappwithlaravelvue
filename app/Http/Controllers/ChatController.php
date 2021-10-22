<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Providers\Events\ChatEvent;

class ChatController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
   public function index()
   {
    view('welcome');   
   }
   public function store(Request $request)
   {
      
      $sendMessage =event(new ChatEvent($message=$request->message,$user=$request->user));
   }
   public function storechatmsg(Request $request)
   {
       $data=[
         "message"=>$request->message,
         "user"=>$request->user
      ];
        $request->session()->push('chat', $data);   

      return $request->session()->get('chat');
   }
}
