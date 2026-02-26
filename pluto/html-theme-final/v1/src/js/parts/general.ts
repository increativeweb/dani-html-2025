import { fadeOut } from './helpers';

// Function to fade out the preloader
export function fadeOutPreloader() {
    // Find the preloader element with class 'site-preloader'
    const preloader = document.querySelector('.site-preloader');

    // Check if the preloader is found as an HTMLElement
    if (preloader instanceof HTMLElement) {
        // Call the fadeOut function to fade out the preloader
        fadeOut(preloader);
    } else {
        // Log an error message if the element with class 'site-preloader' is not found
        console.error("Element with class 'site-preloader' not found");
    }
}