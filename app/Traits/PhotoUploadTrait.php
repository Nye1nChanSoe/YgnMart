<?php

namespace App\Traits;

trait PhotoUploadTrait
{
    /**
     * Store the uploaded image to the filesystem
     * 
     * @param UploadImage $image - uploaded image
     * @return string|null - storage path
     */
    public function upload($image)
    {
        if($image) 
        {
            $filename = uniqid() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            return $filename;
        }
        return null;        
    }
}