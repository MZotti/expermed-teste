<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Upload;
use App\Http\Requests\UploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    private $upload;

    public function __construct(Upload $upload)
    {   
        $this->upload = $upload;
    }

    public function UploadFile(UploadRequest $request)
    {
        $data = $request->file('files');

        if(isset($data)){

            foreach($data as $key => $file){

                $extension = $file->getClientOriginalExtension();
                $filename = uniqid().'.'.$extension; 
                $path = Storage::disk('local')->putFileAs('public/data/in', $file, $filename);

            } 
        }
    }
}
