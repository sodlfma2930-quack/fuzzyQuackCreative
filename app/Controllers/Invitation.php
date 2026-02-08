<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;

class Invitation extends BaseController
{
	protected $helpers	= ['url'];

	public function index(): string
	{
		$pageSlug	= 'seungchul-hyunji';
		$pageUrl	= site_url($pageSlug);
		$pageUrlEnc	= rawurlencode($pageUrl);

		$data	= [
			'pageTitle'		=> '승철 & 현지의 초대장',
			'slug'			=> $pageSlug,
			'hero'			=> [
				'headline'	=> '열 해의 사랑, 이제는 한 집의 빛이 되는 날',
				'subtitle'	=> '동갑내기 친구에서 부부로, 10년의 추억을 이어 사랑을 약속합니다.',
				'date'		=> '2027년 4월 10일 토요일',
				'time'		=> '오후 3시 30분',
				'venue'		=> [
					'name'		=> '대구 로터스 101 웨딩홀',
					'address'	=> '경북 경산시 펜타힐즈2로 45',
				],
			],
			'couple'		=> [
				'groom'	=> [
					'name'		=> '오승철',
					'parents'	=> '서로를 믿어준 우리 가족의 든든한 장남',
					'contact'	=> '010-2710-0410',
				],
				'bride'	=> [
					'name'		=> '정현지',
					'parents'	=> '밝게 키워주신 사랑스러운 집의 장녀',
					'contact'	=> '010-0410-2710',
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
				'intro'	=> "스무 살, 같은 반 친구였던 우리가 어느새 10년째 서로의 편이 되었습니다.\n웃음이 닮아가고 꿈이 겹쳐지던 시간들을 기억하며, 이제는 한 가정을 이루어 평생을 함께하려 합니다.\n밝고 따뜻한 마음으로, 우리의 새로운 계절을 함께 축복해주세요.",
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

	/**
	 * @return list<array<string, string>>
	 */
	private function galleryItems(): array
	{
		return [
			[
				'src'		=> 'https://images.unsplash.com/photo-1520854221050-0f4caff449fb?auto=format&fit=crop&w=900&q=80',
				'alt'		=> '하늘 아래에서 손을 마주 잡은 두 사람',
			],
			[
				'src'		=> 'https://images.unsplash.com/photo-1472653431158-6364773b2a56?auto=format&fit=crop&w=900&q=80',
				'alt'		=> '햇살 가득한 들판에서 웃는 모습',
			],
			[
				'src'		=> 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80',
				'alt'		=> '하늘빛 배경의 캐주얼 웨딩 촬영',
			],
			[
				'src'		=> 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?auto=format&fit=crop&w=900&q=80',
				'alt'		=> '블루 계열 플라워 부케와 반지',
			],
		];
	}
}
