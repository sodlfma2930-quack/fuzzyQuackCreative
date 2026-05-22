<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>감사 메시지 관리</h1>
<p style="color:#86868b;font-size:14px;margin:-16px 0 24px;">이름 + 전화번호 뒷4자리로 매칭됩니다. 각 메시지는 개별 저장됩니다.</p>

<div class="card">
	<div class="card__title">새 메시지 추가</div>
	<div style="display:flex;gap:8px;flex-wrap:wrap;">
		<input type="text" id="newName" placeholder="이름" style="flex:1;min-width:80px;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;">
		<input type="text" id="newPhone" placeholder="전화번호" style="flex:1;min-width:120px;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;">
	</div>
	<textarea id="newMsg" placeholder="감사 메시지를 입력하세요" style="width:100%;margin-top:8px;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;font-family:inherit;resize:vertical;min-height:70px;"></textarea>
	<button type="button" class="btn btn--primary" id="addBtn" style="margin-top:10px;">추가</button>
</div>

<div id="list"></div>

<div id="toast" style="position:fixed;bottom:40px;left:50%;transform:translateX(-50%);padding:10px 24px;background:#0071e3;color:#fff;border-radius:999px;font-size:13px;opacity:0;transition:opacity .3s;pointer-events:none;z-index:100;"></div>

<style>
	.g-card { background:#fff;border-radius:12px;padding:20px 24px;margin-bottom:12px;box-shadow:0 1px 3px rgba(0,0,0,.08); }
	.g-card__head { display:flex;justify-content:space-between;align-items:center;margin-bottom:12px; }
	.g-card__name { font-size:16px;font-weight:600;color:#1d1d1f; }
	.g-card__phone { font-size:13px;color:#86868b; }
	.g-card textarea { width:100%;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;font-family:inherit;resize:vertical;min-height:60px; }
	.g-card__actions { display:flex;gap:8px;margin-top:10px; }
	.empty-msg { text-align:center;padding:40px 0;color:#86868b;font-size:14px; }
</style>

<script>
let items = <?= json_encode($greetings ?? [], JSON_UNESCAPED_UNICODE) ?>;
const BASE = '<?= site_url("admin/greetings") ?>';

function showToast(msg) {
	const t = document.getElementById('toast');
	t.textContent = msg;
	t.style.opacity = '1';
	setTimeout(() => t.style.opacity = '0', 2000);
}

function esc(s) {
	const d = document.createElement('div');
	d.textContent = s || '';
	return d.innerHTML;
}

function render() {
	const el = document.getElementById('list');
	if (items.length === 0) {
		el.innerHTML = '<div class="empty-msg">등록된 메시지가 없습니다</div>';
		return;
	}
	el.innerHTML = items.map((it, i) => `
		<div class="g-card">
			<div class="g-card__head">
				<span class="g-card__name">${esc(it.name)}</span>
				<span class="g-card__phone">${esc(it.phone)}</span>
			</div>
			<textarea id="msg-${i}">${esc(it.message)}</textarea>
			<div class="g-card__actions">
				<button class="btn btn--primary btn--small" onclick="saveItem(${i})">저장</button>
				<button class="btn btn--danger btn--small" onclick="deleteItem(${i}, '${esc(it.name)}')">삭제</button>
			</div>
		</div>
	`).join('');
}

document.getElementById('addBtn').addEventListener('click', () => {
	const name = document.getElementById('newName').value.trim();
	const phone = document.getElementById('newPhone').value.trim();
	const message = document.getElementById('newMsg').value.trim();
	if (!name) { document.getElementById('newName').focus(); return; }
	if (!message) { document.getElementById('newMsg').focus(); return; }

	fetch(BASE + '/add', {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify({ name, phone, message })
	}).then(r => r.json()).then(data => {
		if (data.ok) {
			items.push({ name, phone, message });
			document.getElementById('newName').value = '';
			document.getElementById('newPhone').value = '';
			document.getElementById('newMsg').value = '';
			render();
			showToast(name + '님 메시지 추가됨');
		}
	});
});

function saveItem(i) {
	const msg = document.getElementById('msg-' + i).value.trim();
	if (!msg) return;
	items[i].message = msg;

	fetch(BASE + '/update/' + i, {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(items[i])
	}).then(r => r.json()).then(data => {
		if (data.ok) showToast(items[i].name + '님 메시지 저장됨');
	});
}

function deleteItem(i, name) {
	if (!confirm(name + '님의 메시지를 삭제할까요?')) return;

	fetch(BASE + '/delete/' + i, {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' }
	}).then(r => r.json()).then(data => {
		if (data.ok) {
			items.splice(i, 1);
			render();
			showToast(name + '님 메시지 삭제됨');
		}
	});
}

render();
</script>
<?= $this->endSection() ?>
