<?php

namespace App\Helpers;

class FileModifier
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function find($regex): bool|string
    {
        return exec("grep -E '$regex' {$this->path}");
    }

    public function replace(string $searchRegex, string $replace): bool|string
    {
        return exec("sudo sed -i -E 's/$searchRegex/$replace/g' {$this->path}");
    }

    public function append(string $string): bool|string
    {
        return exec("sudo echo '$string' | sudo tee -a {$this->path}");
    }
}
