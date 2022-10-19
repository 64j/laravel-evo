<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTemplate extends Model
{
    const CREATED_AT = 'createdon';
    const UPDATED_AT = 'editedon';

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @var string[]
     */
    protected $casts = [
        'editor_type' => 'int',
        'category' => 'int',
        'template_type' => 'int',
        'locked' => 'int',
        'selectable' => 'int',
        'createdon' => 'int',
        'editedon' => 'int'
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'templatename',
        'templatealias',
        'description',
        'editor_type',
        'category',
        'icon',
        'template_type',
        'content',
        'locked',
        'selectable'
    ];
}
