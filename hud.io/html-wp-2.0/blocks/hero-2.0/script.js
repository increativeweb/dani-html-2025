document.addEventListener("DOMContentLoaded", function () {

  if (jQuery('.hero-thumb-slider-20-block').length) {

    // MAIN SLIDER
    var main = new Splide("#hero-img-slider", {
      type: "loop",
      lazyLoad: "nearby",
      pagination: false,
      arrows: false,
      autoWidth: true,
      rewind: false,
      gap: "15px",
    });

    // THUMB SLIDER
    var thumbnails = new Splide("#thumb-info-slider", {
      direction: "ttb",
      height: "100%",
      perPage: 4,
      arrows: false,
      pagination: false,
      isNavigation: true,
      drag: false,

      breakpoints: {
        991: {
          direction: "ltr",
          autoWidth: true, // 👈 required
          height: "auto",
        },
      },
    });

    main.sync(thumbnails);
    main.mount();
    thumbnails.mount();

    // ✅ Dynamic Width Function (SMOOTH)
    function updateThumbWidths() {

      if (window.innerWidth > 991) return;

      const slides = thumbnails.Components.Elements.slides;
      console.log(slides);
      
      const totalSlides = slides.length;

      const smallWidth = window.innerWidth < 767 ? 40 : 70;
      const container = document.querySelector("#thumb-info-slider");
      const containerWidth = container.offsetWidth;

      const totalSmallWidth = (totalSlides - 1) * smallWidth;
      const activeWidth = containerWidth - totalSmallWidth;

      slides.forEach((slide) => {
        const title = slide.querySelector('.title');
        const info = slide.querySelector('.sort-info');

        if (slide.classList.contains("is-active")) {
          slide.style.flexBasis = activeWidth + "px";
          setTimeout(() => {
            if (title) title.style.display = "block";
            if (info) info.style.display = "block";
          }, 300);
        } else {
          slide.style.flexBasis = smallWidth + "px";
          setTimeout(() => {
            if (title) title.style.display = "none";
            if (info) info.style.display = "none";
          }, 10);
        }
      });
    }

    // ✅ Trigger events (smooth timing)
    thumbnails.on("mounted move active updated", function () {
      requestAnimationFrame(updateThumbWidths);
    });

    // ✅ Resize
    window.addEventListener("resize", function () {
      requestAnimationFrame(updateThumbWidths);
    });

    // ✅ Initial run
    if (window.innerWidth < 992) {
      setTimeout(updateThumbWidths, 100);
    }

  }

});
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