<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $messages = Message::paginate(10);
        
        
        foreach ($messages as $message) {
            $user = User::where('id',$message->user_id)->get()[0];
            $message->user_id = $user->id;
            $message->user_name = $user->name;
            $message->user_email = $user->email;
            $message->user_created_at = $user->created_at;
        }
        
        if(Auth::user()->is_moderator){
            return view('home')->with('messages',$messages);
        }
        
        return view('home');
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) 
        {
            $messages = Message::paginate($request->amount);

            foreach ($messages as $message) {
                $user = User::where('id',$message->user_id)->get()[0];
                $message->user_id = $user->id;
                $message->user_name = $user->name;
                $message->user_email = $user->email;
                $message->user_created_at = $user->created_at;
            }

            return view('pagination', compact('messages'))->render();
        }
    }

    public function pagination_amount(Request $request){
        if ($request->ajax()) 
        {
            $messages = Message::paginate($request->amount);

            foreach ($messages as $message) {
                $user = User::where('id',$message->user_id)->get()[0];
                $message->user_id = $user->id;
                $message->user_name = $user->name;
                $message->user_email = $user->email;
                $message->user_created_at = $user->created_at;
            }

            return view('pagination', compact('messages'))->render();
        }
    }

    public function pagination_sort(Request $request){
        if ($request->ajax()) 
        {
            if($request->desc == 'true'){
                $messages = Message::orderBy('created_at','DESC')->paginate($request->amount);
            }
            else{
                $messages = Message::paginate($request->amount);
            }
              
            foreach ($messages as $message) {
                $user = User::where('id',$message->user_id)->get()[0];
                $message->user_id = $user->id;
                $message->user_name = $user->name;
                $message->user_email = $user->email;
                $message->user_created_at = $user->created_at;
            }

            return view('pagination', compact('messages'))->render();
        }
    }

    public function home(){
        return redirect()->route('home');
    }
}
