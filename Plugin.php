<?php namespace Xitara\DynamicContent;

use App;
use Backend;
use BackendMenu;
use Event;
use System\Classes\PluginBase;
use System\Classes\PluginManager;
use Xitara\DynamicContent\Models\BlockList;

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
            'name' => 'xitara.dynamiccontent::lang.plugin.name',
            'description' => 'xitara.dynamiccontent::lang.plugin.description',
            'author' => 'xitara.dynamiccontent::lang.plugin.author',
            'icon' => 'xitara.dynamiccontent::lang.plugin.icon',
            'iconSvg' => 'xitara.dynamiccontent::lang.plugin.iconSvg',
            'homepage' => 'xitara.dynamiccontent::lang.plugin.homepage',
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
            Event::listen('backend.page.beforeDisplay', function ($controller, $action, $params) {
                $namespace = (new \ReflectionObject($controller))->getNamespaceName();

                if ($namespace == 'Xitara\DynamicContent\Controllers') {
                    \Xitara\Nexus\Plugin::getSideMenu('Xitara.DynamicContent', 'dynamiccontent');
                }
            });
        }
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
                'Xitara.DynamicContent',
                'dynamiccontent',
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
            'Xitara\DynamicContent\Components\BuyedArticle' => 'buyedArticle',
            'Xitara\DynamicContent\Components\BlockList' => 'blockList',
            'Xitara\DynamicContent\Components\LastBuyed' => 'lastBuyed',
        ];
    }

    public function registerPageSnippets()
    {
        return [
            'Xitara\DynamicContent\Components\BuyedArticle' => 'buyedArticle',
            'Xitara\DynamicContent\Components\BlockList' => 'blockList',
            'Xitara\DynamicContent\Components\LastBuyed' => 'lastBuyed',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return []; // Remove this line to activate

        return [
            'xitara.dynamiccontent.some_permission' => [
                'tab' => 'DynamicContent',
                'label' => 'Some permission',
            ],
        ];
    }

    /**
     * Registers back-end navigation items for this plugin.
     *
     * @return array
     */
    public function registerNavigation()
    {
        $label = 'xitara.dynamiccontent::lang.plugin.name';

        if (PluginManager::instance()->exists('Xitara.Nexus') === true) {
            $label .= '::hidden';
        }

        return [
            'dynamiccontent' => [
                'label' => $label,
                'url' => Backend::url('xitara/dynamiccontent/texts'),
                'icon' => 'icon-leaf',
                'iconSvg' => '/plugins/xitara/dynamiccontent/assets/images/dynamiccontent-icon.svg',
                'permissions' => ['xitara.dynamiccontent.*'],
                'order' => 500,
            ],
        ];
    }

    public static function injectSideMenu()
    {
        // Log::debug(__METHOD__);

        $i = 0;
        $inject['dynamiccontent.blocklists'] = [
            'label' => 'xitara.dynamiccontent::lang.submenu.blocklist',
            'url' => Backend::url('xitara/dynamiccontent/blocklists'),
            'icon' => 'icon-archive',
            'permissions' => ['xitara.dynamiccontent.*'],
            'attributes' => [
                'group' => 'xitara.dynamiccontent::lang.submenu.label',
            ],
            'order' => \Xitara\Nexus\Plugin::getMenuOrder('xitara.dynamiccontent') + $i++,
        ];

        foreach (BlockList::orderBy('name', 'asc')->get() as $index => $blocklist) {
            $inject['dynamiccontent.blocklist.' . $blocklist->id] = [
                'label' => $blocklist->name,
                'url' => Backend::url('xitara/dynamiccontent/blocklists/update/' . $blocklist->id),
                'icon' => 'icon-archive',
                'permissions' => ['xitara.dynamiccontent.*'],
                'attributes' => [
                    'group' => 'xitara.dynamiccontent::lang.submenu.label',
                    'level' => 2,
                ],
                'order' => \Xitara\Nexus\Plugin::getMenuOrder('xitara.dynamiccontent') + $i++,
            ];
        }

        // $inject['dynamiccontent.blockgroups'] = [
        //     'label' => 'xitara.dynamiccontent::lang.submenu.blockgroup',
        //     'url' => Backend::url('Xitara/dynamiccontent/blockgroups'),
        //     'icon' => 'icon-archive',
        //     'permissions' => ['xitara.dynamiccontent.*'],
        //     'attributes' => [
        //         'group' => 'xitara.dynamiccontent::lang.submenu.label',
        //     ],
        //     'order' => \Xitara\Nexus\Plugin::getMenuOrder('xitara.dynamiccontent') + $i++,
        // ];
        $inject['dynamiccontent.texts'] = [
            'label' => 'xitara.dynamiccontent::lang.submenu.text',
            'url' => Backend::url('xitara/dynamiccontent/texts'),
            'icon' => 'icon-archive',
            'permissions' => ['xitara.dynamiccontent.*'],
            'attributes' => [
                'group' => 'xitara.dynamiccontent::lang.submenu.label',
                'line' => 'top',
            ],
            'order' => \Xitara\Nexus\Plugin::getMenuOrder('xitara.dynamiccontent') + $i++,
        ];
        $inject['dynamiccontent.textgroups'] = [
            'label' => 'xitara.dynamiccontent::lang.submenu.group',
            'url' => Backend::url('xitara/dynamiccontent/groups'),
            'icon' => 'icon-archive',
            'permissions' => ['xitara.dynamiccontent.*'],
            'attributes' => [
                'group' => 'xitara.dynamiccontent::lang.submenu.label',
            ],
            'order' => \Xitara\Nexus\Plugin::getMenuOrder('xitara.dynamiccontent') + $i++,
        ];

        return $inject;
    }
}
