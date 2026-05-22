<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>감사 메시지 관리</h1>
<p style="color:#86868b;font-size:14px;margin:-16px 0 24px;">이름 + 전화번호 뒷4자리로 매칭됩니다. 청첩장 하단에서 하객이 자기 이름/번호를 입력하면 메시지가 표시됩니다.</p>

<div class="card">
	<div style="display:flex;gap:8px;margin-bottom:16px;">
		<input type="text" id="newName" placeholder="이름" style="flex:1;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;">
		<input type="text" id="newPhone" placeholder="전화번호" style="flex:1;padding:10px 12px;border:1px solid #d2d2d7;border-radius:8px;font-size:14px;">
		<button type="button" class="btn btn--primary" id="addBtn">추가</button>
	</div>
	<div id="list"></div>
	<button type="button" class="btn btn--primary" id="saveBtn" style="margin-top:16px;width:100%;">저장</button>
</div>

<div id="toast" style="position:fixed;bottom:40px;left:50%;transform:translateX(-50%);padding:10px 24px;background:#0071e3;color:#fff;border-radius:999px;font-size:13px;opacity:0;transition:opacity .3s;pointer-events:none;">저장되었습니다</div>

<style>
	.g-item { display:flex;gap:8px;align-items:flex-start;margin-bottom:10px;padding:14px;background:#f9f9fb;border:1px solid #e5e5ea;border-radius:10px; }
	.g-item__fields { flex:1;display:flex;flex-direction:column;gap:6px; }
	.g-item__row { display:flex;gap:8px; }
	.g-item__row input { flex:1;padding:8px 10px;border:1px solid #d2d2d7;border-radius:6px;font-size:13px; }
	.g-item textarea { width:100%;padding:8px 10px;border:1px solid #d2d2d7;border-radius:6px;font-size:13px;font-family:inherit;resize:vertical;min-height:60px; }
	.g-item__del { background:none;border:none;color:#ff3b30;font-size:20px;cursor:pointer;padding:4px 8px;line-height:1; }
	.g-item__del:hover { opacity:.7; }
	.empty-msg { text-align:center;padding:32px 0;color:#86868b;font-size:14px; }
</style>

<script>
let items = <?= json_encode($greetings ?? [], JSON_UNESCAPED_UNICODE) ?>;

function render() {
	const el = document.getElementById('list');
	if (items.length === 0) {
		el.innerHTML = '<div class="empty-msg">등록된 메시지가 없습니다</div>';
		return;
	}
	el.innerHTML = items.map((it, i) => `
		<div class="g-item">
			<div class="g-item__fields">
				<div class="g-item__row">
					<input type="text" value="${esc(it.name)}" data-i="${i}" data-f="name" placeholder="이름">
					<input type="text" value="${esc(it.phone)}" data-i="${i}" data-f="phone" placeholder="전화번호">
				</div>
				<textarea data-i="${i}" data-f="message" placeholder="감사 메시지">${esc(it.message)}</textarea>
			</div>
			<button type="button" class="g-item__del" data-del="${i}">&times;</button>
		</div>
	`).join('');
}

function esc(s) {
	const d = document.createElement('div');
	d.textContent = s || '';
	return d.innerHTML;
}

document.getElementById('addBtn').addEventListener('click', () => {
	const name = document.getElementById('newName').value.trim();
	const phone = document.getElementById('newPhone').value.trim();
	if (!name) { document.getElementById('newName').focus(); return; }
	items.push({ name, phone, message: '' });
	document.getElementById('newName').value = '';
	document.getElementById('newPhone').value = '';
	render();
	const textareas = document.querySelectorAll('.g-item textarea');
	if (textareas.length) textareas[textareas.length - 1].focus();
});

document.getElementById('list').addEventListener('input', e => {
	const i = e.target.dataset.i;
	const f = e.target.dataset.f;
	if (i !== undefined && f) {
		items[+i][f] = e.target.value;
	}
});

document.getElementById('list').addEventListener('click', e => {
	if (e.target.dataset.del !== undefined) {
		items.splice(+e.target.dataset.del, 1);
		render();
	}
});

document.getElementById('saveBtn').addEventListener('click', () => {
	fetch('<?= site_url("admin/greetings/save") ?>', {
		method: 'POST',
		headers: { 'Content-Type': 'application/json' },
		body: JSON.stringify(items)
	}).then(r => r.json()).then(() => {
		const toast = document.getElementById('toast');
		toast.style.opacity = '1';
		setTimeout(() => toast.style.opacity = '0', 2000);
	});
});

render();
</script>
<?= $this->endSection() ?>
