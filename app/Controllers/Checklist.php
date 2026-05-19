<?php

namespace App\Controllers;

use App\Libraries\JsonStore;
use CodeIgniter\HTTP\ResponseInterface;

class Checklist extends BaseController
{
    private JsonStore $store;

    public function __construct()
    {
        $this->store = new JsonStore();
    }

    public function index(): string
    {
        $data = [
            'pageTitle' => '체크리스트',
            'items'     => $this->store->read('checklist.json'),
        ];

        return view('checklist/index', $data);
    }

    public function save(): ResponseInterface
    {
        $json = $this->request->getJSON(true);

        if (! is_array($json)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid data']);
        }

        $items = [];
        foreach ($json as $item) {
            $text = trim($item['text'] ?? '');
            if ($text === '') {
                continue;
            }
            $items[] = [
                'text'    => $text,
                'checked' => (bool) ($item['checked'] ?? false),
            ];
        }

        $this->store->write('checklist.json', $items);

        return $this->response->setJSON(['ok' => true]);
    }
}
