<?php

use App\Service\Control\ManagementCrud;

$RouterFormat = [];
$dir = new DirectoryIterator(config('generator_crud_config.scema_path_dirname') . "V1/");
foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot()) {
        $f = explode(".", $fileinfo->getFilename());
        $resources = new ManagementCrud($f[0]);
        $format = $resources->getInstanceRouter("api", "v1");
        array_push($RouterFormat, $format);
    }
}
