<?php
namespace App\Traits;

use Flasher\Laravel\Http\Request;
use Illuminate\Support\Facades\Storage;

trait StorageImageTrait{
    public function storageTraitUpload($request,$fieldName,$foderName){

        if($request->hasFile($fieldName)){
            $file = $request->$fieldName;
            $fileNameOrigin = $file->getClientOriginalName();
            $fileNameHash = str_random(20) . '.' . $file->getClientOriginalExtension();
            $filePath = $request->file($fieldName)->storeAs('public/'. $foderName .auth()->id(),$fileNameHash);
            // return $path;
            $dataUploadTrait = [
                'file_name'=> $fileNameOrigin,
                'file_path' =>Storage::url($filePath),
            ];
            return $dataUploadTrait;
        }
        return null;

    }
    public function storageTraitUploadMutiple($file,$foderName){
        $fileNameOrigin = $file->getClientOriginalName();
        $fileNameHash = str_random(20) . '.' . $file->getClientOriginalExtension();
        $filePath = $file->storeAs('public/'. $foderName .auth()->id(),$fileNameHash);
        // return $path;
        $dataUploadTrait = [
            'file_name'=> $fileNameOrigin,
            'file_path' =>Storage::url($filePath),
        ];
        return $dataUploadTrait;
    }
}