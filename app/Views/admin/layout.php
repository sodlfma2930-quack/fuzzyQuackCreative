<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= esc($pageTitle ?? '관리자') ?> — 청첩장 관리</title>
	<style>
		*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
		body { font-family: 'Noto Sans KR', -apple-system, sans-serif; background: #f5f5f7; color: #1d1d1f; }
		a { color: #0071e3; text-decoration: none; }

		.layout { display: flex; min-height: 100vh; }

		.sidebar {
			width: 220px; background: #1d1d1f; color: #f5f5f7; padding: 24px 0;
			display: flex; flex-direction: column; flex-shrink: 0;
		}
		.sidebar__title { font-size: 14px; font-weight: 600; padding: 0 20px 20px; border-bottom: 1px solid #333; }
		.sidebar__nav { list-style: none; padding: 12px 0; }
		.sidebar__nav li a {
			display: block; padding: 10px 20px; font-size: 14px; color: #a1a1a6; transition: .15s;
		}
		.sidebar__nav li a:hover, .sidebar__nav li a.active { color: #f5f5f7; background: #333; }
		.sidebar__back { margin-top: auto; padding: 12px 20px; font-size: 13px; }
		.sidebar__back a { color: #86868b; }

		.main { flex: 1; padding: 32px 40px; max-width: 900px; }
		.main h1 { font-size: 24px; font-weight: 600; margin-bottom: 24px; }

		.alert {
			padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px;
		}
		.alert--success { background: #d1f2eb; color: #0d6e4e; }
		.alert--error { background: #fde8e8; color: #c0392b; }

		.card {
			background: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px;
			box-shadow: 0 1px 3px rgba(0,0,0,.08);
		}
		.card__title { font-size: 16px; font-weight: 600; margin-bottom: 16px; color: #1d1d1f; }

		.field { margin-bottom: 16px; }
		.field label { display: block; font-size: 13px; font-weight: 500; color: #6e6e73; margin-bottom: 4px; }
		.field input, .field textarea {
			width: 100%; padding: 10px 12px; border: 1px solid #d2d2d7; border-radius: 8px;
			font-size: 14px; font-family: inherit; transition: border .15s;
		}
		.field input:focus, .field textarea:focus { outline: none; border-color: #0071e3; }
		.field textarea { resize: vertical; min-height: 80px; }

		.btn {
			display: inline-flex; align-items: center; gap: 6px;
			padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px;
			font-weight: 500; cursor: pointer; transition: .15s;
		}
		.btn--primary { background: #0071e3; color: #fff; }
		.btn--primary:hover { background: #0077ed; }
		.btn--danger { background: #ff3b30; color: #fff; }
		.btn--danger:hover { background: #e0332b; }
		.btn--small { padding: 6px 12px; font-size: 12px; }

		@media (max-width: 768px) {
			.layout { flex-direction: column; }
			.sidebar { width: 100%; flex-direction: row; padding: 12px 16px; align-items: center; gap: 16px; }
			.sidebar__title { padding: 0; border: none; }
			.sidebar__nav { display: flex; gap: 4px; padding: 0; }
			.sidebar__nav li a { padding: 6px 12px; border-radius: 6px; }
			.sidebar__back { margin-top: 0; margin-left: auto; padding: 0; }
			.main { padding: 20px 16px; }
		}
	</style>
</head>
<body>
	<div class="layout">
		<aside class="sidebar">
			<div class="sidebar__title">청첩장 관리</div>
			<ul class="sidebar__nav">
				<li><a href="<?= site_url('admin/texts') ?>" class="<?= uri_string() === 'admin/texts' ? 'active' : '' ?>">텍스트 관리</a></li>
				<li><a href="<?= site_url('admin/gallery') ?>" class="<?= uri_string() === 'admin/gallery' ? 'active' : '' ?>">갤러리 관리</a></li>
				<li><a href="<?= site_url('admin/blog') ?>" class="<?= str_starts_with(uri_string(), 'admin/blog') ? 'active' : '' ?>">블로그 관리</a></li>
				<li><a href="<?= site_url('admin/greetings') ?>" class="<?= str_starts_with(uri_string(), 'admin/greetings') ? 'active' : '' ?>">감사 메시지</a></li>
			</ul>
			<div class="sidebar__back">
				<a href="<?= site_url('/') ?>">← 청첩장 보기</a>
			</div>
		</aside>
		<main class="main">
			<?php if (session()->getFlashdata('success')) : ?>
				<div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
			<?php endif ?>
			<?php if (session()->getFlashdata('error')) : ?>
				<div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
			<?php endif ?>

			<?= $this->renderSection('content') ?>
		</main>
	</div>
</body>
</html>
