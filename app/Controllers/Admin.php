<?php

namespace App\Controllers;

use App\Libraries\JsonStore;
use CodeIgniter\HTTP\ResponseInterface;

class Admin extends BaseController
{
    private JsonStore $store;

    public function __construct()
    {
        $this->store = new JsonStore();
    }

    public function index()
    {
        return redirect()->to(site_url('admin/texts'));
    }

    // ── 텍스트 관리 ──

    public function texts(): string
    {
        $data = [
            'pageTitle' => '텍스트 관리',
            'contents'  => $this->store->read('contents.json'),
        ];

        return view('admin/texts', $data);
    }

    public function updateTexts(): ResponseInterface
    {
        $contents = [
            'hero' => [
                'headline'      => trim((string) $this->request->getPost('hero_headline')),
                'subtitle'      => trim((string) $this->request->getPost('hero_subtitle')),
                'date'          => trim((string) $this->request->getPost('hero_date')),
                'time'          => trim((string) $this->request->getPost('hero_time')),
                'venue_name'    => trim((string) $this->request->getPost('hero_venue_name')),
                'venue_address' => trim((string) $this->request->getPost('hero_venue_address')),
            ],
            'story' => [
                'intro' => trim((string) $this->request->getPost('story_intro')),
            ],
            'couple' => [
                'groom_name'    => trim((string) $this->request->getPost('groom_name')),
                'groom_parents' => trim((string) $this->request->getPost('groom_parents')),
                'groom_contact' => trim((string) $this->request->getPost('groom_contact')),
                'bride_name'    => trim((string) $this->request->getPost('bride_name')),
                'bride_parents' => trim((string) $this->request->getPost('bride_parents')),
                'bride_contact' => trim((string) $this->request->getPost('bride_contact')),
            ],
        ];

        $this->store->write('contents.json', $contents);

        return redirect()->to(site_url('admin/texts'))->with('success', '저장되었습니다.');
    }

    // ── 갤러리 관리 ──

    public function gallery(): string
    {
        $data = [
            'pageTitle' => '갤러리 관리',
            'images'    => $this->store->read('gallery.json'),
        ];

        return view('admin/gallery', $data);
    }

    public function uploadImage(): ResponseInterface
    {
        $file = $this->request->getFile('image');

        if (! $file || ! $file->isValid() || $file->hasMoved()) {
            return redirect()->to(site_url('admin/gallery'))->with('error', '파일 업로드에 실패했습니다.');
        }

        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (! in_array($file->getMimeType(), $allowed, true)) {
            return redirect()->to(site_url('admin/gallery'))->with('error', '이미지 파일만 업로드할 수 있습니다.');
        }

        $newName = $file->getRandomName();
        $file->move(FCPATH . 'uploads/gallery', $newName);

        $images   = $this->store->read('gallery.json');
        $maxId    = 0;
        foreach ($images as $img) {
            if (($img['id'] ?? 0) > $maxId) {
                $maxId = $img['id'];
            }
        }

        $alt = trim((string) $this->request->getPost('alt'));

        $images[] = [
            'id'  => $maxId + 1,
            'src' => base_url('uploads/gallery/' . $newName),
            'alt' => $alt !== '' ? $alt : '웨딩 사진',
        ];

        $this->store->write('gallery.json', $images);

        return redirect()->to(site_url('admin/gallery'))->with('success', '이미지가 추가되었습니다.');
    }

    public function deleteImage(int $id): ResponseInterface
    {
        $images  = $this->store->read('gallery.json');
        $filtered = [];

        foreach ($images as $img) {
            if (($img['id'] ?? 0) === $id) {
                $src = $img['src'] ?? '';
                if (str_contains($src, 'uploads/gallery/')) {
                    $filename = basename($src);
                    $path     = FCPATH . 'uploads/gallery/' . $filename;
                    if (is_file($path)) {
                        unlink($path);
                    }
                }
                continue;
            }
            $filtered[] = $img;
        }

        $this->store->write('gallery.json', $filtered);

        return redirect()->to(site_url('admin/gallery'))->with('success', '이미지가 삭제되었습니다.');
    }

    public function updateImageAlt(int $id): ResponseInterface
    {
        $images = $this->store->read('gallery.json');
        $alt    = trim((string) $this->request->getPost('alt'));

        foreach ($images as &$img) {
            if (($img['id'] ?? 0) === $id) {
                $img['alt'] = $alt;
                break;
            }
        }

        $this->store->write('gallery.json', $images);

        return redirect()->to(site_url('admin/gallery'))->with('success', '설명이 수정되었습니다.');
    }
}
