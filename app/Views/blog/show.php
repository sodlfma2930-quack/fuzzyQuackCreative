<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= esc($post['title'] ?? '블로그') ?> — FuzzyQuackCreative</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;500;600&family=Noto+Sans+KR:wght@300;400;500;700&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
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
		.header__title { font-family: 'Outfit', sans-serif; font-size: 17px; font-weight: 600; color: #1d1d1f; }
		.header__back {
			font-size: 13px; color: #0071e3; text-decoration: none;
			display: flex; align-items: center; gap: 4px;
			transition: opacity .15s;
		}
		.header__back:hover { opacity: .7; }

		.hero {
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			padding: 60px 20px 50px; text-align: center; color: #fff;
		}
		.hero__date {
			font-size: 13px; opacity: .75; margin-bottom: 12px;
			letter-spacing: .5px; text-transform: uppercase;
		}
		.hero__title {
			font-size: 30px; font-weight: 700; line-height: 1.35;
			max-width: 680px; margin: 0 auto;
		}

		.article {
			max-width: 720px; margin: -24px auto 60px; padding: 0 20px;
		}
		.article__body {
			background: #fff; border-radius: 16px;
			box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 8px 24px rgba(0,0,0,.04);
			padding: 40px 36px;
		}

		.article__content { font-size: 16px; line-height: 2; color: #333; word-break: keep-all; }
		.article__content p { margin-bottom: 18px; }
		.article__content p:last-child { margin-bottom: 0; }

		.article__content h2 {
			font-size: 21px; font-weight: 700; color: #1d1d1f;
			margin: 44px 0 18px; padding-bottom: 10px;
			border-bottom: 2px solid #667eea; display: inline-block;
		}
		.article__content h2::before {
			content: ''; display: inline-block; width: 4px; height: 21px;
			background: #667eea; border-radius: 2px; margin-right: 10px;
			vertical-align: text-bottom;
		}

		.article__content pre {
			background: #1e1e2e; color: #cdd6f4; border-radius: 12px;
			padding: 20px 24px; margin: 20px 0; overflow-x: auto;
			font-family: 'Fira Code', monospace; font-size: 13.5px; line-height: 1.7;
			border: 1px solid rgba(255,255,255,.06);
		}
		.article__content code {
			font-family: 'Fira Code', monospace; font-size: 14px;
			background: #f0f0f5; color: #e74c8b; padding: 2px 7px;
			border-radius: 5px;
		}
		.article__content pre code {
			background: none; color: inherit; padding: 0; border-radius: 0; font-size: 13.5px;
		}

		.article__content .callout {
			background: linear-gradient(135deg, #f0f4ff, #f8f0ff);
			border-left: 4px solid #667eea; border-radius: 0 10px 10px 0;
			padding: 16px 20px; margin: 20px 0; font-size: 15px; color: #444;
		}

		.article__content strong { color: #1d1d1f; font-weight: 600; }

		.article__content ul, .article__content ol {
			margin: 12px 0 18px 20px; padding: 0;
		}
		.article__content li { margin-bottom: 8px; line-height: 1.8; }

		.progress-bar {
			position: fixed; top: 0; left: 0; height: 3px;
			background: linear-gradient(90deg, #667eea, #764ba2);
			z-index: 200; width: 0; transition: width .1s linear;
		}

		@media (max-width: 600px) {
			.hero { padding: 40px 16px 36px; }
			.hero__title { font-size: 23px; }
			.article__body { padding: 28px 20px; border-radius: 12px; }
			.article__content { font-size: 15px; }
			.article__content h2 { font-size: 19px; }
			.article__content pre { padding: 16px; font-size: 12.5px; }
		}
	</style>
</head>
<body>
	<div class="progress-bar" id="progressBar"></div>

	<header class="header">
		<div class="header__title">Tech Blog</div>
		<a class="header__back" href="<?= site_url('blog') ?>">← 목록으로</a>
	</header>

	<?php
	$ts = strtotime($post['created_at'] ?? '');
	$displayDate = $ts ? date('Y.m.d H:i', $ts) : esc($post['created_at'] ?? '');
	?>
	<div class="hero">
		<p class="hero__date"><?= $displayDate ?></p>
		<h1 class="hero__title"><?= esc($post['title'] ?? '') ?></h1>
	</div>

	<article class="article">
		<div class="article__body">
			<?php if (! empty($post['thumbnail'])) : ?>
				<img style="width:100%;border-radius:12px;margin-bottom:28px;" src="<?= esc($post['thumbnail']) ?>" alt="">
			<?php endif ?>
			<div class="article__content" id="articleContent"><?= esc($post['content'] ?? '') ?></div>
		</div>
	</article>

	<script>
	(function(){
		var el = document.getElementById('articleContent');
		var raw = el.textContent;

		var blocks = [];
		var lines = raw.split('\n');
		var inCode = false;
		var codeBuf = [];
		var textBuf = [];

		function flushText() {
			if (textBuf.length) {
				var t = textBuf.join('\n').trim();
				if (t) blocks.push({type:'text', value:t});
				textBuf = [];
			}
		}

		for (var i = 0; i < lines.length; i++) {
			var line = lines[i];
			var isCodeLine = /^    /.test(line) || /^\t/.test(line);
			var nextIsCode = i+1 < lines.length && (/^    /.test(lines[i+1]) || /^\t/.test(lines[i+1]));
			var prevIsCode = codeBuf.length > 0;

			if (!inCode && isCodeLine && (line.trim().match(/^(class |interface |function |public |private |protected |static |\$|if |for |foreach |switch |return |echo |new |use |->|=>|\/\/|{|}|\[|\]|pip |mlflow )/) || prevIsCode)) {
				if (!prevIsCode) flushText();
				inCode = true;
			}

			if (inCode) {
				if (!isCodeLine && line.trim() !== '' && !line.trim().match(/^(class |interface |function |public |private |protected |static |\$|if |for |foreach |switch |return |echo |new |use |->|=>|\/\/|{|}|\)|\];|default|'card'|'phone')/)) {
					blocks.push({type:'code', value: codeBuf.join('\n')});
					codeBuf = [];
					inCode = false;
					textBuf.push(line);
				} else {
					codeBuf.push(line.replace(/^    /, '').replace(/^\t/, ''));
				}
			} else {
				textBuf.push(line);
			}
		}
		if (codeBuf.length) blocks.push({type:'code', value: codeBuf.join('\n')});
		flushText();

		var html = '';
		blocks.forEach(function(b){
			if (b.type === 'code') {
				var code = b.value.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
				html += '<pre><code>' + code + '</code></pre>';
			} else {
				var paras = b.value.split(/\n\n+/);
				paras.forEach(function(p){
					p = p.trim();
					if (!p) return;
					if (/^## /.test(p)) {
						html += '<h2>' + p.replace(/^## /,'') + '</h2>';
					} else if (/\n/.test(p)) {
						var sublines = p.split('\n');
						var allHeading = false;
						if (sublines.length > 0 && /^## /.test(sublines[0])) {
							html += '<h2>' + sublines[0].replace(/^## /,'') + '</h2>';
							sublines.shift();
							if (sublines.length) html += '<p>' + sublines.join('<br>') + '</p>';
						} else {
							html += '<p>' + sublines.join('<br>') + '</p>';
						}
					} else {
						html += '<p>' + p + '</p>';
					}
				});
			}
		});

		html = html.replace(/`([^`]+)`/g, '<code>$1</code>');
		html = html.replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>');

		el.innerHTML = html;

		window.addEventListener('scroll', function(){
			var h = document.documentElement.scrollHeight - window.innerHeight;
			var s = window.scrollY;
			document.getElementById('progressBar').style.width = (h > 0 ? (s/h)*100 : 0) + '%';
		});
	})();
	</script>
</body>
</html>
