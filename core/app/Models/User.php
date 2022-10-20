<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $hidden = [
        'password',
        'cachepwd',
        'verified_key',
    ];

    protected $fillable = [
        'username',
        'password',
        'cachepwd',
        'verified_key',
        'refresh_token',
        'access_token',
        'valid_to',
    ];

    public function attributes()
    {
        return $this->hasOne(UserAttribute::class, 'internalKey', 'id');
    }

    public function memberGroups()
    {
        return $this->hasMany(MemberGroup::class, 'member', 'id');
    }

    public function settings()
    {
        return $this->hasMany(UserSetting::class, 'user', 'id');
    }

    public function values()
    {
        return $this->hasMany(UserValue::class, 'userid', 'id');
    }

    public function delete()
    {
        $this->memberGroups()->delete();
        $this->attributes()->delete();
        $this->settings()->delete();

        return parent::delete();
    }
}
