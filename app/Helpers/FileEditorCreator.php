<?php

namespace App\Helpers;

class FileEditorCreator
{
    public static function create(string $filePath): FileEditor
    {
        $dir = dirname($filePath);
        $fileExists = exec("test -e $filePath && echo exists || echo ");
        if (empty($fileExists)) {
            exec("sudo mkdir -p $dir");
            exec("sudo touch $filePath");
        }
        return new FileEditor($filePath);
    }
}
