<?php

namespace App\Controllers;

class TravelGuide extends BaseController
{
	public function index(): string
	{
		$data	= [
			'pageTitle'	=> '대구 맛집 · 카페 가이드',
			'intro'		=> "대구 로컬이 추천하는 진짜 맛집과 감성 카페 🍽️",
			'spots'		=> [
				[
					'name'		=> '밀림 MILLIM',
					'description'	=> '4층 규모의 정글 테마 대형 카페. 브런치와 파충류 체험까지 한 번에 즐기는 대구 대표 이색 핫플.',
					'category'	=> '이색카페',
					'vibe'		=> '🌿 정글 감성',
					'signature'	=> '클럽 샌드위치 · 쉬림프 샐러드',
					'price'		=> '₩15,000~',
					'hours'		=> '11:00 - 22:00',
					'address'	=> '대구광역시 남구 용두길 16',
					'image'		=> 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=600&h=400&fit=crop',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8430,128.5910&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EB%B0%80%EB%A6%BC%20%EB%8C%80%EA%B5%AC',
					],
				],
				[
					'name'		=> '컨트리맨즈 동성로',
					'description'	=> '6년째 동성로를 지켜온 감성 양식 맛집. 비주얼 폭발 시카고 딥디쉬 피자로 줄 서서 먹는 곳.',
					'category'	=> '양식',
					'vibe'		=> '🍕 치즈 폭탄',
					'signature'	=> '시카고 딥디쉬 피자 · 고르곤졸라 파스타',
					'price'		=> '₩18,000~',
					'hours'		=> '11:30 - 21:30',
					'address'	=> '대구광역시 중구 동성로2길 21-5',
					'image'		=> 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=600&h=400&fit=crop',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8696,128.5966&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EC%BB%A8%ED%8A%B8%EB%A6%AC%EB%A7%A8%EC%A6%88%20%EB%8F%99%EC%84%B1%EB%A1%9C',
					],
				],
				[
					'name'		=> '롤링핀 대구수목원점',
					'description'	=> '산토리니 감성의 탁 트인 정원에서 갓 구운 빵 향기와 함께하는 대구 최고 뷰 맛집 카페.',
					'category'	=> '베이커리카페',
					'vibe'		=> '🏖️ 산토리니 무드',
					'signature'	=> '뇨끼 파스타 · 로제 베이컨 쉬림프 리조또',
					'price'		=> '₩14,000~',
					'hours'		=> '10:00 - 22:00',
					'address'	=> '대구광역시 달서구 한실로6길 158',
					'image'		=> 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600&h=400&fit=crop',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8530,128.5520&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EB%A1%A4%EB%A7%81%ED%95%80%20%EB%8C%80%EA%B5%AC%EC%88%98%EB%AA%A9%EC%9B%90%EC%A0%90',
					],
				],
				[
					'name'		=> '동인동 찜갈비골목',
					'description'	=> '대구 3대 음식 중 하나. 50년 전통의 매콤 달콤한 찜갈비를 골목 전체에서 즐길 수 있는 로컬 성지.',
					'category'	=> '한식',
					'vibe'		=> '🔥 매콤 로컬',
					'signature'	=> '찜갈비 · 납작만두',
					'price'		=> '₩13,000~',
					'hours'		=> '10:00 - 21:00',
					'address'	=> '대구광역시 중구 동인동 1가',
					'image'		=> 'https://images.unsplash.com/photo-1590301157890-4810ed352733?w=600&h=400&fit=crop',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8710,128.6040&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EB%8F%99%EC%9D%B8%EB%8F%99%20%EC%B0%9C%EA%B0%88%EB%B9%84',
					],
				],
				[
					'name'		=> '서문시장 야시장',
					'description'	=> '대구 최대 전통시장의 야시장. 칼국수, 납작만두, 떡볶이 등 길거리 음식의 천국.',
					'category'	=> '전통시장',
					'vibe'		=> '🏮 야시장 감성',
					'signature'	=> '칼국수 · 납작만두 · 수제 떡볶이',
					'price'		=> '₩5,000~',
					'hours'		=> '19:00 - 23:30 (금·토)',
					'address'	=> '대구광역시 중구 큰장로26길 45',
					'image'		=> 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&h=400&fit=crop',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8680,128.5820&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EC%84%9C%EB%AC%B8%EC%8B%9C%EC%9E%A5%20%EC%95%BC%EC%8B%9C%EC%9E%A5',
					],
				],
				[
					'name'		=> '카페 아리따',
					'description'	=> '앞산 카페거리의 시그니처. 통유리 너머 대구 시내 전경을 한눈에 담는 루프탑 뷰 맛집.',
					'category'	=> '루프탑카페',
					'vibe'		=> '🌇 시티뷰',
					'signature'	=> '아인슈페너 · 티라미수',
					'price'		=> '₩7,000~',
					'hours'		=> '11:00 - 23:00',
					'address'	=> '대구광역시 남구 앞산순환로 574',
					'image'		=> 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=600&h=400&fit=crop',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8260,128.5830&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EC%95%9E%EC%82%B0%20%EC%B9%B4%ED%8E%98%EA%B1%B0%EB%A6%AC',
					],
				],
			],
		];

		return view('travel/guide', $data);
	}
}
