<?php namespace Xitara\DynamicContent\Models;

use Model;
use Xitara\DynamicContent\Models\Text;
use Xitara\EroBridge\Classes\Api;

/**
 * BlockList Model
 */
class BlockList extends Model
{
    use \October\Rain\Database\Traits\Validation;

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
    public $hasOne = [];
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [
        'groups' => [
            'Xitara\DynamicContent\Models\BlockGroup',
            'table' => 'xitara_dynamiccontent_block_block_groups',
            'key' => 'block_id',
            'otherKey' => 'group_id',
        ],
    ];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
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

    public function getTextNoPlaceOptions()
    {
        return Text::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getTextPlaceOptions()
    {
        return Text::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getTextFirstPlaceOptions()
    {
        return Text::orderBy('name', 'asc')->lists('name', 'id');
    }

    public function getArticleOptions()
    {
        $result = Api::call('article/search', [
            'search' => '',
            'list' => true,
        ]);

        return $result->body->data;
    }
}
