document.addEventListener("DOMContentLoaded", function () {

  const elements = document.querySelectorAll(".bg-inner");

  const states = new Map();

  elements.forEach(el => {
    states.set(el, { current: 0, target: 0 });
  });

  function update() {

    elements.forEach(el => {
      const rect = el.parentElement.getBoundingClientRect();
      const state = states.get(el);

      const speed = 0.2;

      // 🎯 PERFECT CENTER-BASED OFFSET
      const center = window.innerHeight / 2;
      const offset = rect.top + rect.height / 2 - center;

      state.target = offset * speed;

      // 🎯 SMOOTH LERP (KEY TO PERFECT FEEL)
      state.current += (state.target - state.current) * 0.08;

      el.style.transform = `translateY(${state.current}px)`;
    });

    requestAnimationFrame(update);
  }

  update();
});