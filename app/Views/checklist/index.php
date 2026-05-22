<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>체크리스트</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@300;400;500&display=swap" rel="stylesheet">
	<style>
		*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
		body {
			font-family: 'Noto Sans KR', -apple-system, sans-serif;
			background: #0a0a0a; color: #f5f5f7;
			min-height: 100vh;
		}
		.container { max-width: 600px; margin: 0 auto; padding: 40px 20px; }
		.header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; }
		.header h1 { font-size: 22px; font-weight: 500; }
		.back { color: #86868b; font-size: 13px; text-decoration: none; }
		.back:hover { color: #f5f5f7; }
		.add-row { display: flex; gap: 8px; margin-bottom: 24px; }
		.add-row input {
			flex: 1; padding: 12px 16px; border-radius: 10px;
			border: 1px solid #2c2c2e; background: #1c1c1e; color: #f5f5f7;
			font-family: inherit; font-size: 14px; outline: none;
		}
		.add-row input:focus { border-color: #48484a; }
		.add-row input::placeholder { color: #636366; }
		.btn {
			padding: 10px 20px; border-radius: 10px; border: none;
			background: #2c2c2e; color: #f5f5f7; font-family: inherit;
			font-size: 13px; font-weight: 500; cursor: pointer; transition: background .2s;
		}
		.btn:hover { background: #3a3a3c; }
		.btn--save { background: #b5a696; color: #0a0a0a; }
		.btn--save:hover { background: #c4b8aa; }
		.list { display: flex; flex-direction: column; gap: 6px; margin-bottom: 24px; }
		.item {
			display: flex; align-items: center; gap: 12px;
			padding: 14px 16px; background: #1c1c1e; border-radius: 10px;
			border: 1px solid #2c2c2e; transition: background .15s;
		}
		.item.checked { opacity: 0.5; }
		.item.checked .item__text { text-decoration: line-through; }
		.item input[type="checkbox"] {
			width: 18px; height: 18px; accent-color: #b5a696; cursor: pointer; flex-shrink: 0;
		}
		.item__text { flex: 1; font-size: 14px; }
		.item__delete {
			background: none; border: none; color: #636366; cursor: pointer;
			font-size: 16px; padding: 4px; line-height: 1; transition: color .2s;
		}
		.item__delete:hover { color: #ff453a; }
		.empty { text-align: center; padding: 40px 0; color: #636366; font-size: 14px; }
		.save-bar { position: sticky; bottom: 20px; }
		.toast {
			position: fixed; bottom: 80px; left: 50%; transform: translateX(-50%);
			padding: 10px 24px; background: #b5a696; color: #0a0a0a;
			border-radius: 999px; font-size: 13px; font-weight: 500;
			opacity: 0; transition: opacity .3s; pointer-events: none;
		}
		.toast.show { opacity: 1; }
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>체크리스트</h1>
			<a class="back" href="<?= site_url('/') ?>">홈으로</a>
		</div>
		<div class="add-row">
			<input type="text" id="newItem" placeholder="할 일을 입력하세요" autocomplete="off">
			<button type="button" class="btn" id="addBtn">추가</button>
		</div>
		<div class="list" id="list"></div>
		<div class="save-bar">
			<button type="button" class="btn btn--save" style="width:100%" id="saveBtn">저장</button>
		</div>
	</div>
	<div class="toast" id="toast">저장되었습니다</div>
	<script>
		const listEl = document.getElementById('list');
		const input = document.getElementById('newItem');
		let items = <?= json_encode($items ?? [], JSON_UNESCAPED_UNICODE) ?>;

		function render() {
			if (items.length === 0) {
				listEl.innerHTML = '<div class="empty">아직 항목이 없습니다</div>';
				return;
			}
			listEl.innerHTML = items.map((it, i) => `
				<div class="item ${it.checked ? 'checked' : ''}">
					<input type="checkbox" ${it.checked ? 'checked' : ''} data-i="${i}">
					<span class="item__text">${esc(it.text)}</span>
					<button type="button" class="item__delete" data-del="${i}">&times;</button>
				</div>
			`).join('');
		}

		function esc(s) {
			const d = document.createElement('div');
			d.textContent = s;
			return d.innerHTML;
		}

		input.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); addItem(); } });
		document.getElementById('addBtn').addEventListener('click', addItem);

		function addItem() {
			const text = input.value.trim();
			if (!text) return;
			items.push({ text, checked: false });
			input.value = '';
			render();
		}

		listEl.addEventListener('change', e => {
			if (e.target.dataset.i !== undefined) {
				items[+e.target.dataset.i].checked = e.target.checked;
				render();
			}
		});

		listEl.addEventListener('click', e => {
			if (e.target.dataset.del !== undefined) {
				items.splice(+e.target.dataset.del, 1);
				render();
			}
		});

		document.getElementById('saveBtn').addEventListener('click', () => {
			fetch('<?= site_url('checklist/save') ?>', {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(items)
			}).then(r => r.json()).then(() => {
				const toast = document.getElementById('toast');
				toast.classList.add('show');
				setTimeout(() => toast.classList.remove('show'), 2000);
			});
		});

		render();
	</script>
</body>
</html>
