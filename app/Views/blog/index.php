<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tech Blog — FuzzyQuackCreative</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;600&family=Noto+Sans+KR:wght@300;400;500&display=swap" rel="stylesheet">
	<style>
		*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
		body { font-family: 'Noto Sans KR', -apple-system, sans-serif; background: #fafafa; color: #1d1d1f; }

		.header {
			background: #fff; border-bottom: 1px solid #e5e5ea; padding: 16px 24px;
			display: flex; align-items: center; justify-content: space-between;
		}
		.header__title { font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 600; }
		.header__back { font-size: 14px; color: #0071e3; text-decoration: none; }

		.container { max-width: 720px; margin: 0 auto; padding: 32px 20px; }

		.post-list { list-style: none; display: flex; flex-direction: column; gap: 20px; }

		.post-card {
			display: flex; gap: 20px; background: #fff; border-radius: 12px;
			overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.06);
			text-decoration: none; color: inherit; transition: transform .15s, box-shadow .15s;
		}
		.post-card:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,.1); }

		.post-card__thumb {
			width: 160px; min-height: 140px; flex-shrink: 0; background: #e5e5ea;
			display: flex; align-items: center; justify-content: center; color: #a1a1a6; font-size: 32px;
		}
		.post-card__thumb img { width: 100%; height: 100%; object-fit: cover; }

		.post-card__body { padding: 20px; display: flex; flex-direction: column; justify-content: center; }
		.post-card__date { font-size: 12px; color: #86868b; margin-bottom: 6px; }
		.post-card__title { font-size: 17px; font-weight: 600; line-height: 1.4; margin-bottom: 8px; }
		.post-card__excerpt { font-size: 13px; color: #6e6e73; line-height: 1.5; }

		.empty { text-align: center; padding: 60px 0; color: #86868b; font-size: 15px; }

		@media (max-width: 480px) {
			.post-card { flex-direction: column; }
			.post-card__thumb { width: 100%; min-height: 180px; }
		}
	</style>
</head>
<body>
	<header class="header">
		<div class="header__title">Tech Blog</div>
		<a class="header__back" href="<?= site_url('/') ?>">← 홈으로</a>
	</header>
	<div class="container">
		<?php if (empty($posts)) : ?>
			<div class="empty">아직 작성된 글이 없어요.</div>
		<?php else : ?>
			<ul class="post-list">
				<?php foreach ($posts as $post) : ?>
					<li>
						<a class="post-card" href="<?= site_url('blog/' . esc($post['slug'] ?? '')) ?>">
							<div class="post-card__thumb">
								<?php if (! empty($post['thumbnail'])) : ?>
									<img src="<?= esc($post['thumbnail']) ?>" alt="">
								<?php else : ?>
									📝
								<?php endif ?>
							</div>
							<div class="post-card__body">
								<div class="post-card__date"><?= esc($post['created_at'] ?? '') ?></div>
								<h2 class="post-card__title"><?= esc($post['title'] ?? '') ?></h2>
								<p class="post-card__excerpt"><?= esc(mb_substr($post['content'] ?? '', 0, 80)) ?>...</p>
							</div>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
	</div>
</body>
</html>
