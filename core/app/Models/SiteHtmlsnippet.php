<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SiteHtmlsnippet extends Model
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
        'cache_type' => 'bool',
        'locked' => 'int',
        'createdon' => 'int',
        'editedon' => 'int',
        'disabled' => 'int',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description',
        'editor_type',
        'editor_name',
        'category',
        'cache_type',
        'snippet',
        'locked',
        'disabled',
    ];

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }
}
