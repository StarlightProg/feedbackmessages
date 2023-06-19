<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MailService;
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
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function store(StoreRequest $request)
    {       
        $userMessages = Message::where('user_id',Auth::user()->id)->get();

        $extensionError = $this->checkExtension($request);
        $postLimitError = $this->checkPostLimit($userMessages);

        if(!empty($extension)){
            return redirect()->route('home')->with('data',[$request->theme,$request->message])->withErrors([$extensionError]); 
        };
        
        if(!empty($postLimitError)){
            return redirect()->route('home')->with(['data'=>[$request->theme,$request->message]])->withErrors([$postLimitError]);
        };

        $data = $request->validated();
        $data['user_id'] = Auth::user()->id;

        $name = $this->saveFile($request->file('file'));
        
        $data['file'] = $name;

        $this->sendMail($data, $name);

        Message::firstOrCreate($data);
        return redirect()->route('home')->with(['success' => 'success']);
    }

    private function checkExtension(Request $request){
        $extension = $request->file('file')->getClientOriginalExtension();

        if ($extension == 'bat' || $extension == 'jar' || $extension == 'exe')
        {
            return "Нельзя использовать расширение {$extension}";
        }
    }

    private function checkPostLimit($messages){
        if(!$messages->isEmpty()){
            if($messages->last()->created_at->diffInDays(now()) == 0){
                return "Только одна заявка в день";
            }
        }
        
        return null;
    }

    private function saveFile($file){
        $name = md5(uniqid()).'.'.$file->getClientOriginalExtension();           
        Storage::putFileAs('/public',$file,$name);
        
        return $name;
    }

    public function sendMail(array $data, string $name)
    {
        $this->mailService->sendMail($data, $name);
    }
}
