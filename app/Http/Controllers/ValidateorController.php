<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ValidateorController extends Controller
{
    public static function validateFile($request){
        $validateData = Validator::make($request->all(),[
          'file' => 'required|file'
        ]);
        if ($validateData->fails()) {
            $errors = $validateData->errors();
            foreach($errors->all() as $error){
                $err = $error;
            break;
            }
            $output = array(
                'code' => 400,
                'message' => $err
            );
            return $output;
        }else{
            return self::validContent($request);
        }
      }

    public static function validContent($request){
        $validateData = Validator::make($request->all(),[
            'file' => 'mimes:txt'
        ]);
        if ($validateData->fails()) {
            return self::unvalidContent($request);
        }
        return true;
    }

    public static function unvalidContent($request){
        $validateData = Validator::make($request->all(),[
            'file' => 'mimes:jpeg,png,jpg,zip,pdf,ppt, pptx, xlx, xlsx,docx,doc,gif,webm,mp4,mpeg',
        ]);
        if($validateData->fails()){
            $errors = $validateData->errors();
            foreach($errors->all() as $error){
                $err = $error;
                break;
            }
            return $err;
        }
        return 0;
    }
/* 
      public static function CreateEmployeeEmail($request){
        $validateData = Validator::make($request->all(),[
            'file' => 'required|file|mimes:jpeg,png,jpg,zip,pdf,ppt, pptx, xlx, xlsx,docx,doc,gif,webm,mp4,mpeg|max:2048',
        ]);
        if($validateData->fails()){
            $errors = $validateData->errors();
            foreach($errors->all() as $error){
                $err = $error;
                break;
            }
            return $err;
        }
        return 0;
    }


      if($id == null)
      return self::CreateEmployeeEmail($request);
  else
      return self::EditEmployeeEmail($request, $id); */
}
