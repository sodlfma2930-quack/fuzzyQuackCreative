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
	<link rel="stylesheet" href="<?= base_url('css/invitation.css') ?>">
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

		<section class="rsvp" data-rsvp>
			<h2 class="section-title">참석 여부 알려줘</h2>
			<form class="rsvp__form" id="rsvpForm" novalidate>
				<div class="field">
					<label for="name">이름</label>
					<input id="name" name="name" type="text" required maxlength="50">
					<p class="field__error" data-error="name"></p>
				</div>
				<div class="field">
					<label for="phone">연락처</label>
					<input id="phone" name="phone" type="tel" required pattern="[0-9]{9,13}" placeholder="01012345678">
					<p class="field__error" data-error="phone"></p>
				</div>
				<div class="field">
					<label for="guests">동반 인원</label>
					<select id="guests" name="guests" required>
						<option value="0">혼자 참석</option>
						<option value="1">1명</option>
						<option value="2">2명</option>
						<option value="3">3명</option>
						<option value="4">4명</option>
					</select>
					<p class="field__error" data-error="guests"></p>
				</div>
				<fieldset class="field field--radio">
					<legend>참석 여부</legend>
					<label>
						<input type="radio" name="attendance" value="yes" required>
						참석할게
					</label>
					<label>
						<input type="radio" name="attendance" value="no" required>
						어려울 것 같아
					</label>
					<p class="field__error" data-error="attendance"></p>
				</fieldset>
				<div class="field">
					<label for="message">축하 메시지 (선택)</label>
					<textarea id="message" name="message" rows="3" maxlength="255" placeholder="짧은 메시지를 남겨줘."></textarea>
					<p class="field__error" data-error="message"></p>
				</div>
				<button type="submit" class="button" data-submit>참석 여부 보내기</button>
				<p class="rsvp__feedback" data-feedback></p>
			</form>
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
			rsvpEndpoint: '<?= site_url('rsvp') ?>',
			galleryEndpoint: '<?= site_url('gallery') ?>',
			shareUrl: '<?= esc($share['page'] ?? site_url()) ?>'
		};
	</script>
	<script src="<?= base_url('js/invitation.js') ?>" defer></script>
</body>
</html>
