<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ValidateorController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Response;

use Auth;


class HomeController extends Controller
{

    public function __construct()
    {
        $key = env('CUSTOM_VARIABLE');
      
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function fileUpload(Request $request){
        $validate = ValidateorController::validateFile($request);
        switch ($request->input('submit')) {
            case 'Encrypt':
                $data = FileController::encryptFile($request->input('file'), Auth::id());
                $true = 1;
                return view('home', compact('true'));
                
            case 'Encrypted files':
                return redirect('encrypted-page'); 
            default:
                if($validate === 0 || $validate === true){
                    $file = $request->file('file');
                    $data = FileController::fileData($file, Auth::id(), $validate);
                    return view('home', compact('data'));
                }else{
                     return view('error');  
                }
        }
    }

    public function fileEncrypted(){
        $data = FileController::getFilesData(Auth::id());
        
        return view('encrypted-page', compact('data'));
    }

    public function decrypt($file_id){
        $data = FileController::decryptFile(Auth::id(), $file_id);   
        return view('encrypted-page', compact('data'));
    }

    public function encrypt($file_id){
        $fileName = FileController::getFileName($file_id);
        if($fileName !== 0){
            $data = FileController::encryptFile($fileName, Auth::id(), $file_id);
            return view('encrypted-page', compact('data'));
        }
        return view('error');
    }
    public function download(){

    }

    public function fileDownload($code, $fileId){
        $filePath = FileController::downloadFile($code, $fileId);
        if (file_exists($filePath)) {
            return response()->download($filePath);
        }
    }
}
