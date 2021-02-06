<?php namespace Xitara\DynamicContent\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use File;
use Xitara\DynamicContent\Models\Text;
use Xitara\DynamicContent\Plugin as DynamicContent;

/**
 * Text Pool Back-end Controller
 */
class Texts extends Controller
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
        BackendMenu::setContext('Xitara.DynamicContent', 'dynamiccontent', 'nexus.texts');
        $this->pageTitle = e(trans('xitara.nexus::core.update_m', [
            'model' => e(trans('xitara.dynamiccontent::lang.submenu.text')),
        ]));

        $this->getAllPlaceholder();
    }

    private function getAllPlaceholder()
    {
        $manuals = [];
        $moduleDir = plugins_path('/xitara/dynamiccontentmodules/classes');
        $namespace = '\\Xitara\\DynamicContentModules\\Classes\\';

        try {
            $dir = new \DirectoryIterator($moduleDir);
            foreach ($dir as $file) {
                if (!$file->isDot()) {
                    $className = $file->getBasename('.php');
                    $object = $namespace . $className;

                    if (!empty($object::$placeholder)) {
                        $manuals[$className] = [];

                        foreach ($object::$placeholder as $placeholder) {
                            $description = 'xitara.dynamiccontentmodules::';
                            $description .= strtolower($className) . '.placeholder';
                            $description .= '.' . $placeholder;
                            $manuals[$className][$placeholder] = trans($description);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            return [];
        }

        ksort($manuals);

        $this->vars['manuals'] = $manuals;
    }
}
