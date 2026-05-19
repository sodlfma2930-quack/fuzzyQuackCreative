<?php

namespace App\Controllers;

use App\Libraries\JsonStore;
use CodeIgniter\HTTP\ResponseInterface;

class Blog extends BaseController
{
    private JsonStore $store;

    public function __construct()
    {
        $this->store = new JsonStore();
    }

    public function index(): string
    {
        $posts = $this->store->read('posts.json');
        usort($posts, fn($a, $b) => ($b['created_at'] ?? '') <=> ($a['created_at'] ?? ''));

        return view('blog/index', [
            'pageTitle' => '블로그',
            'posts'     => $posts,
        ]);
    }

    public function show(string $slug): string
    {
        $posts = $this->store->read('posts.json');
        $post  = null;

        foreach ($posts as $p) {
            if (($p['slug'] ?? '') === $slug) {
                $post = $p;
                break;
            }
        }

        if ($post === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('blog/show', [
            'pageTitle' => $post['title'] ?? '블로그',
            'post'      => $post,
        ]);
    }
}
