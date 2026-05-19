<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?= esc($pageTitle ?? '여행 가이드') ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Noto+Sans+KR:wght@300;400;500&family=Noto+Serif+KR:wght@400;500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('css/travel.css') ?>">
</head>
<body>
	<header class="guide-hero">
		<div class="guide-hero__overlay"></div>
		<div class="guide-hero__content">
			<p class="guide-hero__label">Travel Picks</p>
			<h1 class="guide-hero__title"><?= esc($pageTitle ?? '') ?></h1>
			<p class="guide-hero__intro"><?= nl2br(esc($intro ?? '')) ?></p>
			<a class="guide-hero__link" href="<?= site_url('/') ?>">홈으로 돌아가기</a>
		</div>
	</header>

	<main class="guide">
		<section class="guide-section">
			<h2 class="section-title">Spot Light</h2>
			<ul class="spot-list">
				<?php foreach ($spots ?? [] as $spot) : ?>
					<li class="spot-card">
						<div class="spot-card__badge"><?= esc($spot['category'] ?? '') ?></div>
						<h3 class="spot-card__name"><?= esc($spot['name'] ?? '') ?></h3>
						<p class="spot-card__desc"><?= esc($spot['description'] ?? '') ?></p>
						<p class="spot-card__address"><?= esc($spot['address'] ?? '') ?></p>
						<?php if (! empty($spot['map']['embed'])) : ?>
							<div class="spot-card__map">
								<iframe src="<?= esc($spot['map']['embed']) ?>" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
							</div>
						<?php endif ?>
						<?php if (! empty($spot['map']['link'])) : ?>
							<a class="spot-card__naver" href="<?= esc($spot['map']['link']) ?>" target="_blank" rel="noopener noreferrer">네이버 지도에서 보기</a>
						<?php endif ?>
					</li>
				<?php endforeach ?>
			</ul>
		</section>

		<section class="guide-section guide-section--accent">
			<h2 class="section-title">Eat & Chill</h2>
			<div class="eat-grid">
				<?php foreach ($eats ?? [] as $eat) : ?>
					<article class="eat-card">
						<h3 class="eat-card__name"><?= esc($eat['name'] ?? '') ?></h3>
						<p class="eat-card__signature"><?= esc($eat['signature'] ?? '') ?></p>
						<p class="eat-card__desc"><?= esc($eat['description'] ?? '') ?></p>
					</article>
				<?php endforeach ?>
			</div>
		</section>

		<section class="guide-section guide-section--cta">
			<h2 class="section-title">Tip</h2>
			<ul class="tip-list">
				<li>밀림은 주말 웨이팅이 길어요 — 평일 오후가 여유로워요.</li>
				<li>컨트리맨즈 시카고피자는 조리 시간 30분, 미리 주문하세요.</li>
				<li>롤링핀은 정원 자리가 인기 — 오픈런 추천!</li>
			</ul>
			<a class="guide-cta" href="<?= site_url('/') ?>">홈으로 돌아가기</a>
		</section>
	</main>
</body>
</html>
