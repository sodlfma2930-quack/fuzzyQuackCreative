<?php

namespace App\Controllers;

use App\Libraries\JsonStore;
use CodeIgniter\HTTP\ResponseInterface;

class AdminBlog extends BaseController
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

        return view('admin/blog/index', [
            'pageTitle' => '블로그 관리',
            'posts'     => $posts,
        ]);
    }

    public function create(): string
    {
        return view('admin/blog/form', [
            'pageTitle' => '새 글 작성',
            'post'      => null,
        ]);
    }

    public function store(): ResponseInterface
    {
        $posts = $this->store->read('posts.json');
        $maxId = 0;
        foreach ($posts as $p) {
            if (($p['id'] ?? 0) > $maxId) {
                $maxId = $p['id'];
            }
        }

        $title = trim((string) $this->request->getPost('title'));
        $slug  = $this->makeSlug($title, $posts);

        $file      = $this->request->getFile('thumbnail');
        $thumbnail = '';
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName   = $file->getRandomName();
            $file->move(FCPATH . 'uploads/blog', $newName);
            $thumbnail = base_url('uploads/blog/' . $newName);
        }

        $posts[] = [
            'id'         => $maxId + 1,
            'title'      => $title,
            'slug'       => $slug,
            'content'    => trim((string) $this->request->getPost('content')),
            'thumbnail'  => $thumbnail,
            'created_at' => date('Y-m-d'),
        ];

        $this->store->write('posts.json', $posts);

        return redirect()->to(site_url('admin/blog'))->with('success', '글이 등록되었습니다.');
    }

    public function edit(int $id): string
    {
        $posts = $this->store->read('posts.json');
        $post  = null;

        foreach ($posts as $p) {
            if (($p['id'] ?? 0) === $id) {
                $post = $p;
                break;
            }
        }

        if ($post === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('admin/blog/form', [
            'pageTitle' => '글 수정',
            'post'      => $post,
        ]);
    }

    public function update(int $id): ResponseInterface
    {
        $posts = $this->store->read('posts.json');

        foreach ($posts as &$p) {
            if (($p['id'] ?? 0) === $id) {
                $p['title']   = trim((string) $this->request->getPost('title'));
                $p['content'] = trim((string) $this->request->getPost('content'));

                $file = $this->request->getFile('thumbnail');
                if ($file && $file->isValid() && ! $file->hasMoved()) {
                    $this->deleteThumbnailFile($p['thumbnail'] ?? '');
                    $newName        = $file->getRandomName();
                    $file->move(FCPATH . 'uploads/blog', $newName);
                    $p['thumbnail'] = base_url('uploads/blog/' . $newName);
                }
                break;
            }
        }

        $this->store->write('posts.json', $posts);

        return redirect()->to(site_url('admin/blog'))->with('success', '글이 수정되었습니다.');
    }

    public function delete(int $id): ResponseInterface
    {
        $posts    = $this->store->read('posts.json');
        $filtered = [];

        foreach ($posts as $p) {
            if (($p['id'] ?? 0) === $id) {
                $this->deleteThumbnailFile($p['thumbnail'] ?? '');
                continue;
            }
            $filtered[] = $p;
        }

        $this->store->write('posts.json', $filtered);

        return redirect()->to(site_url('admin/blog'))->with('success', '글이 삭제되었습니다.');
    }

    private function makeSlug(string $title, array $posts): string
    {
        $slug     = preg_replace('/[^a-zA-Z0-9가-힣\s-]/', '', $title);
        $slug     = preg_replace('/\s+/', '-', trim($slug));
        $slug     = mb_strtolower($slug);
        $base     = $slug ?: 'post';
        $existing = array_column($posts, 'slug');
        $i        = 1;

        while (in_array($slug, $existing, true)) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    private function deleteThumbnailFile(string $src): void
    {
        if ($src !== '' && str_contains($src, 'uploads/blog/')) {
            $path = FCPATH . 'uploads/blog/' . basename($src);
            if (is_file($path)) {
                unlink($path);
            }
        }
    }
}
