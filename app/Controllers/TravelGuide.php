<?php

namespace App\Controllers;

class TravelGuide extends BaseController
{
	public function index(): string
	{
		$data	= [
			'pageTitle'	=> '대구 여행 가이드',
			'intro'		=> "예식 전후로 즐길 수 있는 대구의 감성 스팟을 엄선했어요.\n럭셔리한 분위기부터 힙한 맛집까지, 특별한 하루를 만들어보세요.",
			'spots'		=> [
				[
					'name'		=> '밀림 MILLIM',
					'description'	=> '4층 규모의 정글 테마 대형 카페. 브런치와 파충류 체험까지 한 번에 즐기는 대구 대표 이색 핫플.',
					'category'	=> '이색카페',
					'address'	=> '대구광역시 남구 용두길 16',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8430,128.5910&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EB%B0%80%EB%A6%BC%20%EB%8C%80%EA%B5%AC',
					],
				],
				[
					'name'		=> '컨트리맨즈 동성로',
					'description'	=> '6년째 동성로를 지켜온 감성 양식 맛집. 비주얼 폭발 시카고 딥디쉬 피자로 줄 서서 먹는 곳.',
					'category'	=> '양식',
					'address'	=> '대구광역시 중구 동성로2길 21-5',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8696,128.5966&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EC%BB%A8%ED%8A%B8%EB%A6%AC%EB%A7%A8%EC%A6%88%20%EB%8F%99%EC%84%B1%EB%A1%9C',
					],
				],
				[
					'name'		=> '롤링핀 대구수목원점',
					'description'	=> '산토리니 감성의 탁 트인 정원에서 갓 구운 빵 향기와 함께하는 대구 최고 뷰 맛집 카페.',
					'category'	=> '베이커리카페',
					'address'	=> '대구광역시 달서구 한실로6길 158',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8530,128.5520&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EB%A1%A4%EB%A7%81%ED%95%80%20%EB%8C%80%EA%B5%AC%EC%88%98%EB%AA%A9%EC%9B%90%EC%A0%90',
					],
				],
			],
			'eats'		=> [
				[
					'name'		=> '밀림 MILLIM',
					'description'	=> '정글 속에서 즐기는 밀림 클럽 샌드위치와 시그니처 드링크.',
					'signature'	=> '클럽 샌드위치 · 쉬림프 샐러드',
				],
				[
					'name'		=> '컨트리맨즈',
					'description'	=> '치즈가 쭉 늘어나는 시카고 딥디쉬 피자의 성지.',
					'signature'	=> '시카고 딥디쉬 피자 · 고르곤졸라 파스타',
				],
				[
					'name'		=> '롤링핀',
					'description'	=> '정원 뷰와 함께하는 갓 구운 베이커리와 브런치 코스.',
					'signature'	=> '뇨끼 파스타 · 로제 베이컨 쉬림프 리조또',
				],
			],
		];

		return view('travel/guide', $data);
	}
}
