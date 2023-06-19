<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MessageService;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function downloadFile(){
        if(isset($_GET['file'])){
            return Storage::download("public/".$_GET['file']);
        }
    }
}
