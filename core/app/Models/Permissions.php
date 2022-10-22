<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Permissions extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'name',
        'key',
        'lang_key',
        'group_id',
        'disabled',
    ];

    /**
     * @return HasOne
     */
    public function attributes(): HasOne
    {
        return $this->hasOne(PermissionsGroups::class, 'id', 'group_id');
    }

    /**
     * @return HasOne
     */
    public function rolePermissions(): HasOne
    {
        return $this->hasOne(RolePermissions::class, 'permission', 'key');
    }
}
