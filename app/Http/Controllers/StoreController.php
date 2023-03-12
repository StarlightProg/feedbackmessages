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
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        //dd($_FILES);
        $data = $request->validated();
        //dd(Auth::user()->id);
        $data['user_id'] = Auth::user()->id;
        if($request->file('file')){
            $name = md5(uniqid()).'.'.$request->file('file')->getClientOriginalExtension();
            $data['file'] = $name;
            Storage::putFileAs('/messages',$request->file('file'),$name);
        }
        //Mail::to('942003@bk.ru')->queue(new SendMessageMail($data));
        Message::firstOrCreate($data);
        return redirect()->route('home');
    }
}
