const initBlockLogos = () => {
    const blocks = document.querySelectorAll<HTMLElement>('.block-logos');

    if (!blocks.length) {
        return;
    }

    const easeOutQuad = (t: number) => 1 - (1 - t) * (1 - t);
    const easeInQuad = (t: number) => t * t;
    const lastProgressMap = new WeakMap<HTMLElement, number>();

    const updateParallax = () => {
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight;

        blocks.forEach((block) => {
            const rect = block.getBoundingClientRect();
            const wrap = block.querySelector<HTMLElement>('.block-logos__wrap');

            if (!wrap) {
                return;
            }

            const wrapHeight = wrap.clientHeight || 0;
            const blockHeight = block.clientHeight || rect.height;

            // Travel distance ensures movement even when block is short; amplify for deeper movement
            const travelAmplifier = 1.10;
            const travelSpace =
                Math.max(blockHeight - wrapHeight, wrapHeight * 0.6) * travelAmplifier;
            const wrapStartOffset = -wrapHeight * 0.6; // start above, move down

            // Reset when block is fully outside of the viewport
            if (rect.bottom < 0 || rect.top > viewportHeight) {
                block.style.setProperty('--parallax-progress', '0');
                wrap.style.transform = `translateY(${wrapStartOffset}px)`;
                return;
            }

            // Distance of block center from viewport center (-1 .. 1) for logo parallax
            const blockCenter = rect.top + rect.height / 2;
            const viewportCenter = viewportHeight / 2;
            const distance = blockCenter - viewportCenter;
            const maxDistance = viewportHeight / 2;

            let progress = distance / maxDistance;
            progress = Math.max(-1, Math.min(1, progress));
            block.style.setProperty('--parallax-progress', progress.toString());

            // Scroll progress: start after block is inside viewport by 50px,
            // finish when the block's center reaches viewport center
            const triggerOffset = 50;
            const triggerLine = viewportHeight - triggerOffset; // block top crosses this to start
            const endTop = viewportCenter - blockHeight / 2; // when block center aligns with viewport center
            const span = triggerLine - endTop;

            let scrollProgress = 0;
            if (span > 0) {
                scrollProgress = Math.max(0, Math.min(1, (triggerLine - rect.top) / span));
            }

            const prevProgress = lastProgressMap.get(block) ?? 0;
            const direction = scrollProgress >= prevProgress ? 'forward' : 'backward';
            const easedProgress =
                direction === 'forward' ? easeOutQuad(scrollProgress) : easeInQuad(scrollProgress);

            lastProgressMap.set(block, scrollProgress);

            const translateY = wrapStartOffset + travelSpace * easedProgress;
            wrap.style.transform = `translateY(${translateY}px)`;
        });
    };

    updateParallax();

    window.addEventListener('scroll', updateParallax, { passive: true });
    window.addEventListener('resize', updateParallax);
};

window.document.addEventListener('DOMContentLoaded', initBlockLogos, false);

// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockLogos);
}

export {};


