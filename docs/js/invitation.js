(() => {
	const galleryRoot	= document.querySelector('[data-gallery]');
	const galleryTrack	= galleryRoot?.querySelector('.gallery__track');
	const slides		= galleryTrack ? Array.from(galleryTrack.children) : [];
	const prevButton	= galleryRoot?.querySelector('[data-action="prev"]');
	const nextButton	= galleryRoot?.querySelector('[data-action="next"]');
	const copyButton	= document.querySelector('[data-copy]');
	const rsvpForm		= document.getElementById('rsvpForm');
	const feedbackEl	= document.querySelector('[data-feedback]');
	let activeIndex		= 0;

	const updateGallery = (index) => {
		if (! galleryTrack || slides.length === 0) {
			return;
		}

		const normalized	= (index + slides.length) % slides.length;
		galleryTrack.style.transform	= `translate3d(-${normalized * 100}%, 0, 0)`;
		activeIndex						= normalized;
	};

	prevButton?.addEventListener('click', () => updateGallery(activeIndex - 1));
	nextButton?.addEventListener('click', () => updateGallery(activeIndex + 1));

	if (slides.length > 1) {
		setInterval(() => updateGallery(activeIndex + 1), 5000);
	}

	copyButton?.addEventListener('click', async () => {
		try {
			await navigator.clipboard.writeText(window.location.href);
			copyButton.textContent	= '복사 완료!';
			setTimeout(() => {
				copyButton.textContent	= '링크 복사';
			}, 1800);
		} catch (error) {
			copyButton.textContent	= '다시 시도해줘';
			setTimeout(() => {
				copyButton.textContent	= '링크 복사';
			}, 1800);
		}
	});

	rsvpForm?.addEventListener('submit', (event) => {
		event.preventDefault();
		if (feedbackEl) {
			feedbackEl.textContent	= '데모 버전이라 RSVP는 저장되지 않아.';
		} else {
			alert('데모 버전이라 RSVP는 저장되지 않아.');
		}
	});
})();
