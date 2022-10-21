<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string[]
     */
    protected $casts = [
        'rank' => 'int',
        'category' => 'string',
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'category',
        'rank',
    ];

    /**
     * @return HasMany
     */
    public function templates(): HasMany
    {
        return $this->hasMany(SiteTemplate::class, 'category', 'id')->orderBy('templatename', 'ASC');
    }

    /**
     * @return HasMany
     */
    public function chunks(): HasMany
    {
        return $this->hasMany(SiteHtmlsnippet::class, 'category', 'id')->orderBy('name', 'ASC');
    }

    /**
     * @return HasMany
     */
    public function snippets(): HasMany
    {
        return $this->hasMany(SiteSnippet::class, 'category', 'id')->orderBy('name', 'ASC');
    }

    /**
     * @return HasMany
     */
    public function plugins(): HasMany
    {
        return $this->hasMany(SitePlugin::class, 'category', 'id')->orderBy('name', 'ASC');
    }

    /**
     * @return HasMany
     */
    public function modules(): HasMany
    {
        return $this->hasMany(SiteModule::class, 'category', 'id')->orderBy('name', 'ASC');
    }

    /**
     * @return HasMany
     */
    public function tvs(): HasMany
    {
        return $this->hasMany(SiteTmplvar::class, 'category', 'id')->orderBy('name', 'ASC');
    }
}
