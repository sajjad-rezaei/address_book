<?php


namespace App\Services;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader{

    //dir path, can be edit with in services.yaml
    private $dir;

    public function __construct(string $dir){
        $this->dir = $dir;
    }
    public function getDir(){
        return $this->dir;
    }
    public function uploadFile(UploadedFile  $file){

        try{
            //create a unique name for image
            $fileName = md5(uniqid()) . "." . $file->guessClientExtension();
            //move image to upload directory witch is in services.yaml
            $file->move($this->dir,$fileName);
            return $fileName;

        } catch (FileException $e) {
            return false;
        }

    }
    public function removeFile(string $fileName):bool
    {
        //get the full path of file
        $file = $this->getDir() . '/' . $fileName;
        try {
                if (file_exists($file)) {
                    //remove the file
                    unlink($file);
                    return true;
                }
        } catch (FileException $e) {}
        return false;

    }

}