document.addEventListener("DOMContentLoaded", () => {
    const hero = document.querySelector(".about-hero-section");
    if (!hero) return;

    const moveUpRem = 10;
    const maxScrollPercent = 0.8;
    let heroHeight = hero.offsetHeight;

    function getConfig() {
        const w = window.innerWidth;

        if (w < 420) return { mode: "calc", offset: 4.8 };
        if (w < 575) return { mode: "calc", offset: 9.8 };
        if (w < 992) return { mode: "plain", offset: 0 };
        return { mode: "calc", offset: 1.8 };
    }

    function setDefaultPosition() {
        const { mode, offset } = getConfig();

        if (mode === "plain") {
            hero.style.backgroundPosition =
                "center 0rem, center bottom";
        } else {
            hero.style.backgroundPosition =
                `center calc(100% + ${offset}rem), center bottom`;
        }
    }

    function updateBackground() {
        const rect = hero.getBoundingClientRect();
        const { mode, offset } = getConfig();

        // Force default at scroll top
        if (window.scrollY === 0) {
            setDefaultPosition();
            return;
        }

        if (rect.bottom > 0 && rect.top < window.innerHeight) {
            let progress = -rect.top / heroHeight;
            progress = Math.min(Math.max(progress, 0), maxScrollPercent);

            const normalized = progress / maxScrollPercent;
            const movement = normalized * moveUpRem;

            if (mode === "plain") {
                hero.style.backgroundPosition =
                    `center ${-movement}rem, center bottom`;
            } else {
                hero.style.backgroundPosition =
                    `center calc(100% + ${offset - movement}rem), center bottom`;
            }
        }
    }

    // Initial state
    setDefaultPosition();

    window.addEventListener("scroll", updateBackground);
    window.addEventListener("resize", () => {
        heroHeight = hero.offsetHeight;
        setDefaultPosition();
        updateBackground();
    });
});