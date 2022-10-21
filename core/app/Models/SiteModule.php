<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteModule extends Model
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
        'disabled' => 'int',
        'category' => 'int',
        'wrap' => 'int',
        'locked' => 'int',
        'enable_resource' => 'int',
        'createdon' => 'int',
        'editedon' => 'int',
        'enable_sharedparams' => 'int',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'editor_type',
        'disabled',
        'category',
        'wrap',
        'locked',
        'icon',
        'enable_resource',
        'resourcefile',
        'guid',
        'enable_sharedparams',
        'properties',
        'modulecode',
    ];

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }
}
