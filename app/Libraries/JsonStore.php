<?php

namespace App\Libraries;

class JsonStore
{
    private string $basePath;
    private string $docsPath;

    private const SYNC_FILES = [
        'contents.json',
        'accounts.json',
        'gallery.json',
        'greetings.json',
    ];

    public function __construct()
    {
        $this->basePath = WRITEPATH . 'data/';
        $this->docsPath = ROOTPATH . 'docs/data/';
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
        $path    = $this->basePath . $file;
        $encoded = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $result  = file_put_contents($path, $encoded) !== false;

        if ($result && in_array($file, self::SYNC_FILES, true) && is_dir($this->docsPath)) {
            file_put_contents($this->docsPath . $file, $encoded);
        }

        return $result;
    }
}
