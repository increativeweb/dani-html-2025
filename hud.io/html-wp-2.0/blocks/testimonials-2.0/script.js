if (jQuery('.testimonial-20-splide').length) {

    const testimonialNewSlider = new Splide('.testimonial-20-splide', {
        type: 'loop',
        perPage: 2,     
        perMove: 1,    
        padding: {
            left: '50px', 
            right: '50px',
        },
        arrows: false,
        pagination: false,
        breakpoints: {
            992: {
                perPage: 1,   
                padding: {
                    left: '120px', 
                    right: '120px',
                },  
            },
            767: {
                perPage: 2,   
                padding: {
                    left: '30px', 
                    right: '30px',
                },  
            },
            575: {
                perPage: 1,   
            },
        }
    });

    testimonialNewSlider.mount();
  }
