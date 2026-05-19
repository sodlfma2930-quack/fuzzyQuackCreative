<?php

namespace App\Libraries;

class JsonStore
{
    private string $basePath;

    public function __construct()
    {
        $this->basePath = WRITEPATH . 'data/';
    }

    public function read(string $file): array
    {
        $path = $this->basePath . $file;

        if (! is_file($path)) {
            return [];
        }

        $json = file_get_contents($path);

        return json_decode($json, true) ?? [];
    }

    public function write(string $file, array $data): bool
    {
        $path = $this->basePath . $file;

        return file_put_contents(
            $path,
            json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        ) !== false;
    }
}
