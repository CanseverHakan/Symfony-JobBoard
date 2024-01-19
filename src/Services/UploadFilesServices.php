<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Throwable;

class UploadFilesServices extends AbstractController
{

    private function generateUniqueFileName()
    {
        //random file name
        $name = bin2hex(random_bytes(16)) . '' . uniqid() . '';

        return $name;
    }

    //save file
    public function saveFileUpload($file)
    {

        $fileName = $file->getClientOriginalName();

        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

        $file->move($this->getParameter('uploads_directory'), $fileName);

        return $fileName;
    }

    //update file
    public function UpdateFileUpload($file, $oldFile){

        $fileName = $this->saveFileUpload($file);

        if($oldFile != 'default.png'){
            unlink($this->getParameter('uploads_directory') . '/' . $oldFile);
        }

        $this->deleteFileUpload($oldFile);

        return $fileName;
    }

    //delete file
    public function deleteFileUpload($file){
        try {
            if($file != 'default.png'){
                unlink($this->getParameter('uploads_directory') . '/' . $file);
            }
        } catch(Throwable $th){}
    }
}
