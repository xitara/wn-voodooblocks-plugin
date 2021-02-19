<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Event;
use Xitara\DynamicContent\Models\BlockList as BlockListModel;

class BlockList extends ComponentBase
{
    public $blocklist;

    public function componentDetails()
    {
        return [
            'name' => 'BlockList Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [
            'blocklist' => [
                'title' => 'xitara.dynamiccontent::component.blocklist.title',
                'description' => 'xitara.dynamiccontent::component.blocklist.description',
                'type' => 'dropdown',
                'required' => true,
            ],
        ];
    }

    public function onRun()
    {
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

                foreach ($block['block']['dynamic_modules'] as $module) {
                    $class = '\\Xitara\\DynamicContentModules\\Classes\\';
                    $class .= ucfirst(camel_case($module['_group']));

                    if (!class_exists($class)) {
                        continue;
                    }

                    $object = new $class;

                    $template = 'xitara/dynamiccontentmodules/views/';
                    $template .= $module['_group'] . '.htm';

                    if (!file_exists(plugins_path($template))) {
                        $template = null;
                    }

                    $block['block']['dynamic_content'][] = $object->getText($template, $module);
                }
                $block['block']['dynamic_content'] = join($block['block']['dynamic_content'] ?? []);
            }
            $blocklist_[] = $block['block'];

            $block_ = Event::fire('xitara.dynamiccontent.afterProcessBlock', [$block]);
            if (isset($block_[0])) {
                $block = $block_[0];
            }
        }

        $blocklist->blocks = $blocklist_;
        $this->blocklist = $this->page['blocklist'] = $blocklist;
    }

    public function getBlocklistOptions()
    {
        return BlockListModel::orderBy('name', 'asc')->lists('name', 'id');
    }
}
