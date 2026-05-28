<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tech Blog — FuzzyQuackCreative</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;600;700&family=Noto+Sans+KR:wght@300;400;500;700&display=swap" rel="stylesheet">
	<style>
		*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
		body {
			font-family: 'Noto Sans KR', -apple-system, BlinkMacSystemFont, sans-serif;
			background: #f5f5f7; color: #1d1d1f;
			-webkit-font-smoothing: antialiased;
		}

		.header {
			background: rgba(255,255,255,.72); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
			border-bottom: 1px solid rgba(0,0,0,.08); padding: 14px 24px;
			display: flex; align-items: center; justify-content: space-between;
			position: sticky; top: 0; z-index: 100;
		}
		.header__title { font-family: 'Outfit', sans-serif; font-size: 17px; font-weight: 600; }
		.header__back { font-size: 13px; color: #0071e3; text-decoration: none; transition: opacity .15s; }
		.header__back:hover { opacity: .7; }

		.hero {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			padding: 52px 20px 44px; text-align: center; color: #fff;
		}
		.hero h1 { font-family: 'Outfit', sans-serif; font-size: 32px; font-weight: 700; margin-bottom: 8px; }
		.hero p { font-size: 15px; opacity: .8; }

		.container { max-width: 760px; margin: -20px auto 60px; padding: 0 20px; }
		.post-list { list-style: none; display: flex; flex-direction: column; gap: 16px; }

		.post-card {
			display: flex; background: #fff; border-radius: 14px;
			overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.03);
			text-decoration: none; color: inherit;
			transition: transform .2s ease, box-shadow .2s ease;
		}
		.post-card:hover {
			transform: translateY(-3px);
			box-shadow: 0 4px 16px rgba(0,0,0,.08), 0 12px 32px rgba(0,0,0,.06);
		}

		.post-card__thumb {
			width: 180px; min-height: 150px; flex-shrink: 0;
			display: flex; align-items: center; justify-content: center; font-size: 42px;
		}
		.post-card__thumb img { width: 100%; height: 100%; object-fit: cover; }

		.post-card__body { padding: 22px 24px; display: flex; flex-direction: column; justify-content: center; }
		.post-card__date {
			font-size: 12px; color: #86868b; margin-bottom: 8px;
			font-weight: 400; letter-spacing: .3px;
		}
		.post-card__title {
			font-size: 17px; font-weight: 600; line-height: 1.45;
			margin-bottom: 10px; color: #1d1d1f;
		}
		.post-card__excerpt {
			font-size: 13.5px; color: #6e6e73; line-height: 1.6;
			display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
		}
		.post-card__arrow {
			margin-left: auto; padding: 0 20px; display: flex; align-items: center;
			color: #c7c7cc; font-size: 18px; flex-shrink: 0;
		}

		.empty { text-align: center; padding: 80px 0; color: #86868b; font-size: 15px; }

		.search-bar {
			background: #fff; border-radius: 14px;
			box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.03);
			padding: 16px 20px; margin-bottom: 20px;
			display: flex; gap: 8px; align-items: center;
		}
		.search-bar__input {
			flex: 1; border: 1px solid #e5e5ea; border-radius: 8px;
			padding: 10px 14px; font-size: 14px; font-family: inherit;
			outline: none; transition: border-color .15s;
		}
		.search-bar__input:focus { border-color: #667eea; }
		.search-bar__input::placeholder { color: #a1a1a6; }
		.search-bar__btn {
			border: none; border-radius: 8px; padding: 10px 16px;
			font-size: 13px; font-weight: 500; font-family: inherit;
			cursor: pointer; transition: opacity .15s; white-space: nowrap;
		}
		.search-bar__btn:hover { opacity: .8; }
		.search-bar__btn--naver { background: #03c75a; color: #fff; }
		.search-bar__btn--google { background: #4285f4; color: #fff; }

		@media (max-width: 600px) {
			.hero h1 { font-size: 26px; }
			.post-card { flex-direction: column; }
			.post-card__thumb { width: 100%; min-height: 120px; }
			.post-card__arrow { display: none; }
			.search-bar { flex-wrap: wrap; }
			.search-bar__input { width: 100%; }
			.search-bar__btn { flex: 1; }
		}
	</style>
</head>
<body>
	<header class="header">
		<div class="header__title">Tech Blog</div>
		<a class="header__back" href="<?= site_url('/') ?>">← 홈으로</a>
	</header>

	<div class="hero">
		<h1>Tech Blog</h1>
		<p>개발 경험과 기술을 기록합니다</p>
	</div>

	<?php
	$iconMap = [
		'mcp'       => ['🔗', '#e8f5e9', '#43a047'],
		'mlflow'    => ['📊', '#fff3e0', '#ef6c00'],
		'hosting'   => ['☁️', '#e3f2fd', '#1565c0'],
		'free'      => ['☁️', '#e3f2fd', '#1565c0'],
		'pattern'   => ['🏛️', '#fce4ec', '#c62828'],
		'singleton' => ['🏛️', '#fce4ec', '#c62828'],
		'auto-blog' => ['✍️', '#ede7f6', '#5e35b1'],
		'claude'    => ['✍️', '#ede7f6', '#5e35b1'],
		'json'      => ['🗄️', '#e0f2f1', '#00695c'],
		'ci4'       => ['🗄️', '#e0f2f1', '#00695c'],
		'wasm'      => ['⚡', '#fff8e1', '#f9a825'],
		'webassembly' => ['⚡', '#fff8e1', '#f9a825'],
		'github-pages' => ['🚀', '#e8eaf6', '#3949ab'],
		'deployment' => ['🚀', '#e8eaf6', '#3949ab'],
		'rag'       => ['🔍', '#e8f5e9', '#2e7d32'],
		'retrieval' => ['🔍', '#e8f5e9', '#2e7d32'],
		'agent'     => ['🤖', '#fff3e0', '#e65100'],
		'crewai'    => ['🤖', '#fff3e0', '#e65100'],
		'autogen'   => ['🤖', '#fff3e0', '#e65100'],
		'langchain' => ['🤖', '#fff3e0', '#e65100'],
		'prompt'    => ['💬', '#fce4ec', '#ad1457'],
		'git'       => ['🏷️', '#e8eaf6', '#3949ab'],
		'tagging'   => ['🏷️', '#e8eaf6', '#3949ab'],
		'vector'    => ['🧮', '#e3f2fd', '#1565c0'],
		'pinecone'  => ['🧮', '#e3f2fd', '#1565c0'],
		'chromadb'  => ['🧮', '#e3f2fd', '#1565c0'],
		'edge'      => ['📱', '#e0f2f1', '#00695c'],
		'tinyml'    => ['📱', '#e0f2f1', '#00695c'],
		'on-device' => ['📱', '#e0f2f1', '#00695c'],
		'coding-agent' => ['🛠️', '#e8f5e9', '#2e7d32'],
		'cursor'    => ['🛠️', '#e8f5e9', '#2e7d32'],
		'copilot'   => ['🛠️', '#e8f5e9', '#2e7d32'],
		'opentelemetry' => ['📡', '#ede7f6', '#4527a0'],
		'observability' => ['📡', '#ede7f6', '#4527a0'],
		'tracing'   => ['📡', '#ede7f6', '#4527a0'],
	];

	function getPostIcon(string $slug, array $map): array {
		foreach ($map as $keyword => $icon) {
			if (stripos($slug, $keyword) !== false) {
				return $icon;
			}
		}
		return ['📝', '#f3e5f5', '#7b1fa2'];
	}

	function formatDate(string $datetime): string {
		$ts = strtotime($datetime);
		if ($ts === false) return $datetime;
		return date('Y.m.d H:i', $ts);
	}
	?>

	<div class="container">
		<div class="search-bar">
			<input type="text" class="search-bar__input" id="searchInput" placeholder="모르는 용어를 검색해 보세요" autocomplete="off">
			<button type="button" class="search-bar__btn search-bar__btn--naver" onclick="searchNaver()">네이버</button>
			<button type="button" class="search-bar__btn search-bar__btn--google" onclick="searchGoogle()">구글</button>
		</div>
		<script>
		function getQuery(){return document.getElementById('searchInput').value.trim();}
		function searchNaver(){var q=getQuery();if(q)window.open('https://search.naver.com/search.naver?query='+encodeURIComponent(q),'_blank');}
		function searchGoogle(){var q=getQuery();if(q)window.open('https://www.google.com/search?q='+encodeURIComponent(q),'_blank');}
		document.getElementById('searchInput').addEventListener('keydown',function(e){if(e.key==='Enter'){e.preventDefault();searchNaver();}});
		</script>
		<?php if (empty($posts)) : ?>
			<div class="empty">아직 작성된 글이 없어요.</div>
		<?php else : ?>
			<ul class="post-list">
				<?php foreach ($posts as $post) :
					[$emoji, $bg, $accent] = getPostIcon($post['slug'] ?? '', $iconMap);
				?>
					<li>
						<a class="post-card" href="<?= site_url('blog/' . esc($post['slug'] ?? '')) ?>">
							<div class="post-card__thumb" style="background: linear-gradient(135deg, <?= $bg ?>, <?= $bg ?>dd);">
								<?php if (! empty($post['thumbnail'])) : ?>
									<img src="<?= esc($post['thumbnail']) ?>" alt="">
								<?php else : ?>
									<?= $emoji ?>
								<?php endif ?>
							</div>
							<div class="post-card__body">
								<div class="post-card__date"><?= esc(formatDate($post['created_at'] ?? '')) ?></div>
								<h2 class="post-card__title"><?= esc($post['title'] ?? '') ?></h2>
								<p class="post-card__excerpt"><?= esc(mb_substr($post['content'] ?? '', 0, 100)) ?>...</p>
							</div>
							<div class="post-card__arrow">›</div>
						</a>
					</li>
				<?php endforeach ?>
			</ul>
		<?php endif ?>
	</div>
</body>
</html>
