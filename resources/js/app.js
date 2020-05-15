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
    swipe_det = new Object();
    swipe_det.sX = 0;
    swipe_det.sY = 0;
    swipe_det.eX = 0;
    swipe_det.eY = 0;
    var min_x = 30; //min x swipe for horizontal swipe
    var max_x = 30; //max x difference for vertical swipe
    var min_y = 30; //min x swipe for horizontal swipe
    var max_y = 30; //max x difference for vertical swipe
    var direc = "";
    el.addEventListener('touchstart', function (e) {
        var t = e.touches[0];
        swipe_det.sX = t.screenX;
        swipe_det.sY = t.screenY;
    }, false);
    el.addEventListener('touchmove', function (e) {
        //e.preventDefault();
        var t = e.touches[0];
        swipe_det.eX = t.screenX;
        swipe_det.eY = t.screenY;
    });//, false);
    el.addEventListener('touchend', function (e) {
        //horizontal detection
        if ((((swipe_det.eX - min_x > swipe_det.sX) || (swipe_det.eX + min_x < swipe_det.sX)) && ((swipe_det.eY < swipe_det.sY + max_y) && (swipe_det.sY > swipe_det.eY - max_y) && (swipe_det.eX > 0)))) {
            if (swipe_det.eX > swipe_det.sX) direc = "r";
            else direc = "l";
        }

        if (direc != "") {
            if (typeof func == 'function') func(el, direc);
        }
        direc = "";
        swipe_det.sX = 0;
        swipe_det.sY = 0;
        swipe_det.eX = 0;
        swipe_det.eY = 0;
    }, false);
}

function swipeDetected(el, direction) {
    let targetButton;
    switch (direction) {
        case "r": // left-to-right swipe
            targetButton = document.querySelector('.image-viewer .prev-link');
            break;
        case "l": // right-to-left swipe
            targetButton = document.querySelector('.image-viewer .next-link');
            break;
    }
    targetButton && targetButton.click();
}

const imageViewer = document.querySelector('.image-viewer');
imageViewer && detectswipe(imageViewer, swipeDetected);
