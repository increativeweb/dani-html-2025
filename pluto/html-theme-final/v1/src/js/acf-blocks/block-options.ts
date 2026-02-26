// Typing effect function
const typeText = (element: HTMLElement, text: string, speed: number = 100) => {
    if (element.dataset.typed === 'true') {
        return;
    }

    element.dataset.typed = 'true';
    element.textContent = '';
    element.classList.add('typing');

    let i = 0;
    const timer = setInterval(() => {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
        } else {
            clearInterval(timer);
            element.classList.remove('typing');
            element.classList.add('typed');
        }
    }, speed);
};

const initBlockOptions = () => {
    const blocks = document.querySelectorAll('.block-options');
    console.log('Block options found:', blocks.length);

    if (!blocks.length) {
        return;
    }

    // Observer for the third content rotation
    const blockObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const block = entry.target as HTMLElement;
                const thirdContent = block.querySelector<HTMLElement>('.block-options__third-content');

                if (entry.isIntersecting) {
                    // Add rotation class
                    if (thirdContent) {
                        thirdContent.classList.add('is-visible');
                    }
                }
            });
        },
        {
            threshold: 0.3,
        }
    );

    // Observer specifically for the typing text element
    const typingObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const elementText = entry.target as HTMLElement;

                console.log('Typing element intersection:', entry.isIntersecting, 'Element:', elementText);

                if (entry.isIntersecting) {
                    // Start typing effect
                    if (elementText && elementText.dataset.text) {
                        console.log('Starting typing effect for:', elementText.dataset.text);
                        // Small delay before starting typing
                        setTimeout(() => {
                            typeText(elementText, elementText.dataset.text!, 120);
                        }, 500);
                    } else {
                        console.log('Element text not found or no data-text attribute', elementText);
                    }

                    // Stop observing this element after it starts typing
                    typingObserver.unobserve(elementText);
                }
            });
        },
        {
            threshold: 0.5, // 50% of the element needs to be visible
            rootMargin: '0px 0px -50px 0px' // Trigger when element is 50px from bottom of viewport
        }
    );

    // Observer for monkey element animation
    const monkeyObserver = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                const el = entry.target as HTMLElement;
                if (entry.isIntersecting) {
                    el.classList.add('is-visible');
                } else {
                    el.classList.remove('is-visible');
                }
            });
        },
        {
            threshold: 0.3,
        }
    );

    blocks.forEach((block) => {
        // Observe the entire block for rotation effect
        blockObserver.observe(block);

        // Observe the specific text element for typing effect
        const elementText = block.querySelector<HTMLElement>('.block-options__element-text');
        if (elementText) {
            typingObserver.observe(elementText);
        }

        const monkeyEl = block.querySelector<HTMLElement>('.block-options__monkey-element');
        if (monkeyEl) {
            monkeyObserver.observe(monkeyEl);
        }
    });
};

window.document.addEventListener('DOMContentLoaded', initBlockOptions, false);

// Initialize dynamic block preview (editor).
if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockOptions);
}

export {};


