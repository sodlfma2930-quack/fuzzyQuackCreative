<?php

namespace App\Controllers;

class TravelGuide extends BaseController
{
	public function index(): string
	{
		$data	= [
			'pageTitle'	=> '대구 여행 가이드',
			'intro'		=> "예식 전후로 즐길 수 있는 대구의 감성 스팟을 모았어.\n달달한 카페부터 야경 맛집까지, 하루 코스로 즐겨봐!",
			'spots'		=> [
				[
					'name'		=> '김광석 다시 그리기 길',
					'description'	=> '감성 벽화와 버스킹이 어우러진 골목. 저녁 산책 코스로 최고야.',
					'category'	=> '산책',
					'address'	=> '대구광역시 중구 달구벌대로 2239',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8656,128.6063&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EA%B9%80%EA%B4%91%EC%84%9D%20%EB%8B%A4%EC%8B%9C%20%EA%B7%B8%EB%A6%AC%EA%B8%B0%EA%B8%B8',
					],
				],
				[
					'name'		=> '카페 모멘트',
					'description'	=> '하얀 인테리어와 루프탑이 있는 핫플 카페. 웨딩 전날 프리 웨딩샷 찍기 좋아.',
					'category'	=> '카페',
					'address'	=> '대구광역시 중구 동성로4길 55',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8689,128.5998&hl=ko&z=17&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EC%B9%B4%ED%8E%98%20%EB%AA%A8%EB%A9%98%ED%8A%B8',
					],
				],
				[
					'name'		=> '83타워 전망대',
					'description'	=> '도심 야경을 한눈에 볼 수 있는 랜드마크. 야간 조명이 정말 로맨틱해.',
					'category'	=> '야경',
					'address'	=> '대구광역시 달서구 두류공원로 200',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8545,128.5648&hl=ko&z=16&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/83%ED%83%80%EC%9B%8C',
					],
				],
				[
					'name'		=> '수성못',
					'description'	=> '호수 주변 카페, 산책로, 보트까지 완벽한 힐링 포인트.',
					'category'	=> '힐링',
					'address'	=> '대구광역시 수성구 두산동 512',
					'map'		=> [
						'embed'	=> 'https://maps.google.com/maps?q=35.8276,128.6292&hl=ko&z=16&output=embed',
						'link'	=> 'https://map.naver.com/v5/search/%EC%88%98%EC%84%B1%EB%AA%BB',
					],
				],
			],
			'eats'		=> [
				[
					'name'		=> '막창 도니',
					'description'	=> '대구 현지인들이 추천하는 막창 맛집. 겉바속촉 식감 인정!',
					'signature'	=> '숯불막창',
				],
				[
					'name'		=> '빵장수단팥빵',
					'description'	=> '달콤한 단팥빵과 우유크림빵으로 유명한 베이커리.',
					'signature'	=> '단팥빵 · 크림빵',
				],
				[
					'name'		=> '삼덕동 살라미 파스타',
					'description'	=> '감각적인 분위기의 이탈리안 레스토랑. 커플 저녁 코스로 딱이야.',
					'signature'	=> '트러플 파스타',
				],
			],
		];

		return view('travel/guide', $data);
	}
}
