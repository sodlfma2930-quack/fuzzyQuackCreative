<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1><?= esc($pageTitle) ?></h1>

<?php
	$isEdit = $post !== null;
	$action = $isEdit
		? site_url('admin/blog/update/' . ($post['id'] ?? 0))
		: site_url('admin/blog/store');
?>

<form method="post" action="<?= $action ?>" enctype="multipart/form-data">
	<?= csrf_field() ?>

	<div class="card">
		<div class="field">
			<label for="title">제목</label>
			<input type="text" id="title" name="title" value="<?= esc($post['title'] ?? '') ?>" required>
		</div>
		<div class="field">
			<label for="content">내용</label>
			<textarea id="content" name="content" rows="12" required><?= esc($post['content'] ?? '') ?></textarea>
		</div>
		<div class="field">
			<label for="thumbnail">썸네일 이미지</label>
			<?php if ($isEdit && ! empty($post['thumbnail'])) : ?>
				<div style="margin-bottom: 8px;">
					<img src="<?= esc($post['thumbnail']) ?>" style="max-width: 200px; border-radius: 8px;" alt="">
				</div>
			<?php endif ?>
			<input type="file" id="thumbnail" name="thumbnail" accept="image/*">
		</div>
	</div>

	<div style="display: flex; gap: 8px;">
		<button type="submit" class="btn btn--primary"><?= $isEdit ? '수정하기' : '등록하기' ?></button>
		<a href="<?= site_url('admin/blog') ?>" class="btn" style="background: #e5e5ea; color: #1d1d1f;">취소</a>
	</div>
</form>
<?= $this->endSection() ?>
