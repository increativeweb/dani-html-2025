const initBlockNumbers = () => {
    const blocks = document.querySelectorAll('.block-numbers');

    if (!blocks.length) {
        return;
    }

    const animateNumber = (el: HTMLElement, target: number, duration = 1500) => {
        if (el.dataset.animated === 'true') {
            return;
        }

        el.dataset.animated = 'true';

        const start = 0;
        const startTime = performance.now();

        const step = (currentTime: number) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const value = Math.floor(start + (target - start) * progress);

            el.textContent = value.toString();

            if (progress < 1) {
                requestAnimationFrame(step);
            }
        };

        requestAnimationFrame(step);
    };

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const block = entry.target as HTMLElement;
                    const numbers = block.querySelectorAll<HTMLElement>('.js-number-counter');

                    numbers.forEach((numEl) => {
                        const targetAttr = numEl.dataset.target || '0';
                        const target = parseInt(targetAttr, 10);

                        if (!Number.isNaN(target)) {
                            animateNumber(numEl, target);
                        }
                    });

                    obs.unobserve(block);
                }
            });
        },
        {
            threshold: 0.3,
        }
    );

    blocks.forEach((block) => {
        observer.observe(block);
    });
};

window.document.addEventListener('DOMContentLoaded', initBlockNumbers, false);

// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockNumbers);
}

export {};
