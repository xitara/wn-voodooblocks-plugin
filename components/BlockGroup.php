<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Event;
use Xitara\DynamicContent\Models\BlockGroup as BlockGroupModel;
use Xitara\DynamicContent\Models\BlockList;

class BlockGroup extends ComponentBase
{
    public $blockgroup;
    public $groupdata;

    public function componentDetails()
    {
        return [
            'name' => 'BlockGroup Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [
            'blockgroup' => [
                'title' => 'xitara.dynamiccontent::component.blockgroup.title',
                'description' => 'xitara.dynamiccontent::component.blockgroup.description',
                'type' => 'dropdown',
                'required' => true,
            ],
            'cssClasses' => [
                'title' => 'kuse.dynamiccontent::component.blockgroup.css_classes',
                'description' => 'kuse.dynamiccontent::component.blockgroup.css_classes_description',
                'type' => 'string',
            ],
        ];
    }

    public function onRun()
    {
        $this->addCss('/plugins/xitara/dynamiccontent/assets/css/app.css');
        $this->addJs('/plugins/xitara/dynamiccontent/assets/js/app.js');

        $blockgroup = BlockGroupModel::find($this->property('blockgroup'));

        if ($blockgroup === null) {
            return;
        }

        if ($blockgroup->is_active == 0) {
            return;
        }

        $blocks = [];
        foreach ($blockgroup->blockgroup as $blocklist) {
            $blocks = array_merge($blocks, $this->processBlockList($blocklist));
            // $this->processBlockList($blocklist);
        }

        $this->blockgroup = $this->page['blockgroup'] = $blocks;
        $this->groupdata = $this->page['groupdata'] = [
            'name' => $blockgroup->name,
            'subheading' => $blockgroup->subheading,
            'content' => $blockgroup->content,
            'slug' => $blockgroup->slug,
            'is_heading' => $blockgroup->is_heading,
            'is_active' => $blockgroup->is_active,
        ];

        // var_dump($blocks);
        // var_dump($this->groupdata);
        // exit;

        $this->page['cssClasses'] = $this->property('cssClasses', '');
    }

    public function getBlockGroupOptions()
    {
        return BlockGroupModel::orderBy('name', 'asc')->lists('name', 'id');
    }

    private function processBlockList($id)
    {
        $list = BlockList::find($id);

        if ($list === null) {
            return;
        }

        // var_dump($id);
        // var_dump($list[0]->name);
        // return;

        $list_ = [];

        foreach ($list[0]->blocks as $block) {
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

                    $block['block']['dynamic_content'][] = '<li>' . $object->getText($template, $module) . '</li>';
                }
                $block['block']['dynamic_content'] = '<ul class="dynamic-content">' . join($block['block']['dynamic_content'] ?? []) . '</ul>';
            }
            $blocklist_[] = $block['block'];

            $block_ = Event::fire('xitara.dynamiccontent.afterProcessBlock', [$block]);
            if (isset($block_[0])) {
                $block = $block_[0];
            }
        }

        return $blocklist_;
    }
}
