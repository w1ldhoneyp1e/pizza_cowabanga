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
    public function saveImageAsBase64(string $imageBase64): string {
        $imageBase64Array = explode(';base64,', $imageBase64);
        $imgExtention = str_replace('data:image/', '', $imageBase64Array[0]);
        $imageDecoded = base64_decode($imageBase64Array[1]);
        $fileName = uniqid() . '.' . $imgExtention;
        $this->saveFile("images/{$fileName}", $imageDecoded);
        return $fileName;
    }
    private function saveFile(string $file, string $data): void {
        $myFile = fopen($file, 'w');
        if ($myFile) {
          $result = fwrite($myFile, $data);
          if ($result) {
            echo 'Данные успешно сохранены в файл';
          } else {
            echo 'Произошла ошибка при сохранении данных в файл';
          }
          fclose($myFile);
        } else {
          echo 'Произошла ошибка при открытии файла';
        }
      }
}
