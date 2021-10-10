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
            'name'        => 'BlockList Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [
            'blocklist' => [
                'title'       => 'xitara.dynamiccontent::component.blocklist.title',
                'description' => 'xitara.dynamiccontent::component.blocklist.description',
                'type'        => 'dropdown',
                'required'    => true,
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
            $block = $block['block'];

            /**
             * event to patch block data like parsing placeholder aso
             */
            Event::fire('xitara.dynamiccontent.beforeProcessBlock', [ & $block]);

            if (isset($block['dynamic_modules'])) {
                foreach ($block['dynamic_modules'] as $module) {
                    $class = '\\Xitara\\DynamicContentModules\\Classes\\';
                    $class .= ucfirst(camel_case($module['_group']));

                    if (!class_exists($class)) {
                        continue;
                    }

                    // $object = new $class;

                    /**
                     * add heading, excerpt and content if not defined by module
                     */
                    foreach (['heading', 'subheading', 'excerpt', 'content'] as $type) {
                        if (!isset($module[$type])) {
                            $module[$type] = $block[$type];
                        }
                    }

                    $templateName = strtolower(camel_case($module['_group']));

                    $template = 'xitara/dynamiccontentmodules/views/';
                    $template .= $templateName . '.htm';

                    if (!file_exists(plugins_path($template))) {
                        $template = null;
                    }

                    /**
                     * get dynamic data
                     *
                     * @var array
                     */
                    // $data = $class::getData($template, $module);
                    $data = $class::getData($module);

                    /**
                     * write config array
                     */
                    $block['dynamic_config'][$templateName] = $data['config'];

                    if (count($block['dynamic_modules']) > 1) {
                        $block['dynamic_content'][] = '<li>' . $data['content'] . '</li>';
                    } else {
                        $block['dynamic_content'][] = $data['content'];
                    }

                    unset($block['dynamic_modules']);
                }

                $block['dynamic_config'] = array_dot($block['dynamic_config'] ?? []);

                if (count($block['dynamic_content'] ?? []) > 1) {
                    $block['dynamic_content'] = '<ul class="dynamic-content">';
                    $block['dynamic_content'] .= join($block['dynamic_content'] ?? []);
                    $block['dynamic_content'] .= '</ul>';
                } else {
                    $block['dynamic_content'] = join($block['dynamic_content'] ?? []);
                }

            }

            // var_dump($block);

            // var_dump($blocklist_);

            Event::fire('xitara.dynamiccontent.afterProcessBlock', [ & $block]);

            $blocklist_[] = $block;

            //     if (isset($block_[0])) {
            //         $block = $block_[0];
            //     }
        }

        $blocklist->blocks = $blocklist_;
        $this->blocklist   = $this->page['blocklist']   = $blocklist;
    }

    public function getBlocklistOptions()
    {
        return BlockListModel::orderBy('name', 'asc')->lists('name', 'id');
    }
}
