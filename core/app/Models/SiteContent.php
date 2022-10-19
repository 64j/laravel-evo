<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteContent extends Model
{
    public const CREATED_AT = 'createdon';
    public const UPDATED_AT = 'editedon';

    /**
     * @var string
     */
    protected $table = 'site_content';

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array|string[]
     */
    protected $casts = [
        'published' => 'int',
        'pub_date' => 'int',
        'unpub_date' => 'int',
        'parent' => 'int',
        'isfolder' => 'int',
        'richtext' => 'bool',
        'template' => 'int',
        'menuindex' => 'int',
        'searchable' => 'int',
        'cacheable' => 'int',
        'createdby' => 'int',
        'createdon' => 'int',
        'editedby' => 'int',
        'editedon' => 'int',
        'deleted' => 'int',
        'deletedby' => 'int',
        'publishedon' => 'int',
        'publishedby' => 'int',
        'hide_from_tree' => 'bool',
        'privateweb' => 'bool',
        'privatemgr' => 'bool',
        'content_dispo' => 'bool',
        'hidemenu' => 'bool',
        'alias_visible' => 'int',
    ];
}
