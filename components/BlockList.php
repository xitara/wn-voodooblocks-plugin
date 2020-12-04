<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
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
        $this->addCss('/themes/la-theme-src/assets/css/app.css');
        $this->addCss('/plugins/xitara/dynamiccontent/assets/css/app.css');
        $this->addJs('/plugins/xitara/dynamiccontent/assets/js/app.js');

        $blocklist = BlockListModel::find($this->property('blocklist'));
        // var_dump($blocklist);

        if ($blocklist === null) {
            return;
        }

        $blocklist_ = [];
        foreach ($blocklist->blocks as $block) {
            // var_dump($block['block']);
            if (isset($block['block']['dynamic_modules'])) {
                // $blocklist_[] = $block;
                // continue;

                // var_dump($block['block']['dynamic_modules']);

                foreach ($block['block']['dynamic_modules'] as $module) {
                    $class = '\\Xitara\\DynamicContentModules\\Classes\\';
                    $class .= ucfirst(camel_case($module['_group']));

                    // var_dump($class);
                    // var_dump(class_exists($class));

                    if (!class_exists($class)) {
                        continue;
                    }

                    $object = new $class;

                    // var_dump($module);

                    $template = 'xitara/dynamiccontentmodules/views/';
                    $template .= $module['_group'] . '.htm';
                    // var_dump($template);

                    if (!file_exists(plugins_path($template))) {

                        // $template = file_get_contents(plugins_path($template));
                        // var_dump($template);
                        // var_dump($module);
                        // } else {
                        $template = null;
                    }

                    // if ($template === false) {
                    //     continue;
                    // }

                    $block['block']['dynamic_content'][] = $object->getText($template, $module);
                }
                $block['block']['dynamic_content'] = join($block['block']['dynamic_content'] ?? []);
            }
            $blocklist_[] = $block['block'];
        }

        $blocklist->blocks = $blocklist_;
        // var_dump($blocklist_);
        // var_dump($blocklist->blocks);
        // exit;

        $this->blocklist = $this->page['blocklist'] = $blocklist;
    }

    public function getBlocklistOptions()
    {
        return BlockListModel::orderBy('name', 'asc')->lists('name', 'id');
    }
}
