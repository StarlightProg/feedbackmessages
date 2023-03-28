<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public static $paginate_sort_desc = 'false';

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
        $messages = $this->set_user_data($messages);
        
        // @ts-ignore
        if(Auth::user()->can('read posts')){
            return view('home')->with('messages',$messages);
        }
        
        return view('home');
    }

    public function fetch_data(Request $request)
    {
        if ($request->ajax()) 
        {         
            $messages = $this->get_messages($request);
            $messages = $this->set_user_data($messages);

            return view('pagination', compact('messages'))->render();
        }
    }

    public function pagination_amount(Request $request){
        if ($request->ajax()) 
        {
            session('paginateAmount', $request->amount);

            $messages = $this->get_messages($request);
            $messages = $this->set_user_data($messages);

            return view('pagination', compact('messages'))->render();
        }
    }

    public function pagination_sort(Request $request){
        if ($request->ajax()) 
        {
            session(['paginate_sort_desc' => $request->desc]);
            
            $messages = $this->get_messages($request);             
            $messages = $this->set_user_data($messages);

            return view('pagination', compact('messages'))->render();
        }
    }

    public function home(){
        return redirect()->route('home');
    }

    public function download_file(){
        if(isset($_GET['file'])){
            return Storage::download("public/".$_GET['file']);
        }
    }

    private function get_messages(Request $request){
        if(session('paginate_sort_desc') == 'true'){
            $messages = Message::orderBy('created_at','DESC')->paginate($request->amount);
        }
        else{
            $messages = Message::paginate($request->amount);
        }
        return $messages;
    }

    private function set_user_data($messages){
        $users = User::all();

        foreach ($messages as $message) {
            $user = $users[$message->user_id - 1];
            $message->user_id = $user->id;
            $message->user_name = $user->name;
            $message->user_email = $user->email;
            $message->user_created_at = $user->created_at;
        }

        return $messages;
    }
}
