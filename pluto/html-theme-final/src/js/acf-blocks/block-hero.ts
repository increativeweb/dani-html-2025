const initBlockHero = () => {
    const blocks = document.querySelectorAll('.block-hero');

    if (!blocks.length) {
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const block = entry.target as HTMLElement;
                const smallDecoration = block.querySelector<HTMLElement>('.block-hero__decoration-small');
                const bigDecoration = block.querySelector<HTMLElement>('.block-hero__decoration-big');                

                if (entry.isIntersecting) {
                    if (smallDecoration) {
                        smallDecoration.classList.add('is-visible');
                    }

                    if (bigDecoration) {
                        bigDecoration.classList.add('is-visible');
                    }
                    
                } else {
                    if (smallDecoration) {
                        smallDecoration.classList.remove('is-visible');
                    }

                    if (bigDecoration) {
                        bigDecoration.classList.remove('is-visible');
                    }                    
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

window.document.addEventListener('DOMContentLoaded', initBlockHero, false);

// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockHero);
}

export {};


