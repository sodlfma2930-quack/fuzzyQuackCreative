<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>갤러리 관리</h1>

<div class="card">
	<div class="card__title">이미지 추가</div>
	<form method="post" action="<?= site_url('admin/gallery/upload') ?>" enctype="multipart/form-data">
		<?= csrf_field() ?>
		<div class="field">
			<label for="image">이미지 파일</label>
			<input type="file" id="image" name="image" accept="image/*" required>
		</div>
		<div class="field">
			<label for="alt">이미지 설명 (alt)</label>
			<input type="text" id="alt" name="alt" placeholder="예: 하늘 아래 손을 잡은 두 사람">
		</div>
		<button type="submit" class="btn btn--primary">업로드</button>
	</form>
</div>

<div class="card">
	<div class="card__title">등록된 이미지 (<?= count($images) ?>장)</div>

	<?php if (empty($images)) : ?>
		<p style="color: #86868b; font-size: 14px;">등록된 이미지가 없습니다.</p>
	<?php else : ?>
		<div class="gallery-grid">
			<?php foreach ($images as $img) : ?>
				<div class="gallery-item">
					<div class="gallery-item__img">
						<img src="<?= esc($img['src'] ?? '') ?>" alt="<?= esc($img['alt'] ?? '') ?>" loading="lazy">
					</div>
					<div class="gallery-item__info">
						<form method="post" action="<?= site_url('admin/gallery/alt/' . ($img['id'] ?? 0)) ?>" class="gallery-item__alt-form">
							<?= csrf_field() ?>
							<input type="text" name="alt" value="<?= esc($img['alt'] ?? '') ?>" placeholder="이미지 설명">
							<button type="submit" class="btn btn--small btn--primary">수정</button>
						</form>
						<form method="post" action="<?= site_url('admin/gallery/delete/' . ($img['id'] ?? 0)) ?>" onsubmit="return confirm('정말 삭제할까요?')">
							<?= csrf_field() ?>
							<button type="submit" class="btn btn--small btn--danger">삭제</button>
						</form>
					</div>
				</div>
			<?php endforeach ?>
		</div>
	<?php endif ?>
</div>

<style>
	.gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; }
	.gallery-item { border: 1px solid #e5e5ea; border-radius: 10px; overflow: hidden; background: #fafafa; }
	.gallery-item__img { aspect-ratio: 1; overflow: hidden; }
	.gallery-item__img img { width: 100%; height: 100%; object-fit: cover; }
	.gallery-item__info { padding: 12px; display: flex; flex-direction: column; gap: 8px; }
	.gallery-item__alt-form { display: flex; gap: 6px; }
	.gallery-item__alt-form input { flex: 1; padding: 6px 8px; border: 1px solid #d2d2d7; border-radius: 6px; font-size: 12px; }
</style>
<?= $this->endSection() ?>
