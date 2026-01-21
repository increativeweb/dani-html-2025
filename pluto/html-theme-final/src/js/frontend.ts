/**
 * SASS
 */
import '../scss/frontend.scss';
/**
 * JavaScript
 */
import { setupVisibilityObserver, appHeight } from './parts/helpers';
import { fadeOutPreloader } from './parts/general';

declare global {
    interface Window {
        acf?: any;
        jQuery: any;
    }

    const var_from_php: {
        ajax_url: string;
        theme_path: string;
        site_url: string;
    };

    const wpcf7: {
        init: (elements: NodeListOf<Element>) => void;
    };
}

function ready() {
    appHeight();
    const header = document.querySelector('.site-header') as HTMLElement;

    window.document.addEventListener('scroll', () => {
        const operationType = header && Math.floor(window.scrollY) > 100 ? 'add' : 'remove';
        header.classList[operationType]('scroll-header');
    });

    {
        // Detect Initial scroll of page
        const operationType = header && Math.floor(window.scrollY) > 100 ? 'add' : 'remove';
        header.classList[operationType]('scroll-header');
    }

    setupVisibilityObserver({
        selector: 'section',
        className: 'visible',
        removeOnInvisible: true,
    });
}

function load() {
    document.body.classList.add('loaded');
    fadeOutPreloader();

}

window.document.addEventListener('DOMContentLoaded', ready);

window.document.addEventListener('load', load);
