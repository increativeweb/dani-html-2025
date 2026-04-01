class EventBarCountdown {
	constructor(block) {
		this.el = block;
		this.bar = this.el.querySelector('.event-bar');
		this.clock = this.el.querySelector('#countdown');
		this.closeBtn = this.el.querySelector('.event-bar__close');
		this.timeinterval = null;

		if (!this.bar || !this.closeBtn) return;

		this.initCountdown();
		this.setEventBarHeight();

		window.addEventListener('resize', this.throttle(() => this.setEventBarHeight(), 100));
		this.closeBtn.addEventListener('click', () => this.closeBar());
	}

	initCountdown() {
		if (!this.clock) {
			this.showBar();
			return;
		}

		const dateAttr = this.clock.getAttribute('data-date');
		if (!dateAttr) return;

		this.endTime = new Date(dateAttr);
		this.days = this.clock.querySelector('.days');
		this.hours = this.clock.querySelector('.hours');
		this.minutes = this.clock.querySelector('.minutes');
		this.seconds = this.clock.querySelector('.seconds');

		this.updateClock();
		this.showBar();
		this.timeinterval = setInterval(() => this.updateClock(), 1000);
	}

	updateClock() {
		const t = this.getTimeRemaining(this.endTime);

		if (t.total <= 0) {
			this.closeBar();
			return;
		}

		this.days.textContent = t.days;
		this.hours.textContent = ('0' + t.hours).slice(-2);
		this.minutes.textContent = ('0' + t.minutes).slice(-2);
		this.seconds.textContent = ('0' + t.seconds).slice(-2);
	}

	getTimeRemaining(endtime) {
		const total = Date.parse(endtime) - Date.parse(new Date());
		const seconds = Math.floor((total / 1000) % 60);
		const minutes = Math.floor((total / 1000 / 60) % 60);
		const hours = Math.floor((total / (1000 * 60 * 60)) % 24);
		const days = Math.floor(total / (1000 * 60 * 60 * 24));

		return { total, days, hours, minutes, seconds };
	}

	showBar() {
		this.bar.classList.remove('event-bar--hide');
		this.setEventBarHeight();
	}

	closeBar() {
		clearInterval(this.timeinterval);
		this.bar.classList.add('event-bar--hide');
		document.documentElement.style.setProperty('--eventBarHeight', '0px');
	}

	setEventBarHeight() {
		if (!this.bar.classList.contains('event-bar--hide')) {
			const height = Math.floor(this.bar.getBoundingClientRect().height);
			document.documentElement.style.setProperty('--eventBarHeight', `${height}px`);
		}
	}

	throttle(fn, wait) {
		let time = Date.now();
		return () => {
			if ((time + wait - Date.now()) < 0) {
				fn();
				time = Date.now();
			}
		};
	}
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
	const eventBar = document.querySelector('.event-bar-footer');
	if (eventBar) {
		new EventBarCountdown(eventBar);
	}
});