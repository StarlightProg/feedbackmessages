<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use App\Mail\SendMessageMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Message;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Storage;

class GetMessagesController extends Controller
{
    public function __invoke()
    {
        //return view('gett');
        return redirect()->route('home')->with('messages',Message::all());
    }
}
