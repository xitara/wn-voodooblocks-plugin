<?php

namespace Xitara\VoodooBlocks;

use App;
use Backend;
use BackendMenu;
use Event;
use System\Classes\PluginBase;
use System\Classes\PluginManager;
use Xitara\VoodooBlocks\Models\Blocklist;

/**
 * DynamicContent Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'xitara.voodooblocks::lang.plugin.name',
            'description' => 'xitara.voodooblocks::lang.plugin.description',
            'author'      => 'xitara.voodooblocks::lang.plugin.author',
            'icon'        => 'xitara.voodooblocks::lang.plugin.icon',
            'iconSvg'     => 'xitara.voodooblocks::lang.plugin.iconSvg',
            'homepage'    => 'xitara.voodooblocks::lang.plugin.homepage',
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        /**
         * Check if we are currently in backend module.
         */
        if (!App::runningInBackend()) {
            return;
        }

        /**
         * get sidemenu if core-plugin is loaded
         */
        if (PluginManager::instance()->exists('Xitara.Nexus') === true) {
            Event::listen('backend.page.beforeDisplay', function ($controller) {
                $namespace = (new \ReflectionObject($controller))->getNamespaceName();

                if ($namespace == 'Xitara\VoodooBlocks\Controllers') {
                    \Xitara\Nexus\Plugin::getSideMenu('Xitara.VoodooBlocks', 'voodooblocks');
                }
            });
        }

        Event::listen('backend.page.beforeDisplay', function ($controller) {
            $path = plugins_path('/xitara/voodooblocks/assets');
            $controller->addCss($path . '/css/backend.css');
            $controller->addJs($path . '/js/backend.js');
        });
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {
        if (PluginManager::instance()->exists('Xitara.Nexus') === true) {
            BackendMenu::registerContextSidenavPartial(
                'Xitara.VoodooBlocks',
                'voodooblocks',
                '$/xitara/nexus/partials/_sidebar.htm'
            );
        }
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Xitara\VoodooBlocks\Components\Blocklist'  => 'blocklist',
        ];
    }

    public function registerPageSnippets()
    {
        return $this->registerComponents();
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'xitara.voodooblocks.create'            => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Create Blockslists',
            ],
            'xitara.voodooblocks.edit'              => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Edit Blockslists',
            ],
            'xitara.voodooblocks.create_groups'     => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Create Groups',
            ],
            'xitara.voodooblocks.edit_groups'       => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Edit Groups',
            ],
            'xitara.voodooblocks.create_texts'      => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Create Texts',
            ],
            'xitara.voodooblocks.edit_texts'        => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Edit Texts',
            ],
            'xitara.voodooblocks.create_textgroups' => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Create Textgroups',
            ],
            'xitara.voodooblocks.edit_textgroups'   => [
                'tab'   => 'Voodoo Blocks',
                'label' => 'Edit Textgroups',
            ],
        ];
    }

    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'renderModules' => [$this, 'renderModules'],
                'dropdownData' => [$this, 'dropdownData'],
            ]
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        $label = 'xitara.voodooblocks::lang.plugin.name';

        if (PluginManager::instance()->exists('Xitara.Nexus') === true) {
            $label .= '::hidden';
        }

        return [
            'voodooblocks' => [
                'label'       => $label,
                'url'         => Backend::url('xitara/voodooblocks/texts'),
                'icon'        => 'icon-leaf',
                'iconSvg'     => '/plugins/xitara/voodooblocks/assets/images/voodooblocks-icon.svg',
                'permissions' => ['xitara.voodooblocks.*'],
                'order'       => 500,
            ],
        ];
    }

    public static function injectSideMenu()
    {
        // Log::debug(__METHOD__);

        $i = 0;
        return [
            'voodooblocks.blocklists'  => [
                'label'       => 'xitara.voodooblocks::lang.submenu.blocklist',
                'url'         => Backend::url('xitara/voodooblocks/blocklists'),
                'icon'        => 'icon-archive',
                'permissions' => [
                    'xitara.voodooblocks.create',
                    'xitara.voodooblocks.edit',
                ],
                'attributes'  => [
                    'group'       => 'xitara.voodooblocks::lang.submenu.label',
                    'placeholder' => true,
                ],
                'order'       => \Xitara\Nexus\Plugin::getMenuOrder('xitara.voodooblocks') + $i++,
            ],
            // 'voodooblocks.blockgroups' => [
            //     'label'       => 'xitara.voodooblocks::lang.submenu.blockgroup',
            //     'url'         => Backend::url('xitara/voodooblocks/blockgroups'),
            //     'icon'        => 'icon-archive',
            //     'permissions' => [
            //         'xitara.voodooblocks.create_groups',
            //         'xitara.voodooblocks.edit_groups',
            //     ],
            //     'attributes'  => [
            //         'group' => 'xitara.voodooblocks::lang.submenu.label',
            //     ],
            //     'order'       => \Xitara\Nexus\Plugin::getMenuOrder('xitara.voodooblocks') + $i++,
            // ],
            // 'voodooblocks.texts'       => [
            //     'label'       => 'xitara.voodooblocks::lang.submenu.text',
            //     'url'         => Backend::url('xitara/voodooblocks/texts'),
            //     'icon'        => 'icon-archive',
            //     'permissions' => [
            //         'xitara.voodooblocks.create_texts',
            //         'xitara.voodooblocks.edit_texts',
            //     ],
            //     'attributes'  => [
            //         'group' => 'xitara.voodooblocks::lang.submenu.label',
            //     ],
            //     'order' => \Xitara\Nexus\Plugin::getMenuOrder('xitara.voodooblocks') + $i++,
            // ],
            // 'voodooblocks.textgroups'  => [
            //     'label'       => 'xitara.voodooblocks::lang.submenu.group',
            //     'url'         => Backend::url('xitara/voodooblocks/groups'),
            //     'icon'        => 'icon-archive',
            //     'permissions' => [
            //         'xitara.voodooblocks.create_textgroups',
            //         'xitara.voodooblocks.edit_textgroups',
            //     ],
            //     'attributes'  => [
            //         'group'       => 'xitara.voodooblocks::lang.submenu.label',
            //         'placeholder' => true,
            //     ],
            //     'order'       => \Xitara\Nexus\Plugin::getMenuOrder('xitara.voodooblocks') + $i++,
            // ],
        ];
    }

    public static function getBlocklistOptions()
    {
        $data = Blocklist::orderBy('name', 'asc')->lists('name', 'slug');
        $data = ['none' => e(trans('xitara.voodooblocks::lang.no_blocklist'))]
            + $data;

        return $data;
    }

    public function renderModules($modules)
    {
        $result = [];
        foreach ($modules as $module) {
            // var_dump($module);
            $namespace = '\\' . str_replace('-', '\\', $module['_group']);
            unset($module['_group']);

            if (method_exists($namespace, 'renderText')) {
                $result[] = $namespace::renderText($module);
            }
        }

        return join($result);
    }

    public function dropdownData($value)
    {
        // $result = [];
        // foreach ($modules as $module) {
        //     // var_dump($module);
        //     $namespace = '\\' . str_replace('-', '\\', $module['_group']);
        //     unset($module['_group']);

        //     if (method_exists($namespace, 'renderText')) {
        //         $result[] = $namespace::renderText($module);
        //     }
        // }

        return $value;
    }
}
