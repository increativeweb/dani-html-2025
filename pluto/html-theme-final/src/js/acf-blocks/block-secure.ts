const initBlockSecure = () => {
    const blocks = document.querySelectorAll('.block-secure');

    if (!blocks.length) {
        return;
    }

    const handleParallax = () => {
        const viewportHeight = window.innerHeight;
        const isMobile = viewportHeight && window.innerWidth < 768;

        blocks.forEach((block) => {
            const rect = block.getBoundingClientRect();
            const offset = rect.top + rect.height / 2 - viewportHeight / 2;

            let mainShift: number;
            let contentShift: number;
            let mainTopShift: number;

            // Compute a softer parallax on mobile, full parallax on desktop
            if (isMobile) {
                mainShift = offset * -0.04;
                contentShift = offset * -0.06;
                const progress = Math.min(Math.max((viewportHeight - rect.top) / viewportHeight, 0), 1);
                const maxMobileTop = -40; // limit upward shift on mobile
                mainTopShift = maxMobileTop * progress;
            } else {
                mainShift = offset * -0.12;
                contentShift = offset * -0.18;
                const progress = Math.min(Math.max((viewportHeight - rect.top) / viewportHeight, 0), 1);
                mainTopShift = -116 * progress;
            }

            block.setAttribute(
                'style',
                `--parallax-main:${mainShift}px; --parallax-content:${contentShift}px; --parallax-main-top:${mainTopShift}px;`
            );
        });
    };

    // initial run
    handleParallax();

    // use rAF to throttle scroll
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            window.requestAnimationFrame(() => {
                handleParallax();
                ticking = false;
            });
            ticking = true;
        }
    });

    window.addEventListener('resize', handleParallax);

    // Form logic per block
    blocks.forEach((block) => {
        const form = block.querySelector('#wow_form');

        if(!form) return;

        const answers = [
            'Absolutely',
            'Certainly',
            'Of course',
            'Definitely',
            'Sure',
            'You bet',
            'Affirmative',
            'Indeed',
            'By all means',
            'Without a doubt',
            'Naturally',
            'For sure',
            'Right',
            'Aye',
            'Totally',
            'You know it',
            'Heck yes',
            'Is the sky blue?',
            'Does a bear live in the woods?',
            'Why not?',
            'Can’t say no to that',
            'If you insist',
            'I thought you’d never ask',
            'Do fish swim?',
            'No doubt',
        ];
        let answered = false;

        const input = form.querySelector('input');
        const button = form.querySelector('button');

        button?.addEventListener('click', (e) => {
            e.preventDefault();

            if (input?.value.trim() === '') return;

            if (input?.value !== '' && !answered) {
                button.classList.add('active');
                button.innerHTML =
                    '<svg width="22" height="18" viewBox="0 0 22 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.41418 8.0941L7.64856 14.3285L20.5628 1.41422" stroke="#423953" stroke-width="4"/></svg>';

                const newAnswer = document.createElement('span');
                const randomIndex = Math.floor(Math.random() * answers.length);
                newAnswer.textContent = answers[randomIndex];
                form.appendChild(newAnswer);

                answered = true;
            }
        });

        form.addEventListener('input', (ev) => {
            const target = ev.target as HTMLInputElement;

            if(!button) return;

            if (target.value === '' || target.value.trim() === '') {
                button.classList.remove('active');
                button.innerHTML = '?';
                
                const span = form.querySelector('span') as HTMLSpanElement;
                if(span) form.removeChild(span);

                answered = false;
            } else {
                button.innerHTML = 
                    '<svg width="14" height="21" viewBox="0 0 14 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.38672 18.7614L10.3867 10.1012L1.38672 1.44092" stroke="#FFCBCB" stroke-width="4"/></svg>';
            }

            setTimeout(() => {
                target.value = '';

                const span = form.querySelector('span') as HTMLSpanElement;
                if(span) form.removeChild(span);

                button.classList.remove('active');
                button.innerHTML = '?';

                answered = false;
            }, 5000);
        });

        input?.addEventListener("blur", function(event) {
            if(!input) return;

            setTimeout(() => {
                input.value = '';
                const span = form.querySelector('span') as HTMLSpanElement;

                if(span) form.removeChild(span);

                if(button) button.classList.remove('active');
                if(button) button.innerHTML = '?';

                answered = false;
            }, 3000);
        });
    });
};

window.document.addEventListener('DOMContentLoaded', initBlockSecure, false);

if (window.acf) {
    window.acf?.addAction('render_block_preview', initBlockSecure);
}

export {};
