<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if(!function_exists('hasRole'))
{
    //Check if authenticated user has role
    function hasRole($role) : bool
    {
        $user=User::find(auth()->user()->id);
        return $user->hasRole($role);
    }
}


if(!function_exists('uploadFile'))
{
    //Upload Single File
    function uploadFile($files,$prefix) : string
    {
        return $files->store('public/'.$prefix);
    }
}

if(!function_exists('uploadFiles'))
{
    //Upload an Array of Files
    function uploadFiles($newFiles,$prefix,$id,$oldFiles=null) : array
    {
        $filesPath=[];

        if($oldFiles) compareAndDeleteFiles($oldFiles,$newFiles);

        foreach($newFiles as $file){
            if($file instanceof UploadedFile)
            {
                $path=$file->storePubliclyAs($prefix,$id.'-'.$file->getClientOriginalName());
                $url=Storage::url($path);
                $filesPath[]=$url;
            }
            else if(is_string($file)){
                $filesPath[]=$file;
            }
        }

        return $filesPath;
    }
}

if(!function_exists('deleteFiles'))
{
    function deleteFiles($files) : void
    {
        foreach($files as $file)
        {
            Storage::delete($file);
        }
    }
}

if(!function_exists('compareAndDeleteFiles'))
{
    //Upload Single File
    function compareAndDeleteFiles($oldFiles,$newFiles) : void
    {
        $oldjustification=array_filter($oldFiles, function ($file){
            return is_string($file);
        });

        $newFiles = array_filter($newFiles, function ($file) {
            return !($file instanceof \Illuminate\Http\UploadedFile);
        });


        deleteFiles(array_diff($oldjustification,$newFiles));
    }
}

