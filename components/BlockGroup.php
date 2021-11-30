<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Xitara\DynamicContent\Components\BlockList as BlockListComponent;
use Xitara\DynamicContent\Models\BlockGroup as BlockGroupModel;
use Xitara\DynamicContent\Models\BlockList;

class BlockGroup extends ComponentBase
{
    public $blockgroup;
    public $groupdata;

    public function componentDetails()
    {
        return [
            'name'        => 'BlockGroup Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [
            'blockgroup' => [
                'title'       => 'xitara.dynamiccontent::component.blockgroup.title',
                'description' => 'xitara.dynamiccontent::component.blockgroup.description',
                'type'        => 'dropdown',
                'required'    => true,
            ],
            'cssClasses' => [
                'title'       => 'kuse.dynamiccontent::component.blockgroup.css_classes',
                'description' => 'kuse.dynamiccontent::component.blockgroup.css_classes_description',
                'type'        => 'string',
            ],
        ];
    }

    public function onInit()
    {
        $this->controller->addComponent('\Xitara\DynamicContent\Models\Xitara\DynamicContent\Models\BlockList', 'blockList', []);
    }

    public function onRun()
    {
        $this->addCss('/plugins/xitara/dynamiccontent/assets/css/app.css');
        $this->addJs('/plugins/xitara/dynamiccontent/assets/js/app.js');

        $blockgroup = BlockGroupModel::find($this->property('blockgroup'));

        if ($blockgroup === null) {
            return;
        }

        if ($blockgroup->is_active == 0) {
            return;
        }

        $blocks = [];
        foreach ($blockgroup->blockgroup as $blocklist) {
            $blocks[] = $this->processBlockList($blocklist);
        }

        $blockgroup->blockgroup = $blocks;

        $this->blockgroup         = $this->page['blockgroup']         = $blockgroup;
        $this->page['cssClasses'] = $this->property('cssClasses', '');
    }

    public function getBlockGroupOptions()
    {
        return BlockGroupModel::orderBy('name', 'asc')->lists('name', 'id');
    }

    private function processBlockList($id)
    {
        $blocklist = BlockList::where('id', $id)->first();

        if ($blocklist === null) {
            return;
        }

        $blc               = new BlockListComponent;
        $blocklist->blocks = $blc->generateBlockList($blocklist->blocks);

        return $blocklist;
    }
}
