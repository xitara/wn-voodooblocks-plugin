<?php namespace Xitara\DynamicContent\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Text Groups Back-end Controller
 */
class Groups extends Controller
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
        BackendMenu::setContext('Xitara.DynamicContent', 'dynamiccontent', 'dynamiccontent.textgroups');
        $this->pageTitle = e(trans('xitara.core::core.update_m', [
            'model' => e(trans('xitara.dynamiccontent::lang.submenu.group')),
        ]));
    }
}
