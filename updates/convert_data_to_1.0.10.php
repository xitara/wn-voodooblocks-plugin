<?php namespace Xitara\DynamicContent\Updates;

use Winter\Storm\Database\Updates\Migration;
use Xitara\DynamicContent\Models\BlockList;

class AddColumnsToBlockgroupTable extends Migration
{
    public function up()
    {
        $blocklists = BlockList::all();

        foreach ($blocklists as $blocklist) {
            foreach ($blocklist->blocks as $i => $block) {
                $block = $block['block'];

                $block['is_raw']     = $block['is_raw'] ?? 0;
                $block['is_heading'] = $block['is_heading'] ?? 1;
                $block['is_box']     = $block['is_box'] ?? 1;

                $block['is_scrollbar'] = (int) $block['is_scrolling'];
                unset($block['is_scrolling']);

                if (isset($block['buttons_above'])) {
                    foreach ($block['buttons_above'] as $key => $button) {
                        $block['buttons_above'][$key]['is_blank'] = (($button['target'] ?? '_self') == '_self' ? 0 : 1);
                        unset($block['buttons_above'][$key]['target']);
                    }
                }

                if (isset($block['buttons'])) {
                    foreach ($block['buttons'] as $key => $button) {
                        $block['buttons'][$key]['is_blank'] = (($button['target'] ?? '_self') == '_self' ? 0 : 1);
                        unset($block['buttons'][$key]['target']);
                    }
                }

                if (isset($block['images'])) {
                    foreach ($block['images'] as $key => $images) {
                        $block['images'][$key]['is_blank'] = (($images['target'] ?? '_self') == '_self' ? 0 : 1);
                        unset($block['images'][$key]['target']);
                    }
                }

                $block['lightbox']['options'] = $block['lightbox']['lightbox_options'];
                unset($block['lightbox']['lightbox_options']);
                $blocklist_[$i]['block'] = $block;
            }

            $blocklist->blocks = $blocklist_;
            $blocklist->save();
        }
    }

    public function down()
    {
    }
}
