(() => {
	const config			= window.APP_CONFIG ?? {};
	const galleryRoot		= document.querySelector('[data-gallery]');
	const galleryTrack		= galleryRoot?.querySelector('.gallery__track');
	let gallerySlides		= galleryRoot?.querySelectorAll('.gallery__slide') ?? [];
	const prevButton		= galleryRoot?.querySelector('[data-action="prev"]');
	const nextButton		= galleryRoot?.querySelector('[data-action="next"]');
	const rsvpContainer		= document.querySelector('[data-rsvp]');
	const rsvpForm			= document.getElementById('rsvpForm');
	const submitButton		= rsvpContainer?.querySelector('[data-submit]');
	const feedbackTarget	= rsvpContainer?.querySelector('[data-feedback]');
	const copyButton		= document.querySelector('[data-copy]');
	let activeIndex			= 0;

	const setGalleryIndex = (index) => {
		if (! galleryTrack || gallerySlides.length === 0) {
			return;
		}

		const normalizedIndex	= (index + gallerySlides.length) % gallerySlides.length;
		const offset			= normalizedIndex * 100;

		galleryTrack.style.transform	= `translate3d(-${offset}%, 0, 0)`;
		activeIndex						= normalizedIndex;
	};

	const attachGalleryHandlers = () => {
		if (! galleryRoot) {
			return;
		}

		prevButton?.addEventListener('click', () => {
			setGalleryIndex(activeIndex - 1);
		});

		nextButton?.addEventListener('click', () => {
			setGalleryIndex(activeIndex + 1);
		});

		let autoSlideTimer	= window.setInterval(() => setGalleryIndex(activeIndex + 1), 4500);

		galleryRoot.addEventListener('mouseenter', () => {
			window.clearInterval(autoSlideTimer);
		});

		galleryRoot.addEventListener('mouseleave', () => {
			autoSlideTimer	= window.setInterval(() => setGalleryIndex(activeIndex + 1), 4500);
		});

		if (config.galleryEndpoint && gallerySlides.length === 0) {
			fetch(config.galleryEndpoint, { headers: { Accept: 'application/json' } })
				.then((response) => response.ok ? response.json() : Promise.reject(new Error('failed to load gallery')))
				.then((payload) => Array.isArray(payload.items) ? payload.items : [])
				.then((items) => {
					if (! Array.isArray(items) || items.length === 0 || ! galleryTrack) {
						return;
					}

					galleryTrack.innerHTML	= '';

					items.forEach((item, index) => {
						const slide		= document.createElement('figure');
						const image		= document.createElement('img');

						slide.classList.add('gallery__slide');
						slide.dataset.slide	= `${index}`;

						image.src	= item.src ?? '';
						image.alt	= item.alt ?? '';

						slide.appendChild(image);
						galleryTrack.appendChild(slide);
					});

					galleryTrack.dataset.loaded	= 'true';
					gallerySlides				= galleryTrack.querySelectorAll('.gallery__slide');
					setGalleryIndex(0);
				})
				.catch(() => {
					// 조용히 실패 처리
				});
		}
	};

	const clearErrors = () => {
		if (! rsvpContainer) {
			return;
		}

		rsvpContainer.querySelectorAll('[data-error]').forEach((element) => {
			element.textContent	= '';
		});
		if (feedbackTarget) {
			feedbackTarget.textContent	= '';
		}
	};

	const showErrors = (errors) => {
		if (! rsvpContainer) {
			return;
		}

		Object.entries(errors).forEach(([field, message]) => {
			const target	= rsvpContainer.querySelector(`[data-error="${field}"]`);
			if (target) {
				target.textContent	= String(message);
			}
		});
	};

	const handleRsvpSubmit = () => {
		if (! rsvpForm || ! submitButton) {
			return;
		}

		rsvpForm.addEventListener('submit', (event) => {
			event.preventDefault();
			if (! config.rsvpEndpoint) {
				return;
			}

			clearErrors();

			const formData	= new FormData(rsvpForm);

			submitButton.disabled	= true;
			submitButton.textContent	= '보내는 중...';

			fetch(config.rsvpEndpoint, {
				method: 'POST',
				headers: {
					Accept: 'application/json',
				},
				body: formData,
			})
				.then(async (response) => {
					const data = await response.json().catch(() => ({}));
					if (! response.ok) {
						return Promise.reject(data);
					}
					return data;
				})
				.then((payload) => {
					if (feedbackTarget) {
						feedbackTarget.textContent	= payload.message ?? '답변 고마워!';
					}
					rsvpForm.reset();
				})
				.catch((error) => {
					const errors = error?.messages ?? error?.errors ?? error ?? {};
					if (errors && typeof errors === 'object') {
						showErrors(errors);
					}
					if (feedbackTarget && ! feedbackTarget.textContent) {
						feedbackTarget.textContent	= '죄송해! 잠시 후 다시 시도해줘.';
					}
				})
				.finally(() => {
					submitButton.disabled	= false;
					submitButton.textContent	= '참석 여부 보내기';
				});
		});
	};

	const attachCopyHandler = () => {
		if (! copyButton) {
			return;
		}

		copyButton.addEventListener('click', async () => {
			try {
				const targetUrl = config.shareUrl || window.location.href;
				await navigator.clipboard.writeText(targetUrl);
				copyButton.textContent	= '복사 완료!';
				window.setTimeout(() => {
					copyButton.textContent	= '링크 복사';
				}, 1800);
			} catch (error) {
				copyButton.textContent	= '다시 시도해줘';
				window.setTimeout(() => {
					copyButton.textContent	= '링크 복사';
				}, 1800);
			}
		});
	};

	attachGalleryHandlers();
	handleRsvpSubmit();
	attachCopyHandler();
})();
