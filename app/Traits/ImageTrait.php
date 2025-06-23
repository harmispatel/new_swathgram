<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
// use Intervention\Image\Facades\Image;

trait ImageTrait
{
    public function addSingleImage($image_name,$path,$file,$old_image = null)
    {
        $basePath = public_path('assets/images/uploads/' . $path);
        if ($old_image && File::exists($basePath . '/' . $old_image)) {
            File::delete($basePath . '/' . $old_image);
        }

        if ($file) {
            $filename = $image_name . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            if (!File::exists($basePath)) {
                File::makeDirectory($basePath, 0755, true);
            }
            $file->move($basePath, $filename);
            return $filename;
        }
        return null;
    }

    public function addMultipleFiles($image_name,$path, $files, $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'])
    {
        $basePath = public_path('assets/images/uploads/' . $path);
        if (!File::exists($basePath)) {
            File::makeDirectory($basePath, 0755, true);
        }

        $uploadedFiles = [];
        foreach ($files as $file) {
            $extension = strtolower($file->getClientOriginalExtension());
            
            if (in_array($extension, $allowedExtensions)) {
                $filename = $image_name . '_' . Str::random(5) . '.' . $extension;
                $file->move($basePath, $filename);
                $uploadedFiles[] = $filename;
            }
        }
        return $uploadedFiles;
    }

    public function addSingleFile($file_name, $path, $file, $old_file = null)
    {
        $basePath = public_path('files/uploads/' . $path);
        if ($old_file && File::exists($basePath . '/' . $old_file)) {
            File::delete($basePath . '/' . $old_file);
        }

        if ($file) {
            $filename = $file_name . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            if (!File::exists($basePath)) {
                File::makeDirectory($basePath, 0755, true);
            }
            $file->move($basePath, $filename);
            return $filename;
        }
        return null;
    }

    public function deleteUserImage($user)
    {
        if ($user) {
            if ($user->user_image) {
                $this->deleteFile(public_path('images/uploads/users/profiles'), $user->user_image);
            }

            if ($user->business_card_file) {
                $this->deleteFile(public_path('images/uploads/business_cards'), $user->business_card_file);
            }
            return true;
        }
        return false;
    }

    private function deleteFile($basePath, $fileName)
    {
        if ($fileName && File::exists($basePath . '/' . $fileName)) {
            File::delete($basePath . '/' . $fileName);
        }
    }

 
}

