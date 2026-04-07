if (jQuery('.hero-thumb-slider-20-block').length) {
    var main = new Splide("#hero-img-slider", {
        type: "loop",
        lazyLoad: 'nearby',
        pagination: false,
        arrows: false,
        autoWidth: true,
        rewind: false,
        gap: '15px',
        isNavigation: false,
        // autoplay: true,
        // interval: 8000,
        breakpoints: {
            991: {
                pagination: true,
                "destroy": true
            },
        }
    });

    var thumbnails = new Splide("#thumb-info-slider", {        
        direction: "ttb",
        height: "100%",
        perPage: 3,
        wheel: false,
        arrows: false,
        isNavigation: true,
        pagination: false,
        drag: false, // Disables drag functionality
    });

    main.sync(thumbnails);
    main.mount();
    thumbnails.mount();
}
window.addEventListener("scroll", function () {
  const triggerSection = document.querySelector(".hero-thumb-slider-20-block");
  const targetSection = document.querySelector(".acf-innerblocks-container");

  if (!triggerSection || !targetSection) return;

  const rect = triggerSection.getBoundingClientRect();

  if (rect.top <= 100) {
    targetSection.classList.add("position-relative");
  } else {
    targetSection.classList.remove("position-relative");
  }
});