/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

// We don't need any frameworks :)
// require('./bootstrap');

// Scroll down button on home page hero
const scrollArrow = document.querySelector('.hero-image .bottom-scroll-arrow');
scrollArrow && scrollArrow.addEventListener('click', function () {
    document.querySelector('.tiles-section').scrollIntoView({
        behavior: 'smooth'
    });
});

// Dynamically set 'sizes' attribute on source elements to be expected width of picture
function setPictureSizes() {
    const vw = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
    const vh = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    const vpRatio = vw / vh;
    if (vw > 0 && vh > 0) {
        document.querySelectorAll('picture').forEach(
            function (picture) {
                let img = picture.querySelector('img');
                let sources = picture.querySelectorAll('source');
                let ratio = img.getAttribute('data-width') / img.getAttribute('data-height');
                var sizes = '100vw';
                if (ratio < vpRatio) {
                    sizes = (ratio / vpRatio * 100) + 'vw';
                }
                sources.forEach(function (source) {
                    source.setAttribute('sizes', sizes);
                });
            }
        );
    }
}

if (window.addEventListener) {
    window.addEventListener('load', setPictureSizes)
} else {
    window.attachEvent('onload', setPictureSizes)
}
var resizeFinished;
window.onresize = function () {
    clearTimeout(resizeFinished);
    resizeFinished = setTimeout(setPictureSizes, 250);
};

// Handle arrow keys pressed:
document.addEventListener('keydown', function (event) {
    const y = (window.pageYOffset !== undefined) ?
        window.pageYOffset :
        (document.documentElement || document.body.parentNode || document.body).scrollTop;
    // Only use these if currently scrolled to top of page
    if (y === 0) {
        let targetButton;
        switch (event.key) {
            case "Left":
            case "ArrowLeft":
                targetButton = document.querySelector('.image-viewer .prev-link');
                break;
            case "Right":
            case "ArrowRight":
                targetButton = document.querySelector('.image-viewer .next-link');
                break;
            case "Esc":
            case "Escape":
                targetButton = document.querySelector('.image-viewer .back-link');
                break;
        }
        targetButton && targetButton.click();
    }
});

// Handle mobile swipe (left/right)
function detectswipe(el, func) {
    let pageWidth = window.innerWidth || document.body.clientWidth;
    let treshold = Math.max(15, Math.floor(0.05 * (pageWidth)));
    let swipe_det = {
        sX: 0,
        sY: 0,
        eX: 0,
        eY: 0,
    };
    const limit = Math.tan(45 * 1.5 / 180 * Math.PI);
    
    let lastTouch;
    el.addEventListener('touchstart', function (e) {
        var t = e.touches[0];
        lastTouch = t;
        swipe_det.sX = t.screenX;
        swipe_det.sY = t.screenY;
    }, {passive: true});
    el.addEventListener('touchmove', function (e) {
        lastTouch = e.touches[0];
    }, {passive: true});
    el.addEventListener('touchend', function (e) {
        var t = lastTouch;
        swipe_det.eX = t.screenX;
        swipe_det.eY = t.screenY;

        let x = swipe_det.eX - swipe_det.sX;
        let y = swipe_det.eY - swipe_det.sY;
        let xy = Math.abs(x / y);
        let yx = Math.abs(y / x);

        var direc = "";
        //horizontal detection
        if (Math.abs(x) > treshold || Math.abs(y) > treshold) {
            if (yx <= limit && Math.abs(x) > Math.abs(y)) {
                if (x < 0) {
                    direc = 'l'; // left
                } else {
                    direc = 'r'; // right
                }
            }
        } else {
            direc = 't'; // tap
        }

        if (direc != "") {
            if (typeof func == 'function') func(el, direc);
        }
        direc = "";
        swipe_det.sX = 0;
        swipe_det.sY = 0;
        swipe_det.eX = 0;
        swipe_det.eY = 0;
    }, {passive: true});
}

function swipeDetected(el, direction) {
    let targetButton;
    switch (direction) {
        case "r": // left-to-right swipe
            targetButton = el.querySelector('.prev-link');
            break;
        case "l": // right-to-left swipe
            targetButton = el.querySelector('.next-link');
            break;
        case "t": // tap (no/minimal movement)
            el.classList.toggle('hide-controls');
            break
    }
    targetButton && targetButton.click();
}

const imageViewer = document.querySelector('.image-viewer');
imageViewer && detectswipe(imageViewer, swipeDetected);

imageViewer && imageViewer.addEventListener('mousemove', function() {
    imageViewer.classList.remove('hide-controls');
});
