<?php
namespace Xitara\DynamicContent\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use System\Classes\PluginManager;

/**
 * Block Lists Back-end Controller
 */
class BlockLists extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
    ];

    /**
     * @var string Configuration file for the `FormController` behavior.
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @var string Configuration file for the `ListController` behavior.
     */
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('Xitara.DynamicContent', 'dynamiccontent', 'nexus.blocklists');
    }

    public function update($id = null)
    {
        if ($id != null) {
            BackendMenu::setContext('Xitara.DynamicContent',
                'dynamiccontent', 'nexus.blocklist.' . $id);
        }

        $this->asExtension('FormController')->update($id);
    }

    public function formExtendFieldsBefore($form)
    {
        if (PluginManager::instance()->exists('Xitara\DynamicContentModules') === true) {
            $configs = \Xitara\DynamicContentModules\Plugin::loadModules();

            \Log::debug($configs);

            if ($form->isNested === false) {
                $form->fields['blocks']['form']['fields']['block']['form']['tabs']['fields']['dynamic_modules'] = [
                    'tab'    => 'xitara.dynamiccontent::lang.tab.dynamic_content',
                    'prompt' => 'xitara.dynamiccontent::lang.dynamic_content.prompt',
                    'type'   => 'repeater',
                    'span'   => 'full',
                    'style'  => 'accordion',
                    'groups' => $configs,
                ];
            }
        }
    }
}
