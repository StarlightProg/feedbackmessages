<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Services\MessageService;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    //public static $paginate_sort_desc = 'false';
    private $messageService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessageService $messageService)
    {
        $this->middleware('auth');
        $this->messageService = $messageService;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {    
        // @ts-ignore
        if(Auth::user()->can('read posts')){

            $messages = $this->messageService->getMessages(); 

            return view('home')->with('messages',$messages);
        }
        
        return view('home');
    }

    public function home(){
        return redirect()->route('home');
    }

}
