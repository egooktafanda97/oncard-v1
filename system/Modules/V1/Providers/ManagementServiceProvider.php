<?php

namespace Modules\V1\Providers;

use App\Service\Control\ManagementCrud;
use DirectoryIterator;

class ManagementServiceProvider
{
    public static function getScemaPath()
    {
        return storage_path("Scema/V1/");
    }
    public static function getScemaPathDirname()
    {
        return dirname(__FILE__) . "/../../../storage/Scema/V1/";
    }
    public static function RouterFormating(): array
    {
        $dir = new DirectoryIterator(self::getScemaPathDirname());
        $RouterFormat = [];
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $f = explode(".", $fileinfo->getFilename());
                $resources = new ManagementCrud($f[0]);
                $pathJson =  self::getScemaPath();
                $resources->instance($pathJson);
                $resources->setNameSpaceController("\\Modules\\V1\\Http\\Controllers\\");
                $format = $resources->getInstanceRouter("api");
                array_push($RouterFormat, $format);
            }
        }
        return $RouterFormat;
    }
}
