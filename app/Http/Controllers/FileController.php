<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use \Exception;

use App\EncryptDecryptClass\EncryptDecrypt;
class FileController extends Controller
{

    public static function createNewFile($userId, $fileName, $key){
        $newFile = File::create([
            'file_name' => $fileName,
            'file_key' => $key,
            'file_user_id' => $userId ,
            ]);
            return $newFile->file_id;
    }

    public static function getFilesData($userId){
        $files = File::where('file_user_id', $userId)->get();
        $output = array();
        if($files){
            foreach($files as $file){
                if($file->file_status == 1){
                    $status = "Encrypted";
                    $mirror = "Decrypt";
                    $url = "decrypt";
                }else{
                    $status = "Decrypted";
                    $mirror = "Encrypt";
                    $url = "encrypt";
                }
                    
                $data = array(
                    'file_id' => $file->file_id,
                    'file_name' => $file->file_name,
                    'file_status' => $status,
                    'mirror' => $mirror,
                    'url' => $url
                );
                array_push($output, $data);
            }
        }
        return $output;
    }

    public static function getPlanText($filePath){
        if (file_exists($filePath)) {
            $file = fopen($filePath, "r");
            $contents = file_get_contents($filePath);
            return $contents; 
        }
    }

    public static function encryptFile($fileName, $userId, $id = 0){
        $decodePath = public_path(). '/' . $userId . '/decoding/';
        $newPath = public_path(). '/' . $userId . '/encoding/';
        $data = self::getPlanText($decodePath . $fileName);
        $encrypt = new EncryptDecrypt();
        $encrypted = $encrypt->encrypt($data);
        $key = $encrypt->getKey();
        $iv = $encrypt->getIv();

        if (!is_dir($newPath)) {
            mkdir($newPath);
        }
        file_put_contents($newPath . $fileName , $encrypted);
        if (file_exists($decodePath. $fileName)) {
            unlink($decodePath . $fileName);
        }

        if (!is_dir(public_path(). '/lock/')) {
            mkdir(public_path(). '/lock/');
        }

        if (!is_dir($newPath)) {
            mkdir($newPath);
        }

        if($id !== 0){
            $fileId = self::updateFile($id, $key);
            $lastIv = public_path(). '/lock/' . $id . '.txt';
            if (file_exists($lastIv)) {
                unlink($lastIv);
            }
 
            $ivLocation = public_path(). '/lock/' . $fileId . '.txt';
            file_put_contents($ivLocation , $iv);
            return self::getFilesData($userId);
        }else{
            $fileId = self::createNewFile($userId, $fileName, $key);
            $ivLocation = public_path(). '/lock/' . $fileId . '.txt';
            file_put_contents($ivLocation , $iv);
        }
        return "Sucsess"; 
    }

    public static function decryptFile($userId, $fileId){
        $file = File::where('file_id', $fileId)->first();
        if($file){
            $fileName = $file->file_name;
            $filePath = public_path(). '/' . $userId . '/encoding/'. $fileName;
            $data = self::getPlanText($filePath);
        }

        $ivLocation = public_path(). '/lock/' . $fileId . '.txt';
        $iv = self::getPlanText($ivLocation);
        
        
        $decrypt = new EncryptDecrypt();
        $fileContent = $decrypt->decrypt($data, $file->file_key, $iv);
       
        $decodePath = public_path(). '/' . $userId . '/decoding/';
        if (!is_dir($decodePath)) {
            mkdir($decodePath);
        }
       
        file_put_contents($decodePath . $fileName , $fileContent);

        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $file->file_status = 0;
        $file->save();
        return self::getFilesData($userId);
    }


    public static function updateFile($fileId, $key){
        $file = File::where('file_id', $fileId)->first();
        if($file){
            $file->file_key = $key;
            $file->file_status = 1;
            $file->save();
        }
        return $fileId;
    }


    public static function isOpenableFile($fileName, $userId){
        try{
            $filePath = public_path(). '/' . $userId . '/decoding/'. $fileName;
            $file = fopen($filePath, "r");
            $contents = file_get_contents($filePath);
            fclose($file);

            return true;
        }catch (Exception $e){
            return "This extension is not a valid to open";
        }
    }

    public static function fileData($file, $userId, $validate){
        $Size = $file->getSize();
        $fileSize = number_format($Size / 1048576,2);
        if($fileSize > 1){
            $fileSize = $fileSize . "MB";
        }else if($fileSize > 0){
            $fileSize = $fileSize . "KB";
        }else{
            $fileSize = $fileSize;
        }
        $fileName = $file->getClientOriginalName();
        $file->move(public_path(). '/' . $userId . '/decoding/', $fileName);
        $data = array(
            'fileName' => $file->getClientOriginalName(),
            'fileExtension' => $file->getClientOriginalExtension(),
            'fileSize' => $fileSize
        );
        
        if($validate === true){
            $data['isOpenableFile'] = self::isOpenableFile($fileName, $userId);
        }else{
            $data['isOpenableFile'] = "This extension is not a valid to open";
        }
        

        return $data;
    }

    public static function getFileName($fileId){
        $fileName = File::select('file_name')->where('file_id', $fileId)->first();
        if($fileName){
            return $fileName->file_name;
        }
        return 0;
    }
    public static function downloadFile($code, $fileId){
        $file = File::where('file_id', $fileId)->first();
        if($file){
            return $path = public_path(). '/' . $file->file_user_id . '/' . $code . '/' .$file->file_name;
        }
    }
}
