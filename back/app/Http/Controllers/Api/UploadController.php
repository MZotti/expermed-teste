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

            $wrongFiles = [];

            foreach($data as $key => $file){
                $extension = $file->getClientOriginalExtension(); // Recebe a extensão do arquivo para validar    

                if($extension != 'dat') // Se a extensão for diferente de .dat, popula o array com arquivos inválidos
                    $wrongFiles[] = $file->getClientOriginalName();
            }

            if(count($wrongFiles) > 0){ // Se o array de arquivos inválidos estiver populado, retorna um erro para o cliente
                return response()->json([
                    'msg' => 'Só devem ser upados arquivos no format .dat!',
                    'data' => $wrongFiles
                ], 422);
            }else{ // Se o array de arquivos inválidos não estiver populado, realiza o upload da requisição

                foreach($data as $key => $file){
                    $extension = $file->getClientOriginalExtension();
                    $filename = uniqid().'.'.$extension; 
                    $path = Storage::disk('local')->putFileAs('public/data/in', $file, $filename);
                    
                }

                $this->upload->ReadFiles();

                return response()->json([
                    'data' => [
                        'msg' => 'Arquivo(s) upado(s)!'
                    ]
                ], 200);
            }
            
        }
    }
}
