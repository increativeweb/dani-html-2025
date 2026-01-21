import smoothscroll from 'smoothscroll-polyfill';

// kick off the polyfill!
smoothscroll.polyfill();

/**
 * Fades in a given element with animation.
 *
 * @param {string | HTMLElement} selectorOrElement - Selector string or HTMLElement to fade in.
 * @param {string} [display='block'] - (optional) CSS display value to set after fading in. Default is 'block'.
 */
export function fadeIn(selectorOrElement: string | HTMLElement, display = 'block'): void {
    const element =
        typeof selectorOrElement === 'string' ? document.querySelector(selectorOrElement) : selectorOrElement;

    if (!(element instanceof HTMLElement)) {
        console.error("Element doesn't exist or is not an HTMLElement for fadeIn");
        return;
    }

    element.style.display = display;
    let opacity = 0;

    function increaseOpacity() {
        if (!(element instanceof HTMLElement)) return;
        if (opacity < 1) {
            opacity = Math.min(opacity + 0.1, 1);
            element.style.opacity = opacity.toString();
            requestAnimationFrame(increaseOpacity);
        }
    }

    increaseOpacity();
}

/**
 * Fades out a given element with animation.
 *
 * @param {string | HTMLElement} selectorOrElement - Selector string or HTMLElement to fade out.
 */
export function fadeOut(selectorOrElement: string | HTMLElement): void {
    const element =
        typeof selectorOrElement === 'string' ? document.querySelector(selectorOrElement) : selectorOrElement;

    if (!(element instanceof HTMLElement)) {
        console.error("Element doesn't exist or is not an HTMLElement for fadeOut");
        return;
    }

    let opacity = 1;

    function decreaseOpacity() {
        if (!(element instanceof HTMLElement)) return;
        if (opacity > 0) {
            opacity = Math.max(opacity - 0.1, 0);
            element.style.opacity = opacity.toString();
            if (opacity <= 0) {
                element.style.display = 'none';
            }
            requestAnimationFrame(decreaseOpacity);
        }
    }

    decreaseOpacity();
}

/**
 * Sets equal height to selected elements calculated as the bigger height.
 *
 * @param {string | HTMLElement[]} elementsSelector - Selector string or array of HTMLElements.
 * @param {'min' | 'max'} [minOrMax='max'] - Define whether to calculate minHeight or maxHeight.
 * @return {string | HTMLElement[]} The original elementsSelector parameter.
 */
export function equalHeights(
    elementsSelector: string | HTMLElement[],
    minOrMax: 'min' | 'max' = 'max'
): string | HTMLElement[] {
    if (!elementsSelector) {
        throw new Error('equalHeights function - Required parameters missing');
    }

    const elements: HTMLElement[] =
        typeof elementsSelector === 'string'
            ? Array.from(document.querySelectorAll(elementsSelector) as NodeListOf<HTMLElement>)
            : elementsSelector;

    const heights = elements.map((item) => {
        const element = item;
        element.style.height = 'auto';
        return element.offsetHeight;
    });

    const commonHeight = minOrMax === 'max' ? Math.max(...heights) : Math.min(...heights);
    elements.forEach((item) => {
        // eslint-disable-next-line no-param-reassign
        item.style.height = `${commonHeight}px`;
    });

    return elementsSelector;
}

/**
 * Sets up an IntersectionObserver for elements matching a given selector and adds or removes a specified class based on their visibility.
 *
 * @param {VisibilityObserverOptions} options - Configuration options for the observer.
 */
interface VisibilityObserverOptions {
    selector: string; // CSS selector for elements to observe
    callback?: (element: HTMLElement) => void; // Callback function when the element becomes visible
    className?: string; // Class to add/remove based on visibility
    threshold?: number; // Visibility threshold (0 to 1)
    removeOnInvisible?: boolean; // Remove class when the element becomes invisible
    rootMargin?: string; // Margin around the root (viewport) to expand/shrink the intersection area
}

export function setupVisibilityObserver(options: VisibilityObserverOptions): void {
    const {
        selector,
        callback,
        className = 'visible',
        threshold = 0.3,
        removeOnInvisible = false,
        rootMargin = '0px', // Default root margin
    } = options;

    // Get elements to observe
    const items = document.querySelectorAll(selector) as NodeListOf<HTMLElement>;

    if (items.length) {
        // Create an IntersectionObserver with provided options
        const observer = new IntersectionObserver(
            (entries, obs) => {
                entries.forEach((entry) => {
                    // If the element is intersecting (visible as per threshold)
                    if (entry.isIntersecting) {
                        entry.target.classList.add(className);

                        // Execute callback if provided
                        if (callback) {
                            callback(entry.target as HTMLElement);
                        }

                        // Stop observing if removeOnInvisible is false
                        if (!removeOnInvisible) {
                            obs.unobserve(entry.target);
                        }
                    } else if (removeOnInvisible) {
                        // Remove class if the element is no longer visible
                        entry.target.classList.remove(className);
                    }
                });
            },
            { threshold, rootMargin } // Observer options
        );

        // Observe each element
        items.forEach((item) => observer.observe(item));
    }
}

/**
 * Sets the app height as a CSS variable for responsive design.
 */
export const appHeight = (): void => {
    const doc = document.documentElement;
    const header = document.querySelector('.js-site-header') as HTMLElement | null;

    // eslint-disable-next-line @wordpress/no-global-event-listener
    window.addEventListener('resize', () => {
        doc.style.setProperty('--app-height', `${window.innerHeight}px`);
        if (header) {
            doc.style.setProperty('--header-height', `${header.offsetHeight}px`);
        }
    });

    // Call once to set initial values
    doc.style.setProperty('--app-height', `${window.innerHeight}px`);
    if (header) {
        doc.style.setProperty('--header-height', `${header.offsetHeight}px`);
    }
};

/**
 * Initializes the Userway widget.
 */
let userwayInitialized = false;

/**
 * Initializes the Userway widget and applies custom styles.
 *
 * @param {boolean} hideUserway - Boolean to control whether to hide Userway button wrappers.
 */
export function initializeUserway(hideUserway = false): void {
    // Check if Userway has already been initialized
    if (userwayInitialized) return;

    // Create a script element for Userway widget
    const script = document.createElement('script');
    script.setAttribute('data-language', 'en');
    script.setAttribute('data-account', 'HWNAP51brz');
    script.setAttribute('data-color', '#735eff');
    script.defer = true;
    script.src = 'https://cdn.userway.org/widget.js';

    // Append the script to the document head or body
    (document.body || document.head).appendChild(script);

    // Event listener to handle actions after the script has loaded
    script.onload = () => {
        if (hideUserway) {
            // Dynamically inject CSS to hide userway buttons wrapper
            const style = document.createElement('style');
            style.innerHTML = `.userway_buttons_wrapper { display: none !important; }`;
            document.head.appendChild(style);
        }
    };

    // Set Userway initialization flag to true
    userwayInitialized = true;
}

/**
 * Smoothly scrolls to the top edge of the element referenced in the href of a clicked anchor link,
 * considering fixed elements like headers.
 *
 * @param {string} selector - The CSS selector of the anchor links.
 * @param {number} [offset=0] - Additional offset to consider (e.g., height of a fixed header).
 */
export function smoothScrollToElement(selector: string, offset = 0): void {
    // Find all elements matching the selector
    const links = document.querySelectorAll<HTMLAnchorElement>(selector);

    // Add click event listener to each link
    links.forEach((link) => {
        // Store href attribute and then remove it to prevent it from showing on hover
        const href = link.getAttribute('href');
        link.removeAttribute('href');

        link.addEventListener('click', (event) => {
            // Prevent default anchor link behavior
            event.preventDefault();

            // Check if the href value is a valid ID selector
            if (href && href.startsWith('#')) {
                const targetElement = document.querySelector<HTMLElement>(href);

                // If the target element exists, scroll to it smoothly
                if (targetElement) {
                    // targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    const scrollPosition = document.documentElement.scrollTop || document.body.scrollTop;
                    const targetPosition = targetElement.getBoundingClientRect().top + scrollPosition - offset;
                    window.scrollTo({ top: targetPosition, behavior: 'smooth' });
                }
            }
        });
    });
}

/**
 * Wraps each word of the hero block titles in a span for animation effects.
 * This function will select all the titles given a specific CSS class and apply a gradual transition delay to each word.
 *
 * @param {string} selector - The CSS class selector for the hero block titles.
 */
export const wrapHeaderWords = (selector: string): void => {
    // Querying for elements based on the passed selector
    const titles = document.querySelectorAll<HTMLElement>(selector);

    // Early exit if no elements are found
    if (!titles.length) {
        return;
    }

    let delay = 0; // Initializing transition delay

    // Function to wrap text in a span with an increasing transition delay
    const wrapText = (text: string): string => {
        const span = `<span class="word-wrapper"><span style="transition-delay: ${delay}s;">${text}</span></span>`;
        delay += 0.05; // Increment delay for each word
        return span;
    };

    // Recursive function to process child nodes
    const processNode = (node: Node): void => {
        const childNodes = Array.from(node.childNodes);

        childNodes.forEach((child) => {
            if (child.nodeType === Node.TEXT_NODE) {
                // Splitting and wrapping text nodes
                const words = (child.textContent ?? '')
                    .split(/(\s+)/)
                    .map((part) => (/\S+/.test(part) ? wrapText(part) : part));
                const fragment = document.createRange().createContextualFragment(words.join(''));
                child.replaceWith(fragment);
            } else if (child.nodeType === Node.ELEMENT_NODE && child instanceof HTMLElement) {
                // Process elements that contain text
                if (child.textContent) {
                    processNode(child);
                }
            }
        });
    };

    titles.forEach((title) => {
        delay = 0; // Resetting delay for each title
        processNode(title);
    });
};

