<?php

namespace App\Http\Controllers;

use App\Services\MessageService;
use Illuminate\Http\Request;

class PaginationController extends Controller
{
    private $messageService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MessageService $messageService)
    {
        session(['paginateAmount' => 10]);
        session(['paginate_sort_desc' => false]);
        
        $this->messageService = $messageService;
    }

    public function fetchData(Request $request)
    {
        if ($request->ajax()) 
        {         
            $messages = $this->messageService->getMessages($request);

            return view('pagination', compact('messages'))->render();
        }
    }

    public function paginationAmount(Request $request){
        if ($request->ajax()) 
        {
            session(['paginateAmount' => $request->amount]);

            $messages = $this->messageService->getMessages($request);
            return view('pagination', compact('messages'))->render();
        }
    }

    public function paginationSort(Request $request){
        if ($request->ajax()) 
        {
            session(['paginate_sort_desc' => !session('paginate_sort_desc')]);
            
            $messages = $this->messageService->getMessages($request);

            return view('pagination', compact('messages'))->render();
        }
    }
}
