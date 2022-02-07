<?php
namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Event;
use File;
use Xitara\DynamicContent\Models\BlockList as BlockListModel;
use Xitara\DynamicContent\Models\Text;
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
        $this->addJs(plugins_url() . '/xitara/dynamiccontent/assets/js/app.js');
        $this->addCss(plugins_url() . '/xitara/dynamiccontent/assets/css/app.css');
    }

    public function onRender()
    {
        $blocklist = BlockListModel::find($this->property('blocklist'));

        if ($blocklist === null) {
            return;
        }

        if ($blocklist->is_defaultcss == 1) {
            $this->addCss(plugins_url() . '/xitara/dynamiccontent/assets/css/default.css');
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
                    $assets = 'xitara/dynamiccontentmodules/assets/';
                    $asset  = $assets . 'css/' . $templateName . '.css';

                    // var_dump(plugins_path($asset));
                    // var_dump(public_path($asset));
                    // var_dump(File::exists(plugins_path($asset)));
                    // var_dump($asset);

                    if (File::exists(plugins_path($asset))) {
                        $this->addCss(plugins_url($asset));
                    }

                    $asset = $assets . 'js/' . $templateName . '.js';
                    // var_dump($asset);

                    if (File::exists(plugins_path($asset))) {
                        $this->addJs(plugins_url($asset));
                    }

                    /**
                     * get dynamic data
                     *
                     * @var array
                     */
                    $textlist = [];
                    $varlist  = [];

                    foreach ($module as $key => $data) {
                        // var_dump($key);
                        if (strpos($key, '_text_') !== false) {
                            $key   = str_replace('_text_', '', $key);
                            $_text = Text::find($data);

                            // var_dump($key);

                            if ($_text !== null) {
                                $textlist[$key] = $_text->text;
                            }
                        } else {
                            $varlist[$key] = $data;
                        }
                    }

                    $parsed = $class::getData($template, $textlist, $varlist);
                    // var_dump($parsed);

                    /**
                     * write config array
                     */
                    $block['dynamic_config'][$templateName] = $template;
                    // var_dump(count($block['dynamic_modules'] ?? []));

                    // var_dump($block['heading']);

                    if (count($block['dynamic_modules'] ?? []) > 1) {
                        $block['dynamic_content'][] = '<li>' . $parsed . '</li>';
                    } else {
                        $block['dynamic_content'][] = $parsed;
                    }

                }
                unset($block['dynamic_modules']);
                // var_dump($block['dynamic_content']);

                $block['dynamic_config'] = array_dot($block['dynamic_config'] ?? []);

                if (count($parsed['dynamic_content'] ?? []) > 1 && $block['is_raw'] == 0) {
                    $dynamicContent = '<ul class="dynamic-content">';
                    $dynamicContent .= join($block['dynamic_content'] ?? []);
                    $dynamicContent .= '</ul>';
                    $block['dynamic_content'] = $dynamicContent;
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
