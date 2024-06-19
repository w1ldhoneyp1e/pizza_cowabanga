<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageService implements ImageServiceInterface
{

    private $dir;
    private const IMAGE_PATH = '/public/uploads/';
    public function __construct($dir) {
        $this->dir = $dir;
    }
    public function saveImage(?UploadedFile $file): ?string
    {
            $extension = $file->getClientOriginalExtension();
            if (!empty($file))
            {
                try {
                    switch ($extension) {
                        case 'gif':
                        case 'png':
                        case 'jpg':
                        case 'jpeg':
                            break;
                        default:
                            throw new \Exception("Не тот формат");
                    }
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    die();
                }
                
                $fileName = uniqid() . '.' . $extension;
                $path = $this->dir . self::IMAGE_PATH;
                $file->move($path, $fileName);
            } else {
                $fileName = '';
            }
            return $fileName;        
    }
   
    public function getExtention()
    {

    }

    public function deleteImage()
    {

    }
}
