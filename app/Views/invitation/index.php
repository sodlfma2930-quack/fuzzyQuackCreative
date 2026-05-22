<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title><?= esc($pageTitle ?? '모바일 청첩장') ?></title>
	<meta property="og:title" content="<?= esc($pageTitle ?? '모바일 청첩장') ?>">
	<meta property="og:description" content="<?= esc($hero['date'] ?? '') ?> <?= esc($hero['time'] ?? '') ?> · <?= esc($hero['venue']['name'] ?? '') ?>">
	<meta property="og:image" content="<?= base_url('images/hero/og-image.jpg') ?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?= current_url() ?>">
	<meta name="description" content="<?= esc($hero['subtitle'] ?? '') ?>">
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

		<section class="story reveal">
			<div class="story__card">
				<h2 class="section-title">우리의 이야기</h2>
				<p class="story__text"><?= nl2br(esc($story['intro'] ?? '')) ?></p>
			</div>
		</section>

		<section class="couple reveal">
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

		<section class="schedule reveal">
			<h2 class="section-title">예식 순서</h2>
			<ol class="timeline">
				<?php foreach ($schedule ?? [] as $item) : ?>
					<li class="timeline__item reveal">
						<span class="timeline__time"><?= esc($item['time'] ?? '') ?></span>
						<div class="timeline__body">
							<h3 class="timeline__title"><?= esc($item['title'] ?? '') ?></h3>
							<p class="timeline__desc"><?= esc($item['description'] ?? '') ?></p>
						</div>
					</li>
				<?php endforeach ?>
			</ol>
		</section>

		<section class="gallery reveal">
			<h2 class="section-title">우리의 추억</h2>
			<div class="gallery__grid">
				<?php foreach ($gallery ?? [] as $item) : ?>
					<figure class="gallery__thumb reveal" data-lightbox="<?= esc($item['src'] ?? '') ?>">
						<img src="<?= esc($item['src'] ?? '') ?>" alt="<?= esc($item['alt'] ?? '') ?>" loading="lazy">
					</figure>
				<?php endforeach ?>
			</div>
		</section>
		<div class="lightbox" id="lightbox">
			<button type="button" class="lightbox__close" aria-label="닫기">&times;</button>
			<button type="button" class="lightbox__nav lightbox__nav--prev" aria-label="이전">‹</button>
			<img class="lightbox__img" src="" alt="">
			<button type="button" class="lightbox__nav lightbox__nav--next" aria-label="다음">›</button>
		</div>

		<section class="account reveal">
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

		<section class="map reveal">
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

		<section class="share reveal">
			<h2 class="section-title">청첩장 공유하기</h2>
			<div class="share__buttons">
				<a class="button button--ghost" href="<?= esc($share['kakaotalk'] ?? '#') ?>" target="_blank" rel="noopener noreferrer">카카오톡</a>
				<a class="button button--ghost" href="<?= esc($share['facebook'] ?? '#') ?>" target="_blank" rel="noopener noreferrer">페이스북</a>
				<button class="button button--ghost" type="button" data-copy>링크 복사</button>
			</div>
		</section>

		<section class="greeting reveal">
			<h2 class="section-title">From. 신랑 & 신부</h2>
			<p class="greeting__intro">이름과 전화번호 뒷자리를 입력하시면<br>저희가 준비한 감사 메시지를 확인하실 수 있어요.</p>
			<div class="greeting__form">
				<input type="text" id="greetName" class="greeting__input" placeholder="이름" autocomplete="off">
				<input type="tel" id="greetPhone" class="greeting__input" placeholder="전화번호 뒷 4자리" maxlength="4" autocomplete="off">
				<button type="button" class="greeting__btn" id="greetBtn">확인</button>
			</div>
			<div class="greeting__result" id="greetResult" hidden>
				<div class="greeting__message" id="greetMessage"></div>
			</div>
			<div class="greeting__not-found" id="greetNotFound" hidden>
				<p>등록된 메시지를 찾지 못했어요.<br>이름과 번호를 다시 확인해 주세요.</p>
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
		const lb = document.getElementById('lightbox');
		const lbImg = lb.querySelector('.lightbox__img');
		const thumbs = Array.from(document.querySelectorAll('[data-lightbox]'));
		let lbIndex = 0;
		let scrollY = 0;

		function lbOpen(i) {
			lbIndex = i;
			lbImg.src = thumbs[i].dataset.lightbox;
			lbImg.alt = thumbs[i].querySelector('img').alt;
			scrollY = window.scrollY;
			document.body.style.top = -scrollY + 'px';
			document.body.classList.add('lightbox-open');
			lb.classList.add('active');
		}
		function lbClose() {
			lb.classList.remove('active');
			document.body.classList.remove('lightbox-open');
			document.body.style.top = '';
			window.scrollTo(0, scrollY);
		}
		function lbNav(dir) {
			lbIndex = (lbIndex + dir + thumbs.length) % thumbs.length;
			lbImg.style.opacity = 0;
			setTimeout(() => {
				lbImg.src = thumbs[lbIndex].dataset.lightbox;
				lbImg.alt = thumbs[lbIndex].querySelector('img').alt;
				lbImg.style.opacity = 1;
			}, 150);
		}

		thumbs.forEach((el, i) => el.addEventListener('click', () => lbOpen(i)));
		lb.querySelector('.lightbox__nav--prev').addEventListener('click', () => lbNav(-1));
		lb.querySelector('.lightbox__nav--next').addEventListener('click', () => lbNav(1));
		lb.addEventListener('click', e => {
			if (e.target === lb || e.target.classList.contains('lightbox__close')) lbClose();
		});

		let touchStartX = 0;
		lb.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; }, { passive: true });
		lb.addEventListener('touchend', e => {
			const dx = e.changedTouches[0].clientX - touchStartX;
			if (Math.abs(dx) > 50) lbNav(dx < 0 ? 1 : -1);
		});

		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry, i) => {
				if (entry.isIntersecting) {
					const el = entry.target;
					const siblings = el.parentElement.querySelectorAll('.reveal');
					const idx = Array.from(siblings).indexOf(el);
					if (idx > 0 && el.classList.contains('gallery__thumb')) {
						el.style.animationDelay = (idx * 0.06) + 's';
					} else if (el.classList.contains('timeline__item')) {
						el.style.animationDelay = (idx * 0.12) + 's';
					}
					el.classList.add('visible');
					observer.unobserve(el);
				}
			});
		}, { threshold: 0.15 });
		document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

		document.getElementById('greetBtn').addEventListener('click', searchGreeting);
		document.getElementById('greetPhone').addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); searchGreeting(); } });
		function searchGreeting() {
			const name = document.getElementById('greetName').value.trim();
			const phone = document.getElementById('greetPhone').value.trim();
			if (!name) { document.getElementById('greetName').focus(); return; }
			if (!phone) { document.getElementById('greetPhone').focus(); return; }
			document.getElementById('greetResult').hidden = true;
			document.getElementById('greetNotFound').hidden = true;
			fetch('<?= site_url("greeting/search") ?>?name=' + encodeURIComponent(name) + '&phone=' + encodeURIComponent(phone))
				.then(r => r.json())
				.then(data => {
					if (data.found) {
						document.getElementById('greetMessage').textContent = data.message;
						document.getElementById('greetResult').hidden = false;
					} else {
						document.getElementById('greetNotFound').hidden = false;
					}
				});
		}
	</script>
</body>
</html>
