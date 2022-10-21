<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionsGroups extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'lang_key',
    ];

    /**
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permissions::class, 'group_id', 'id');
    }
}
