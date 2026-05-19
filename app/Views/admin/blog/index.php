<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>블로그 관리</h1>

<div style="margin-bottom: 20px;">
	<a href="<?= site_url('admin/blog/create') ?>" class="btn btn--primary">새 글 작성</a>
</div>

<?php if (empty($posts)) : ?>
	<div class="card">
		<p style="color: #86868b; font-size: 14px;">아직 작성된 글이 없습니다.</p>
	</div>
<?php else : ?>
	<div class="card">
		<table style="width: 100%; border-collapse: collapse; font-size: 14px;">
			<thead>
				<tr style="border-bottom: 1px solid #e5e5ea; text-align: left;">
					<th style="padding: 10px 8px; color: #86868b; font-weight: 500;">제목</th>
					<th style="padding: 10px 8px; color: #86868b; font-weight: 500; width: 100px;">날짜</th>
					<th style="padding: 10px 8px; color: #86868b; font-weight: 500; width: 120px;">관리</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($posts as $post) : ?>
					<tr style="border-bottom: 1px solid #f0f0f0;">
						<td style="padding: 12px 8px;">
							<a href="<?= site_url('blog/' . esc($post['slug'] ?? '')) ?>" target="_blank" style="color: #1d1d1f; text-decoration: none; font-weight: 500;">
								<?= esc($post['title'] ?? '') ?>
							</a>
						</td>
						<td style="padding: 12px 8px; color: #86868b;"><?= esc($post['created_at'] ?? '') ?></td>
						<td style="padding: 12px 8px; display: flex; gap: 6px;">
							<a href="<?= site_url('admin/blog/edit/' . ($post['id'] ?? 0)) ?>" class="btn btn--small btn--primary">수정</a>
							<form method="post" action="<?= site_url('admin/blog/delete/' . ($post['id'] ?? 0)) ?>" onsubmit="return confirm('정말 삭제할까요?')" style="margin:0;">
								<?= csrf_field() ?>
								<button type="submit" class="btn btn--small btn--danger">삭제</button>
							</form>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
<?php endif ?>
<?= $this->endSection() ?>
