(function(){
	// Search bar injection
	var articleEl = document.querySelector('.article');
	if (articleEl) {
		var css = document.createElement('style');
		css.textContent = '.search-float{max-width:720px;margin:0 auto 0;padding:12px 20px 0}.search-float__box{background:#fff;border-radius:12px;box-shadow:0 1px 3px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.04);padding:12px 16px;display:flex;gap:8px;align-items:center}.search-float__input{flex:1;border:1px solid #e5e5ea;border-radius:8px;padding:9px 12px;font-size:13px;font-family:inherit;outline:none;transition:border-color .15s}.search-float__input:focus{border-color:#667eea}.search-float__input::placeholder{color:#a1a1a6}.search-float__btn{border:none;border-radius:8px;padding:9px 14px;font-size:12px;font-weight:500;font-family:inherit;cursor:pointer;transition:opacity .15s;white-space:nowrap}.search-float__btn:hover{opacity:.8}.search-float__btn--naver{background:#03c75a;color:#fff}.search-float__btn--google{background:#4285f4;color:#fff}@media(max-width:600px){.search-float__box{flex-wrap:wrap}.search-float__input{width:100%}.search-float__btn{flex:1}}';
		document.head.appendChild(css);
		var bar = document.createElement('div');
		bar.className = 'search-float';
		bar.innerHTML = '<div class="search-float__box"><input type="text" class="search-float__input" id="searchInput" placeholder="모르는 용어를 검색해 보세요" autocomplete="off"><button type="button" class="search-float__btn search-float__btn--naver" id="btnNaver">네이버</button><button type="button" class="search-float__btn search-float__btn--google" id="btnGoogle">구글</button></div>';
		articleEl.parentNode.insertBefore(bar, articleEl);
		function gq(){return document.getElementById('searchInput').value.trim();}
		document.getElementById('btnNaver').addEventListener('click',function(){var q=gq();if(q)window.open('https://search.naver.com/search.naver?query='+encodeURIComponent(q),'_blank');});
		document.getElementById('btnGoogle').addEventListener('click',function(){var q=gq();if(q)window.open('https://www.google.com/search?q='+encodeURIComponent(q),'_blank');});
		document.getElementById('searchInput').addEventListener('keydown',function(e){if(e.key==='Enter'){e.preventDefault();var q=gq();if(q)window.open('https://search.naver.com/search.naver?query='+encodeURIComponent(q),'_blank');}});
	}

	var el = document.getElementById('articleContent');
	if (!el) return;
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

	var codePatterns = /^(class |interface |function |public |private |protected |static |\$|if |for |foreach |switch |return |echo |new |use |->|=>|\/\/|{|}|\[|\]|pip |mlflow )/;

	for (var i = 0; i < lines.length; i++) {
		var line = lines[i];
		var isCodeLine = /^    /.test(line) || /^\t/.test(line);
		var prevIsCode = codeBuf.length > 0;

		if (!inCode && isCodeLine && (line.trim().match(codePatterns) || prevIsCode)) {
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
				} else {
					var sublines = p.split('\n');
					if (sublines.length > 0 && /^## /.test(sublines[0])) {
						html += '<h2>' + sublines[0].replace(/^## /,'') + '</h2>';
						sublines.shift();
						if (sublines.length) html += '<p>' + sublines.join('<br>') + '</p>';
					} else {
						html += '<p>' + sublines.join('<br>') + '</p>';
					}
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
		var bar = document.getElementById('progressBar');
		if (bar) bar.style.width = (h > 0 ? (s/h)*100 : 0) + '%';
	});
})();
