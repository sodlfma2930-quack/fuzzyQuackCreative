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

    public function add(): ResponseInterface
    {
        $json = $this->request->getJSON(true);
        $name    = trim($json['name'] ?? '');
        $phone   = trim($json['phone'] ?? '');
        $message = trim($json['message'] ?? '');

        if ($name === '' || $message === '') {
            return $this->response->setStatusCode(400)->setJSON(['error' => '이름과 메시지는 필수입니다']);
        }

        $items = $this->store->read('greetings.json');
        $items[] = ['name' => $name, 'phone' => $phone, 'message' => $message];
        $this->store->write('greetings.json', $items);

        return $this->response->setJSON(['ok' => true, 'index' => count($items) - 1]);
    }

    public function update(int $index): ResponseInterface
    {
        $items = $this->store->read('greetings.json');

        if (! isset($items[$index])) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not found']);
        }

        $json = $this->request->getJSON(true);
        $items[$index] = [
            'name'    => trim($json['name'] ?? $items[$index]['name']),
            'phone'   => trim($json['phone'] ?? $items[$index]['phone']),
            'message' => trim($json['message'] ?? $items[$index]['message']),
        ];
        $this->store->write('greetings.json', $items);

        return $this->response->setJSON(['ok' => true]);
    }

    public function delete(int $index): ResponseInterface
    {
        $items = $this->store->read('greetings.json');

        if (! isset($items[$index])) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Not found']);
        }

        array_splice($items, $index, 1);
        $this->store->write('greetings.json', $items);

        return $this->response->setJSON(['ok' => true]);
    }
}
