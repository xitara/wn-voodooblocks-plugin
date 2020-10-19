<?php namespace Xitara\DynamicContent\Components;

use Cms\Classes\ComponentBase;
use Xitara\DynamicContent\Models\BlockList as BlockListModel;

class BlockList extends ComponentBase
{
    public $blocklist;

    public function componentDetails()
    {
        return [
            'name' => 'BlockList Component',
            'description' => 'No description provided yet...',
        ];
    }

    public function defineProperties()
    {
        return [
            'blocklist' => [
                'title' => 'xitara.dynamiccontent::component.blocklist.title',
                'description' => 'xitara.dynamiccontent::component.blocklist.description',
                'type' => 'dropdown',
                'required' => true,
            ],
        ];
    }

    public function onRun()
    {
        $this->addCss('/plugins/xitara/dynamiccontent/assets/css/app.css');
        $this->addJs('/plugins/xitara/dynamiccontent/assets/js/app.js');

        $blocklist = BlockListModel::find($this->property('blocklist'));

        if ($blocklist === null) {
            return;
        }

        $this->blocklist = $this->page['blocklist'] = $blocklist;
    }

    public function getBlocklistOptions()
    {
        return BlockListModel::orderBy('name', 'asc')->lists('name', 'id');
    }
}
