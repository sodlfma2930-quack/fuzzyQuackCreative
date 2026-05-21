<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?= esc($pageTitle ?? '맛집 가이드') ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('css/travel.css') ?>">
</head>
<body>

	<header class="hero">
		<div class="hero__bg"></div>
		<div class="hero__content">
			<div class="hero__badge">📍 DAEGU LOCAL PICKS</div>
			<h1 class="hero__title"><?= esc($pageTitle ?? '') ?></h1>
			<p class="hero__sub"><?= esc($intro ?? '') ?></p>
		</div>
	</header>

	<nav class="category-bar">
		<button class="category-btn active" data-filter="all">전체</button>
		<?php
		$cats = [];
		foreach ($spots ?? [] as $s) {
			$c = $s['category'] ?? '';
			if ($c && !in_array($c, $cats)) $cats[] = $c;
		}
		foreach ($cats as $cat) :
		?>
			<button class="category-btn" data-filter="<?= esc($cat) ?>"><?= esc($cat) ?></button>
		<?php endforeach ?>
	</nav>

	<main class="feed">
		<?php foreach ($spots ?? [] as $i => $spot) : ?>
			<article class="card" data-category="<?= esc($spot['category'] ?? '') ?>">
				<div class="card__img">
					<img src="<?= esc($spot['image'] ?? '') ?>" alt="<?= esc($spot['name'] ?? '') ?>" loading="lazy">
					<div class="card__overlay">
						<span class="card__badge"><?= esc($spot['category'] ?? '') ?></span>
					</div>
				</div>

				<div class="card__body">
					<div class="card__header">
						<h2 class="card__name"><?= esc($spot['name'] ?? '') ?></h2>
						<span class="card__vibe"><?= esc($spot['vibe'] ?? '') ?></span>
					</div>

					<p class="card__desc"><?= esc($spot['description'] ?? '') ?></p>

					<div class="card__meta">
						<div class="card__meta-item">
							<span class="card__meta-label">시그니처</span>
							<span class="card__meta-value"><?= esc($spot['signature'] ?? '') ?></span>
						</div>
						<div class="card__meta-row">
							<div class="card__meta-item">
								<span class="card__meta-label">가격대</span>
								<span class="card__meta-value"><?= esc($spot['price'] ?? '') ?></span>
							</div>
							<div class="card__meta-item">
								<span class="card__meta-label">영업시간</span>
								<span class="card__meta-value"><?= esc($spot['hours'] ?? '') ?></span>
							</div>
						</div>
					</div>

					<div class="card__address">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
						<?= esc($spot['address'] ?? '') ?>
					</div>

					<?php if (! empty($spot['map']['embed'])) : ?>
						<div class="card__map">
							<iframe src="<?= esc($spot['map']['embed']) ?>" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade"></iframe>
						</div>
					<?php endif ?>

					<div class="card__actions">
						<?php if (! empty($spot['map']['link'])) : ?>
							<a class="card__btn card__btn--primary" href="<?= esc($spot['map']['link']) ?>" target="_blank" rel="noopener">
								<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
								네이버 지도
							</a>
						<?php endif ?>
						<button class="card__btn card__btn--save" onclick="this.classList.toggle('saved')">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>
							저장
						</button>
					</div>
				</div>
			</article>
		<?php endforeach ?>
	</main>

	<section class="tips">
		<h2 class="tips__title">💡 로컬 꿀팁</h2>
		<div class="tips__grid">
			<div class="tips__item">밀림은 주말 웨이팅 1시간 — <strong>평일 오후</strong>가 여유로워요</div>
			<div class="tips__item">컨트리맨즈 피자는 <strong>조리 30분</strong> — 도착하자마자 주문!</div>
			<div class="tips__item">롤링핀 정원석은 <strong>오픈런</strong> 추천, 10시 전 도착</div>
			<div class="tips__item">동인동 찜갈비는 <strong>2인분 이상</strong> 주문 필수</div>
			<div class="tips__item">서문 야시장은 <strong>금·토만</strong> 운영 — 평일 방문 시 주의</div>
			<div class="tips__item">앞산 카페거리는 <strong>일몰 시간</strong>에 가면 뷰 최고</div>
		</div>
	</section>

	<footer class="footer">
		<a class="footer__btn" href="<?= site_url('/') ?>">← 홈으로 돌아가기</a>
	</footer>

	<script>
	document.querySelectorAll('.category-btn').forEach(function(btn) {
		btn.addEventListener('click', function() {
			document.querySelectorAll('.category-btn').forEach(function(b) { b.classList.remove('active'); });
			this.classList.add('active');
			var filter = this.dataset.filter;
			document.querySelectorAll('.card').forEach(function(card) {
				if (filter === 'all' || card.dataset.category === filter) {
					card.style.display = '';
					card.style.animation = 'fadeUp .4s ease forwards';
				} else {
					card.style.display = 'none';
				}
			});
		});
	});
	</script>
</body>
</html>
