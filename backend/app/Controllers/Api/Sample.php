<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;

class Sample extends ResourceController
{
    public function index()
    {
        return $this->respond(['message' => 'Hello from CI4 털보 로컬 세팅완료!']);
    }
}
