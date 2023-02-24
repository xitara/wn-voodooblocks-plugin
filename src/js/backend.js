import { qs, qsa, $on } from './utils';
import '../scss/backend.scss';

$on(document, 'DOMContentLoaded', () => {
    // if (qs('#Repeater-formBlocks-items-blocks > li')) {
    //     qsa('#Repeater-formBlocks-items-blocks > li').forEach((el) => {
    //         let elm = qs('label > [name$="[block][is_active]"]', el);
    //         if (elm.checked === false) {
    //             qs('.repeater-item-collapsed-title', el).classList.add('blocklist-block-inactive');
    //         }
    //         $on(elm, 'change', () => {
    //             qs('.repeater-item-collapsed-title', el).classList.toggle(
    //                 'blocklist-block-inactive'
    //             );
    //         });
    //     });
    // }
});
