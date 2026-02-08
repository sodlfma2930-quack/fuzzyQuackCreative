<?php

namespace App\Controllers;

use App\Models\RsvpModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Rsvp extends BaseController
{
	use ResponseTrait;

	protected RsvpModel	$model;

	public function __construct()
	{
		$this->model	= new RsvpModel();
	}

	public function store(): ResponseInterface
	{
		$rules	= [
			'name'		=> 'required|min_length[2]|max_length[50]',
			'phone'		=> 'required|regex_match[/^[0-9]{9,13}$/]',
			'guests'	=> 'required|integer|greater_than_equal_to[0]|less_than_equal_to[4]',
			'attendance'	=> 'required|in_list[yes,no]',
			'message'	=> 'permit_empty|max_length[255]',
		];

		$messages	= [
			'name'		=> [
				'required'		=> '이름을 입력해줘.',
				'min_length'	=> '이름은 두 글자 이상이야.',
				'max_length'	=> '이름이 너무 길어.',
			],
			'phone'		=> [
				'required'		=> '연락처를 남겨줘.',
				'regex_match'	=> '연락처는 숫자만 넣어줘.',
			],
			'guests'	=> [
				'required'			=> '동반 인원을 알려줘.',
				'integer'			=> '숫자로 입력해야 해.',
				'greater_than_equal_to'	=> '음수는 될 수 없어.',
				'less_than_equal_to'	=> '4명까지 입력할 수 있어.',
			],
			'attendance'	=> [
				'required'	=> '참석 여부를 선택해줘.',
				'in_list'	=> '참석 여부는 예 또는 아니오로 선택해줘.',
			],
			'message'	=> [
				'max_length'	=> '메시지는 255자를 넘길 수 없어.',
			],
		];

		if (! $this->validate($rules, $messages)) {
			return $this->failValidationErrors($this->validator->getErrors());
		}

		$payload	= [
			'name'		=> trim((string) $this->request->getPost('name')),
			'phone'		=> trim((string) $this->request->getPost('phone')),
			'guests'	=> (int) $this->request->getPost('guests'),
			'attendance'	=> $this->request->getPost('attendance') === 'yes' ? 'yes' : 'no',
			'message'	=> trim((string) ($this->request->getPost('message') ?? '')),
		];

		$this->model->insert($payload);

		return $this->respondCreated([
			'message'	=> '참석 여부가 잘 저장됐어! 고마워.',
		]);
	}
}
