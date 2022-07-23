<?php

namespace App\Helpers;

class FileModifierFactory
{
    public static function create(string $filePath): FileModifier
    {
        $dir = dirname($filePath);
        $fileExists = exec("test -e $filePath && echo exists || echo ");
        if (empty($fileExists)) {
            exec("sudo mkdir -p $dir");
            exec("sudo touch $filePath");
        }
        return new FileModifier($filePath);
    }
}
