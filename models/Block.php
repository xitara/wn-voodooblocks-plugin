<?php

namespace Xitara\VoodooBlocks\Models;

use Model;

/**
 * Block Model
 */
class Block extends Model
{
    use \Winter\Storm\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'xitara_voodooblocks_blocks';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    // protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    // protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'buttons_above',
        'buttons',
        'images',
        'slider',
        'lightbox',
        'modules',
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    // protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    // protected $hidden = [];

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
    // public $hasOne = [];
    // public $hasMany = [];
    // public $hasOneThrough = [];
    // public $hasManyThrough = [];
    public $belongsTo = [
        'blocklist' => Blocklist::class,
    ];
    // public $belongsToMany = [];
    // public $morphTo = [];
    // public $morphOne = [];
    // public $morphMany = [];
    // public $attachOne = [];
    // public $attachMany = [];

    public function getDropdownOptions($field, $value, $form)
    {
        // \Log::debug($field);
        // \Log::debug(post('_repeater_group'));
        // \Log::debug(post('group'));
        // \Log::debug($value);

        if (isset($form->_group)) {
            // \Log::debug($form->_group);
            $group = $form->_group;
        } else {
            $group = post('_repeater_group');
        }

        $namespace = '\\' . str_replace('-', '\\', $group);
        $method = 'get' . ucfirst(camel_case($field)) . 'Options';
        // \Log::debug($method);
        // \Log::debug($namespace);

        // return \LaFetEnt\BlockExtender\Modules\VoodooTest\VoodooTest::getTextTestOptions($value, $form);

        if (method_exists($namespace, $method)) {
            return $namespace::$method($value, $form);
        }

        // if (PluginManager::instance()->exists('Xitara.VoodooBlocks') === true) {
        // }

        // if ($fieldName == 'status') {
        // return ['all' => 'All'];
        // } else {
        return ['' => '-- none --'];
        // }
    }
}
