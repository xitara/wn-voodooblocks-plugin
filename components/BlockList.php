<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Event;
use Xitara\DynamicContent\Models\BlockList as BlockListModel;

class BlockList extends ComponentBase {
    public $blocklist;

    public function componentDetails() {
        return [
            'name' => 'BlockList Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties() {
        return [
            'blocklist' => [
                'title' => 'xitara.dynamiccontent::component.blocklist.title',
                'description' => 'xitara.dynamiccontent::component.blocklist.description',
                'type' => 'dropdown',
                'required' => true,
            ],
        ];
    }

    public function onRun() {
        $this->addCss('/plugins/xitara/dynamiccontent/assets/css/app.css');
        $this->addJs('/plugins/xitara/dynamiccontent/assets/js/app.js');

        $blocklist = BlockListModel::find($this->property('blocklist'));

        if ($blocklist === null) {
            return;
        }

        $blocklist_ = [];

        foreach ($blocklist->blocks as $block) {
            /**
             * event to patch block data like parsing placeholder aso
             */
            $block_ = Event::fire('xitara.dynamiccontent.beforeProcessBlock', [$block]);
            if (isset($block_[0])) {
                $block = $block_[0];
            }

            if (isset($block['block']['dynamic_modules'])) {

                foreach ($block['block']['dynamic_modules'] as $i => $module) {
                    $class = '\\Xitara\\DynamicContentModules\\Classes\\';
                    $class .= ucfirst(camel_case($module['_group']));

                    if (!class_exists($class)) {
                        continue;
                    }

                    $object = new $class;

                    /**
                     * add heading, excerpt and content if not defined by module
                     */
                    foreach (['heading', 'excerpt', 'content'] as $type) {
                        if (!isset($module[$type])) {
                            $module[$type] = $block['block'][$type];
                        }
                    }

                    $template = 'xitara/dynamiccontentmodules/views/';
                    $template .= $module['_group'] . '.htm';

                    if (!file_exists(plugins_path($template))) {
                        $template = null;
                    }

                    $data = $object->getData($template, $module);
                    $block['block']['dynamic_config'][$i] = $data['config'];

                    if (count($block['block']['dynamic_modules']) > 1) {
                        $block['block']['dynamic_content'][$i] = '<li>' . $data['content'] . '</li>';
                    } else {
                        $block['block']['dynamic_content'][$i] = $data['content'];
                    }
                }

                if (count($block['block']['dynamic_content'] ?? []) > 1) {
                    $block['block']['dynamic_content'] = '<ul class="dynamic-content">' . join($block['block']['dynamic_content'] ?? []) . '</ul>';
                } else {
                    $block['block']['dynamic_content'] = join($block['block']['dynamic_content'] ?? []);
                }
            }
            $blocklist_[] = $block['block'];

            // var_dump($blocklist_);

            $block_ = Event::fire('xitara.dynamiccontent.afterProcessBlock', [$block]);
            if (isset($block_[0])) {
                $block = $block_[0];
            }
        }

        $blocklist->blocks = $blocklist_;
        $this->blocklist = $this->page['blocklist'] = $blocklist;
    }

    public function getBlocklistOptions() {
        return BlockListModel::orderBy('name', 'asc')->lists('name', 'id');
    }
}
