<?php
namespace App\Traits;

use Elphin\IcoFileLoader\IcoFileService;
use Intervention\Image\ImageManagerStatic as ImageManager;
trait Image {
    public function uploadImage($dir, $file)
    {
        $result = null;
        $namaFile = time() . "_" . $file->getClientOriginalName();
        // $ext = $file->getClientOriginalExtension();
        $filename = $file->move($dir, $namaFile);
        $result = $filename->getFileName();
        return $result;
    }
    public function convertToIco($pathIco)
    {
        $loader = new IcoFileService;
        $loader->extractIcon($pathIco, 32, 32);
    }
}
