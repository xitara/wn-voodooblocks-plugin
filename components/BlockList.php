<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Event;
use File;
use Xitara\DynamicContent\Models\BlockList as BlockListModel;
use \Winter\Storm\Support\Facades\Config;

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
    }

    public function onRender()
    {
        $blocklist = BlockListModel::find($this->property('blocklist'));

        if ($blocklist === null) {
            return;
        }

        $blocklist->blocks = $this->generateBlockList($blocklist->blocks);
        $this->blocklist   = $this->page['blocklist']   = $blocklist;
    }

    public function generateBlockList($blocks)
    {
        $blocklist = [];

        // var_dump($blocks);
        // exit;

        foreach ($blocks as $block) {
            $block = $block['block'];

            /**
             * event to patch block data like parsing placeholder aso
             */
            Event::fire('xitara.dynamiccontent.beforeProcessBlock', [ & $block]);

            if (isset($block['dynamic_modules'])) {
                foreach ($block['dynamic_modules'] as $module) {
                    $class = '\\Xitara\\DynamicContentModules\\Classes\\';
                    $class .= ucfirst(camel_case($module['_group']));

                    \Log::debug($class);

                    if (!class_exists($class)) {
                        continue;
                    }

                    /**
                     * add heading, excerpt and content if not defined by module
                     */
                    foreach (['heading', 'subheading', 'excerpt', 'content'] as $type) {
                        if (!isset($module[$type])) {
                            $module[$type] = trim($block[$type]);
                        }
                    }

                    $templateName = strtolower(camel_case($module['_group']));

                    $template = 'xitara/dynamiccontentmodules/views/';
                    $template .= $templateName . '.htm';
                    \Log::debug($template);

                    if (!File::exists(plugins_path($template))) {
                        $template = null;
                    }

                    /**
                     * inject css and js if exists
                     */
                    $assets = '/xitara/dynamiccontentmodules/assets/';
                    $asset  = $assets . 'css/' . $templateName . '.css';

                    if (File::exists(plugins_path($asset))) {
                        $this->addCss($asset);
                    }

                    $asset = $assets . 'js/' . $templateName . '.js';

                    if (File::exists(plugins_path($asset))) {
                        $this->addJs($asset);
                    }

                    /**
                     * get dynamic data
                     *
                     * @var array
                     */
                    $parsed = $class::getData($module, $template);

                    /**
                     * write config array
                     */
                    $block['dynamic_config'][$templateName] = $template;

                    if (count($block['dynamic_modules']) > 1) {
                        $block['dynamic_content'][] = '<li>' . $parsed . '</li>';
                    } else {
                        $block['dynamic_content'][] = $parsed;
                    }

                    unset($block['dynamic_modules']);
                }

                $block['dynamic_config'] = array_dot($block['dynamic_config'] ?? []);

                if (count($block['dynamic_content'] ?? []) > 1 && $block['is_raw'] == 0) {
                    $block['dynamic_content'] = '<ul class="dynamic-content">';
                    $block['dynamic_content'] .= join($block['dynamic_content'] ?? []);
                    $block['dynamic_content'] .= '</ul>';
                } else {
                    $block['dynamic_content'] = join($block['dynamic_content'] ?? []);
                }

            }

            Event::fire('xitara.dynamiccontent.afterProcessBlock', [ & $block]);

            $blocklist[] = $block;
        }

        return $blocklist;
    }

    public function getBlocklistOptions()
    {
        return BlockListModel::orderBy('name', 'asc')->lists('name', 'id');
    }
}
