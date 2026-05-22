<?php

namespace App\Controllers;

use App\Libraries\JsonStore;
use CodeIgniter\HTTP\ResponseInterface;

class Greeting extends BaseController
{
    private JsonStore $store;

    public function __construct()
    {
        $this->store = new JsonStore();
    }

    public function search(): ResponseInterface
    {
        $name  = trim((string) $this->request->getGet('name'));
        $phone = preg_replace('/\D/', '', trim((string) $this->request->getGet('phone')));

        if ($name === '' || $phone === '') {
            return $this->response->setJSON(['found' => false]);
        }

        $last4 = substr($phone, -4);
        $items = $this->store->read('greetings.json');

        foreach ($items as $item) {
            $itemPhone = preg_replace('/\D/', '', $item['phone'] ?? '');
            if ($item['name'] === $name && substr($itemPhone, -4) === $last4) {
                return $this->response->setJSON([
                    'found'   => true,
                    'message' => $item['message'] ?? '',
                ]);
            }
        }

        return $this->response->setJSON(['found' => false]);
    }

    // ── Admin ──

    public function admin(): string
    {
        $data = [
            'pageTitle'  => '감사 메시지 관리',
            'greetings'  => $this->store->read('greetings.json'),
        ];

        return view('admin/greetings', $data);
    }

    public function save(): ResponseInterface
    {
        $json = $this->request->getJSON(true);

        if (! is_array($json)) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Invalid data']);
        }

        $items = [];
        foreach ($json as $item) {
            $name    = trim($item['name'] ?? '');
            $phone   = trim($item['phone'] ?? '');
            $message = trim($item['message'] ?? '');
            if ($name === '' || $message === '') {
                continue;
            }
            $items[] = [
                'name'    => $name,
                'phone'   => $phone,
                'message' => $message,
            ];
        }

        $this->store->write('greetings.json', $items);

        return $this->response->setJSON(['ok' => true]);
    }
}
