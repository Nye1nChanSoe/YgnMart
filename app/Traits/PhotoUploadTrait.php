<?php

namespace App\Traits;

trait PhotoUploadTrait
{
    /**
     * Store the uploaded image to the filesystem
     * 
     * @param UploadImage $image - uploaded image
     * @return string|false - storage path
     */
    public function upload($image)
    {
        if($image) 
        {
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            return $filename;
        }
        return false;
    }

    /**
     * Delete the specified image from the filesystem
     *
     * @param string $filename - filename of the image to delete
     * @return bool - true if the file was deleted, false otherwise
     */
    public function delete($filename)
    {
        $path = storage_path('app/public/images/' . $filename);
        if(file_exists($path)) 
        {
            return unlink($path);
        }
        return false;
    }
}