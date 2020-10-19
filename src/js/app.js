// import 'alpinejs';
// import Mark from 'mark.js';
import SimpleBar from 'simplebar';
import GLightbox from 'glightbox';
import { tns } from 'tiny-slider/src/tiny-slider';
// import { qs, qsa, $on, $delegate } from './utils';
import { qs, qsa, $on } from './utils';

$on(document, 'DOMContentLoaded', () => {
    /**
     * init all sliders
     */
    if (typeof slideConfig !== 'undefined') {
        // eslint-disable-next-line no-undef
        Object.keys(slideConfig).forEach((key) => {
            if (qs('#slide-' + key)) {
                // eslint-disable-next-line no-undef
                tns(slideConfig[key]);
            }
        });
    }

    /**
     * init glightbox
     */
    let lightbox = [];
    if (typeof lightboxConfig !== 'undefined') {
        /**
         * remove cloned images from lightbox
         */
        qsa('li.tns-slide-cloned').forEach((elm) => {
            let html = qs('a', elm).innerHTML;
            elm.innerHTML = html;
        });

        // eslint-disable-next-line no-undef
        Object.keys(lightboxConfig).forEach((key) => {
            if (qs('.lightbox-' + key)) {
                // eslint-disable-next-line no-undef, no-unused-vars
                lightbox[key] = GLightbox(lightboxConfig[key]);
            }
            // eslint-disable-next-line no-undef
        });
    }

    /**
     * custom scroll bars
     */
    qsa('.blocklist .scrollbar').forEach((elm) => {
        elm.style.overflowY = 'visible';
        new SimpleBar(elm);
    });
});

import '../scss/styles.scss';
