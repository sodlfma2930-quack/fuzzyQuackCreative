(function(){
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
