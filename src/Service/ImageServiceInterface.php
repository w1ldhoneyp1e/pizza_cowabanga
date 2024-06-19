<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageServiceInterface
{
    public function saveImage(?UploadedFile $file): ?string;
   
    public function getExtention();

    public function deleteImage();
}
