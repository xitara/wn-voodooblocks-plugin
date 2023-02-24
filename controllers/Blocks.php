<?php

namespace Xitara\VoodooBlocks\Controllers;

use BackendMenu;
use Backend\Classes\Controller;
use Event;

/**
 * Blocks Backend Controller
 */
class Blocks extends Controller
{
    /**
     * @var array Behaviors that are implemented by this controller.
     */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public function __construct()
    {
        \Log::debug(__METHOD__);

        parent::__construct();

        BackendMenu::setContext('Xitara.VoodooBlocks', 'voodooblocks', 'blocks');
    }

    // public function formExtendFields($form)
    // {
    //     \Log::debug(__METHOD__);

    //     Event::fire('xitara.voodooblocks.dynamicblocks', function ($modules) use ($form) {
    //         foreach ($modules as $module) {
    //             \Log::debug($module);

    //             if ($form->isNested === false) {
    //                 $form->fields['blocks']['form']['fields']['block']['form']['tabs']['fields']['dynamic_blocks'] = [
    //                     'tab'    => 'xitara.voodooblocks::lang.tab.dynamic_blocks',
    //                     'prompt' => 'xitara.voodooblocks::lang.dynamic_blocks.prompt',
    //                     'type'   => 'repeater',
    //                     'span'   => 'full',
    //                     'style'  => 'accordion',
    //                     // 'groups' => $block,
    //                 ];
    //             }
    //         }
    //     });
    // }
}
