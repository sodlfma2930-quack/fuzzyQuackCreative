<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= esc($post['title'] ?? '블로그') ?> — FuzzyQuackCreative</title>
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

		.article { max-width: 680px; margin: 0 auto; padding: 40px 20px; }
		.article__date { font-size: 13px; color: #86868b; margin-bottom: 8px; }
		.article__title { font-size: 26px; font-weight: 600; line-height: 1.4; margin-bottom: 24px; }
		.article__thumb { width: 100%; border-radius: 12px; margin-bottom: 28px; }
		.article__content {
			font-size: 15px; line-height: 1.8; color: #333;
			white-space: pre-wrap; word-break: keep-all;
		}
	</style>
</head>
<body>
	<header class="header">
		<div class="header__title">Tech Blog</div>
		<a class="header__back" href="<?= site_url('blog') ?>">← 목록으로</a>
	</header>
	<article class="article">
		<p class="article__date"><?= esc($post['created_at'] ?? '') ?></p>
		<h1 class="article__title"><?= esc($post['title'] ?? '') ?></h1>
		<?php if (! empty($post['thumbnail'])) : ?>
			<img class="article__thumb" src="<?= esc($post['thumbnail']) ?>" alt="">
		<?php endif ?>
		<div class="article__content"><?= esc($post['content'] ?? '') ?></div>
	</article>
</body>
</html>
