<?php

namespace App\Controllers;

use App\Libraries\JsonStore;
use CodeIgniter\HTTP\ResponseInterface;

class Invitation extends BaseController
{
	protected $helpers	= ['url'];
	private JsonStore	$store;

	public function __construct()
	{
		$this->store = new JsonStore();
	}

	public function index(): string
	{
		$contents	= $this->store->read('contents.json');
		$hero		= $contents['hero'] ?? [];
		$couple		= $contents['couple'] ?? [];
		$story		= $contents['story'] ?? [];

		$pageSlug	= 'seungchul-hyunji';
		$pageUrl	= site_url($pageSlug);
		$pageUrlEnc	= rawurlencode($pageUrl);

		$data	= [
			'pageTitle'		=> ($couple['groom_name'] ?? '신랑') . ' & ' . ($couple['bride_name'] ?? '신부') . '의 초대장',
			'slug'			=> $pageSlug,
			'hero'			=> [
				'headline'	=> $hero['headline'] ?? '',
				'subtitle'	=> $hero['subtitle'] ?? '',
				'date'		=> $hero['date'] ?? '',
				'time'		=> $hero['time'] ?? '',
				'venue'		=> [
					'name'		=> $hero['venue_name'] ?? '',
					'address'	=> $hero['venue_address'] ?? '',
				],
			],
			'couple'		=> [
				'groom'	=> [
					'name'		=> $couple['groom_name'] ?? '',
					'parents'	=> $couple['groom_parents'] ?? '',
					'contact'	=> $couple['groom_contact'] ?? '',
				],
				'bride'	=> [
					'name'		=> $couple['bride_name'] ?? '',
					'parents'	=> $couple['bride_parents'] ?? '',
					'contact'	=> $couple['bride_contact'] ?? '',
				],
			],
			'schedule'		=> [
				[
					'time'		=> '14:40',
					'title'		=> '하객 맞이',
					'description'	=> '로비에서 웰컴 드링크와 포토존 함께 즐겨요',
				],
				[
					'time'		=> '15:10',
					'title'		=> '프리 스토리 필름',
					'description'	=> '10년의 순간을 담은 영상으로 인사드려요',
				],
				[
					'time'		=> '15:30',
					'title'		=> '본식',
					'description'	=> '서로에게 약속했던 사랑을 축복 속에 전해요',
				],
				[
					'time'		=> '16:30',
					'title'		=> '애프터 파티',
					'description'	=> '연회장에서 달콤한 디저트와 음악을 함께해요',
				],
			],
			'gallery'		=> $this->galleryItems(),
			'map'			=> [
				'embedUrl'	=> 'https://maps.google.com/maps?q=35.823339,128.740033&hl=ko&z=17&output=embed',
				'naverLink'	=> 'https://map.naver.com/v5/search/%EB%A1%9C%ED%84%B0%EC%8A%A4%20101',
				'transport'	=> [
					'subway'	=> [
						'line'		=> '대구 2호선 영남대역 1번 출구',
						'remark'	=> '역 앞 정류장에서 818, 840번 버스 환승 후 펜타힐즈로 하차 (약 10분)',
					],
					'bus'		=> [
						'lines'		=> '818, 840, 급행 3',
						'stop'		=> '펜타힐즈로 정류장 하차 후 도보 2분',
					],
					'parking'	=> '로터스 101 전용 지하 주차장 (4시간 무료, 발렛 가능)',
				],
			],
			'share'			=> [
				'page'		=> $pageUrl,
				'kakaotalk'	=> 'https://sharer.kakao.com/talk?url='.$pageUrlEnc,
				'facebook'	=> 'https://www.facebook.com/sharer/sharer.php?u='.$pageUrlEnc,
			],
			'story'			=> [
				'intro'	=> $story['intro'] ?? '',
			],
		];

		return view('invitation/index', $data);
	}

	public function gallery(): ResponseInterface
	{
		return $this->response->setJSON([
			'items'	=> $this->galleryItems(),
		]);
	}

	private function galleryItems(): array
	{
		return $this->store->read('gallery.json');
	}
}
