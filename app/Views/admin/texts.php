<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<h1>텍스트 관리</h1>

<form method="post" action="<?= site_url('admin/texts') ?>">
	<?= csrf_field() ?>

	<div class="card">
		<div class="card__title">히어로 섹션</div>
		<div class="field">
			<label for="hero_headline">메인 타이틀</label>
			<input type="text" id="hero_headline" name="hero_headline" value="<?= esc($contents['hero']['headline'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="hero_subtitle">서브 타이틀</label>
			<input type="text" id="hero_subtitle" name="hero_subtitle" value="<?= esc($contents['hero']['subtitle'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="hero_date">날짜</label>
			<input type="text" id="hero_date" name="hero_date" value="<?= esc($contents['hero']['date'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="hero_time">시간</label>
			<input type="text" id="hero_time" name="hero_time" value="<?= esc($contents['hero']['time'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="hero_venue_name">예식장명</label>
			<input type="text" id="hero_venue_name" name="hero_venue_name" value="<?= esc($contents['hero']['venue_name'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="hero_venue_address">예식장 주소</label>
			<input type="text" id="hero_venue_address" name="hero_venue_address" value="<?= esc($contents['hero']['venue_address'] ?? '') ?>">
		</div>
	</div>

	<div class="card">
		<div class="card__title">우리의 이야기</div>
		<div class="field">
			<label for="story_intro">스토리 텍스트</label>
			<textarea id="story_intro" name="story_intro" rows="5"><?= esc($contents['story']['intro'] ?? '') ?></textarea>
		</div>
	</div>

	<div class="card">
		<div class="card__title">신랑 정보</div>
		<div class="field">
			<label for="groom_name">이름</label>
			<input type="text" id="groom_name" name="groom_name" value="<?= esc($contents['couple']['groom_name'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="groom_parents">소개 문구</label>
			<input type="text" id="groom_parents" name="groom_parents" value="<?= esc($contents['couple']['groom_parents'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="groom_contact">연락처</label>
			<input type="text" id="groom_contact" name="groom_contact" value="<?= esc($contents['couple']['groom_contact'] ?? '') ?>">
		</div>
	</div>

	<div class="card">
		<div class="card__title">신부 정보</div>
		<div class="field">
			<label for="bride_name">이름</label>
			<input type="text" id="bride_name" name="bride_name" value="<?= esc($contents['couple']['bride_name'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="bride_parents">소개 문구</label>
			<input type="text" id="bride_parents" name="bride_parents" value="<?= esc($contents['couple']['bride_parents'] ?? '') ?>">
		</div>
		<div class="field">
			<label for="bride_contact">연락처</label>
			<input type="text" id="bride_contact" name="bride_contact" value="<?= esc($contents['couple']['bride_contact'] ?? '') ?>">
		</div>
	</div>

	<button type="submit" class="btn btn--primary">저장하기</button>
</form>
<?= $this->endSection() ?>
