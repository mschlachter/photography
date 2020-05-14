/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

$(document).on('click', '.hero-image .bottom-scroll-arrow', function () {
    $([document.documentElement, document.body]).animate({
        scrollTop: $('.tiles-section').offset().top
    }, 1500);
});

function setPictureSizes() {
    const vw = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    const vh = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    const vpRatio = vw / vh;
    if (vw > 0 && vh > 0) {
        $('picture').each(function () {
            let $img = $(this).find('img');
            let $sources = $(this).find('source');
            let ratio = $img.data('width') / $img.data('height');
            if (ratio >= vpRatio) {
                $sources.attr('sizes', '100vw');
            } else {
                $sources.attr('sizes', (ratio / vpRatio * 100) + 'vw');
            }
        });
    }
}

var resizeFinished;
$(function () {
    resizeFinished = setTimeout(setPictureSizes, 100);
});
window.onresize = function () {
    clearTimeout(resizeFinished);
    resizeFinished = setTimeout(setPictureSizes, 250);
};

// Handle arrow keys pressed:
document.addEventListener('keydown', function (event) {
    const key = event.key;
    const y = (window.pageYOffset !== undefined) ?
        window.pageYOffset :
        (document.documentElement || document.body.parentNode || document.body).scrollTop;
    // Only use these if not scrolled down at all
    if (y === 0) {
        switch (event.key) {
            case "Left":
            case "ArrowLeft":
                $('.image-viewer .prev-link')[0].click();
                break;
            case "Right":
            case "ArrowRight":
                $('.image-viewer .next-link')[0].click();
                break;
            case "Esc":
            case "Escape":
                $('.image-viewer .back-link')[0].click();
                break;
        }
    }
});
