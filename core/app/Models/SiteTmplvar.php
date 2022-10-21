<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SiteTmplvar extends Model
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
        'locked' => 'int',
        'rank' => 'int',
        'createdon' => 'int',
        'editedon' => 'int',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'type',
        'name',
        'caption',
        'description',
        'editor_type',
        'category',
        'locked',
        'elements',
        'rank',
        'display',
        'display_params',
        'default_text',
        'properties',
    ];

    /**
     * @return BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category', 'id');
    }

    /**
     * @return HasMany
     */
    public function tmplvarUserRole(): HasMany
    {
        return $this->hasMany(UserRoleVar::class, 'tmplvarid', 'id');
    }

    /**
     * @return bool|null
     */
    public function delete(): ?bool
    {
        $this->tmplvarContentvalue()->delete();
        $this->tmplvarAccess()->delete();
        $this->tmplvarTemplate()->delete();

        return parent::delete();
    }

    /**
     * @return HasMany
     */
    public function tmplvarContentvalue(): HasMany
    {
        return $this->hasMany(SiteTmplvarContentvalue::class, 'tmplvarid', 'id');
    }

    /**
     * @return HasMany
     */
    public function tmplvarAccess(): HasMany
    {
        return $this->hasMany(SiteTmplvarAccess::class, 'tmplvarid', 'id');
    }

    /**
     * @return HasMany
     */
    public function tmplvarTemplate(): HasMany
    {
        return $this->hasMany(SiteTmplvarTemplate::class, 'tmplvarid', 'id');
    }
}
