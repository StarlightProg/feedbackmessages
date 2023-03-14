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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request)
    {
        $rules = [
            'theme' => 'required|string',
            'message' => 'required|string',
            'file' => 'required|max:3078'
        ];

        $validator = Validator::make($request->all(), $rules);
        $extension = $request->file('file')->getClientOriginalExtension();

        $userMessages = Message::where('user_id',Auth::user()->id)->get();

        if(!$userMessages->isEmpty()){
            if($userMessages->last()->created_at->diffInDays(now()) == 0){
                return redirect()->route('home')->withErrors(["Только одна заявка в день!"]);
            }
        }

        if ($extension == 'bat' || $extension == 'jar' || $extension == 'exe')
        {
            $messages = $validator->messages();
            return redirect()->route('home')->withErrors(["Нельзя использовать расширение {$extension}"]);
        }

        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;
        if($request->file('file')){
            $name = md5(uniqid()).'.'.$request->file('file')->getClientOriginalExtension();           
            Storage::putFileAs('/public',$request->file('file'),$name);
            $data['file'] = Storage::url($name);
        }

        //Отправка письма на почту
        //Mail::to('')->queue(new SendMessageMail($data));

        Message::firstOrCreate($data);
        return redirect()->route('home');
    }
}
