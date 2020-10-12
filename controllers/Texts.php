<?php namespace Xitara\DynamicContent\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Cms\Classes\ComponentManager;
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
        BackendMenu::setContext('Xitara.DynamicContent', 'dynamiccontent', 'texts');
        $this->pageTitle = e(trans('xitara.core::core.update_m', [
            'model' => e(trans('xitara.dynamiccontent::lang.submenu.text')),
        ]));

        $this->getAllPlaceholder();
    }

    private function getAllPlaceholder()
    {
        $manager = ComponentManager::instance();
        // $dc = DynamicContent::instance();
        // $manager->listComponents();

        // var_dump(Text::settings('components'));
        // var_dump($dc->registerComponents());
        // var_dump($manager->listComponents());
        // var_dump($this->model->settings['components']);

        // $namespace = (new \ReflectionObject($this))->getNamespaceName();

        // var_dump($namespace);

        $manuals = [];
        foreach ($manager->listComponents() as $name => $component) {
            // var_dump($manager->findComponentPlugin($component))
            if (strpos($component, '\Xitara\DynamicContent\Components') !== false) {
                $name = strtolower($name);

                // var_dump($name);
                // var_dump($component);

                $manuals[$name] = [];
                foreach ($component::$placeholder as $placeholder) {
                    $description = 'xitara.dynamiccontent::component.' . $name;
                    $description .= '.' . $placeholder;
                    // $description = trans($description);

                    $manuals[$name][$placeholder] = trans($description);

                    // echo $description . "<br>\n";
                }
            }
        }
        // var_dump($manual);

        $this->vars['manuals'] = $manuals;

        // exit;
    }
}
