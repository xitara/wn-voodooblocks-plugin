<?php namespace Xitara\DynamicContent\Models;

use Model;
use Xitara\EroBridge\Classes\Api;

/**
 * BlockList Model
 */
class BlockList extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'xitara_dynamiccontent_block_lists';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = ['blocks'];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * @var array Relations
     */
    public $hasOne         = [];
    public $hasMany        = [];
    public $hasOneThrough  = [];
    public $hasManyThrough = [];
    public $belongsTo      = [];
    public $belongsToMany  = [
        // 'groups' => [
        //     'Xitara\DynamicContent\Models\BlockGroup',
        //     'table' => 'xitara_dynamiccontent_block_block_groups',
        //     'key' => 'block_id',
        //     'otherKey' => 'group_id',
        // ],
    ];
    public $morphTo    = [];
    public $morphOne   = [];
    public $morphMany  = [];
    public $attachOne  = [];
    public $attachMany = [];

    // public function beforeSave()
    // {
    //     $blocks = $this->blocks;

    //     foreach ($blocks as $block) {
    //         $block['excerpt'] = trim($block['excerpt']);
    //         $block['content'] = trim($block['content']);

    //         $blocks_[] = $block;
    //     }

    //     $this->blocks = $blocks_;
    // }

    // public function getDropdownOptions($fieldName, $value, $formData)
    // {
    //     if (input('_repeater_group', null) != null) {
    //         $group = input('_repeater_group');
    //     }

    //     if (isset($formData->_group)) {
    //         $group = $formData->_group;
    //     }

    //     Log::debug($group);

    //     $class = '\\Xitara\\DynamicContentModules\\Classes\\';
    //     // $class .= ucfirst(camel_case($formData->_group));
    //     $class .= ucfirst(camel_case($group));
    //     $method = 'get' . ucfirst(camel_case($fieldName)) . 'Options';

    //     // return ['all' => 'All'];
    //     // return $class::$method($value, $formData->_group);
    //     return $class::$method($value, $group);
    // }

    public static function getGroupedTextOptions($formWidget, $formField)
    {
        $group = $formField->fieldName;

        if ($group === null) {
            return Text::orderBy('name', 'asc')->lists('name', 'id');
        }

        $texts = Text::orderBy('name', 'asc')->get();

        if ($texts === null) {
            return [];
        }

        $group = Group::where('slug', str_slug($group))->first();

        if ($group === null) {
            return Text::orderBy('name', 'asc')->lists('name', 'id');
        }

        $textList = [];
        foreach ($texts as $text) {
            foreach ($text->groups as $group_) {
                if ($group->id == $group_->id) {
                    $textList[$text->id] = $text->name;
                }
            }
        }

        if (empty($textList)) {
            return Text::orderBy('name', 'asc')->lists('name', 'id');
        }

        return $textList;
    }
}
