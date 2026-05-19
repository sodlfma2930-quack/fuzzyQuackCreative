<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?= esc($pageTitle ?? '모바일 청첩장') ?></title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Noto+Sans+KR:wght@300;400;500&family=Noto+Serif+KR:wght@400;500&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="<?= base_url('css/invitation.css') ?>?v=<?= time() ?>">
</head>
<body>
	<main class="invite">
		<section class="hero">
			<div class="hero__overlay"></div>
			<div class="hero__content">
				<p class="hero__label">Save the Date</p>
				<h1 class="hero__title"><?= esc($hero['headline'] ?? '') ?></h1>
				<p class="hero__subtitle"><?= esc($hero['subtitle'] ?? '') ?></p>
				<div class="hero__date">
					<strong><?= esc($hero['date'] ?? '') ?></strong>
					<span><?= esc($hero['time'] ?? '') ?></span>
					<p><?= esc($hero['venue']['name'] ?? '') ?></p>
					<p><?= esc($hero['venue']['address'] ?? '') ?></p>
				</div>
			</div>
		</section>

		<section class="story">
			<div class="story__card">
				<h2 class="section-title">우리의 이야기</h2>
				<p class="story__text"><?= nl2br(esc($story['intro'] ?? '')) ?></p>
			</div>
		</section>

		<section class="couple">
			<div class="couple__profiles">
				<article class="profile">
					<p class="profile__role">Groom</p>
					<h3 class="profile__name"><?= esc($couple['groom']['name'] ?? '') ?></h3>
					<p class="profile__parents"><?= esc($couple['groom']['parents'] ?? '') ?></p>
					<a class="profile__contact" href="tel:<?= esc($couple['groom']['contact'] ?? '') ?>">연락하기</a>
				</article>
				<article class="profile">
					<p class="profile__role">Bride</p>
					<h3 class="profile__name"><?= esc($couple['bride']['name'] ?? '') ?></h3>
					<p class="profile__parents"><?= esc($couple['bride']['parents'] ?? '') ?></p>
					<a class="profile__contact" href="tel:<?= esc($couple['bride']['contact'] ?? '') ?>">연락하기</a>
				</article>
			</div>
		</section>

		<section class="schedule">
			<h2 class="section-title">예식 순서</h2>
			<ol class="timeline">
				<?php foreach ($schedule ?? [] as $item) : ?>
					<li class="timeline__item">
						<span class="timeline__time"><?= esc($item['time'] ?? '') ?></span>
						<div class="timeline__body">
							<h3 class="timeline__title"><?= esc($item['title'] ?? '') ?></h3>
							<p class="timeline__desc"><?= esc($item['description'] ?? '') ?></p>
						</div>
					</li>
				<?php endforeach ?>
			</ol>
		</section>

		<section class="gallery" data-gallery>
			<h2 class="section-title">우리의 추억</h2>
			<div class="gallery__viewport">
				<div class="gallery__track">
					<?php foreach ($gallery ?? [] as $index => $item) : ?>
						<figure class="gallery__slide" data-slide="<?= (int) $index ?>">
							<img src="<?= esc($item['src'] ?? '') ?>" alt="<?= esc($item['alt'] ?? '') ?>">
						</figure>
					<?php endforeach ?>
				</div>
			</div>
			<div class="gallery__controls">
				<button type="button" class="gallery__button" data-action="prev" aria-label="이전 사진">‹</button>
				<button type="button" class="gallery__button" data-action="next" aria-label="다음 사진">›</button>
			</div>
		</section>

		<section class="account">
			<h2 class="section-title">마음 전하실 곳</h2>
			<p class="account__intro">축하의 마음을 전해주시면 감사히 잘 쓰겠습니다.</p>
			<?php foreach ($accounts ?? [] as $group) : ?>
				<div class="account__group">
					<button type="button" class="account__toggle" data-account-toggle>
						<span class="account__toggle-label"><?= esc($group['label'] ?? '') ?></span>
						<span class="account__toggle-icon">+</span>
					</button>
					<div class="account__list" data-account-list hidden>
						<?php foreach ($group['items'] ?? [] as $item) : ?>
							<div class="account__item">
								<div class="account__info">
									<span class="account__bank"><?= esc($item['bank'] ?? '') ?></span>
									<span class="account__number"><?= esc($item['number'] ?? '') ?></span>
									<span class="account__holder"><?= esc($item['holder'] ?? '') ?></span>
								</div>
								<button type="button" class="account__copy" data-copy-account="<?= esc($item['number'] ?? '') ?>">복사</button>
							</div>
						<?php endforeach ?>
					</div>
				</div>
			<?php endforeach ?>
		</section>

		<section class="map">
			<h2 class="section-title">오시는 길</h2>
			<div class="map__embed">
				<iframe src="<?= esc($map['embedUrl'] ?? '') ?>" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
			<ul class="map__info">
				<li>
					<strong>지하철</strong>
					<p><?= esc($map['transport']['subway']['line'] ?? '') ?></p>
					<p><?= esc($map['transport']['subway']['remark'] ?? '') ?></p>
				</li>
				<li>
					<strong>버스</strong>
					<p><?= esc($map['transport']['bus']['lines'] ?? '') ?></p>
					<p><?= esc($map['transport']['bus']['stop'] ?? '') ?></p>
				</li>
				<li>
					<strong>주차</strong>
					<p><?= esc($map['transport']['parking'] ?? '') ?></p>
				</li>
			</ul>
			<?php if (! empty($map['naverLink'])) : ?>
				<a class="map__link" href="<?= esc($map['naverLink']) ?>" target="_blank" rel="noopener noreferrer">네이버 지도에서 길찾기</a>
			<?php endif ?>
		</section>

		<section class="share">
			<h2 class="section-title">청첩장 공유하기</h2>
			<div class="share__buttons">
				<a class="button button--ghost" href="<?= esc($share['kakaotalk'] ?? '#') ?>" target="_blank" rel="noopener noreferrer">카카오톡</a>
				<a class="button button--ghost" href="<?= esc($share['facebook'] ?? '#') ?>" target="_blank" rel="noopener noreferrer">페이스북</a>
				<button class="button button--ghost" type="button" data-copy>링크 복사</button>
			</div>
		</section>
	</main>
	<script>
		window.APP_CONFIG = {
			galleryEndpoint: '<?= site_url('gallery') ?>',
			shareUrl: '<?= esc($share['page'] ?? site_url()) ?>'
		};
	</script>
	<script src="<?= base_url('js/invitation.js') ?>" defer></script>
	<script>
		document.querySelectorAll('[data-account-toggle]').forEach(btn => {
			btn.addEventListener('click', () => {
				const list = btn.parentElement.querySelector('[data-account-list]');
				const isOpen = !list.hidden;
				list.hidden = isOpen;
				btn.classList.toggle('open', !isOpen);
			});
		});
		document.querySelectorAll('[data-copy-account]').forEach(btn => {
			btn.addEventListener('click', () => {
				const num = btn.dataset.copyAccount.replace(/-/g, '');
				navigator.clipboard.writeText(num).then(() => {
					btn.textContent = '복사됨';
					btn.classList.add('copied');
					setTimeout(() => { btn.textContent = '복사'; btn.classList.remove('copied'); }, 2000);
				});
			});
		});
	</script>
</body>
</html>
