(function () {
    const canvas = document.getElementById('particle-animation');
    const ctx = canvas.getContext('2d');
    let W, H, nodes, raf;
    const cols = ['#3B82F6', '#06B6D4', '#8B5CF6', '#10B981'];
    function setup() {
        W = canvas.width = canvas.offsetWidth;
        H = canvas.height = canvas.offsetHeight;
        nodes = Array.from({ length: 42 }, (_, i) => ({ x: Math.random() * W, y: Math.random() * H, vx: (Math.random() - .5) * .28, vy: (Math.random() - .5) * .28, r: Math.random() * 2 + 1.5, col: cols[i % 4] }));
    }
    setup();
    addEventListener('resize', () => {
        clearTimeout(window._r);
        window._r = setTimeout(setup, 250);
    });
    (function draw() { 
        ctx.clearRect(0, 0, W, H); 
        for (let i = 0; i < nodes.length; i++) { 
            const n = nodes[i]; 
            n.x = (n.x + n.vx + W) % W; n.y = (n.y + n.vy + H) % H; 
            for (let j = i + 1; j < nodes.length; j++) { 
                const m = nodes[j]; 
                const dx = n.x - m.x, dy = n.y - m.y, d2 = dx * dx + dy * dy; 
                if (d2 < 14400) { 
                    ctx.globalAlpha = (1 - d2 / 14400) * .11; 
                    ctx.strokeStyle = '#3B82F6'; 
                    ctx.lineWidth = .6; 
                    ctx.beginPath(); 
                    ctx.moveTo(n.x, n.y); 
                    ctx.lineTo(m.x, m.y); 
                    ctx.stroke(); 
                } 
            } 
        } 
        ctx.globalAlpha = 1; 
        nodes.forEach(n => { 
            const dotMultiplier = canvas.classList.contains('single-dot') ? 1 : 5;
            ctx.beginPath(); 
            ctx.arc(n.x, n.y, n.r * dotMultiplier, 0, Math.PI * 2);
            ctx.fillStyle = n.col + '35'; 
            ctx.fill(); 
            ctx.beginPath(); 
            ctx.arc(n.x, n.y, n.r, 0, Math.PI * 2); 
            ctx.fillStyle = n.col; 
            ctx.fill(); 
        }); 
        raf = requestAnimationFrame(draw); 
    })();
})();