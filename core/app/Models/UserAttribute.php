<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $internalKey
 * @property string $fullname
 * @property string $middle_name
 * @property string $last_name
 * @property int $role
 * @property string $email
 * @property string $phone
 * @property string $mobilephone
 * @property int $verified
 * @property int $blocked
 * @property int $blockeduntil
 * @property int $blockedafter
 * @property int $logincount
 * @property int $lastlogin
 * @property int $thislogin
 * @property int $failedlogincount
 * @property string $sessionid
 * @property int $dob
 * @property int $gender
 * @property string $country
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $fax
 * @property string $photo
 * @property string $comment
 * @property int $createdon
 * @property int $editedon
 *
 * Virtual
 * @property-read Carbon $created_at
 * @property-read Carbon $updated_at
 */
class UserAttribute extends Model
{
    public const CREATED_AT = 'createdon';
    public const UPDATED_AT = 'editedon';

    /**
     * @var string
     */
    protected $dateFormat = 'U';

    /**
     * @var string[]
     */
    protected $casts = [
        'internalKey' => 'int',
        'role' => 'int',
        'verified' => 'int',
        'blocked' => 'int',
        'blockeduntil' => 'int',
        'blockedafter' => 'int',
        'logincount' => 'int',
        'lastlogin' => 'int',
        'thislogin' => 'int',
        'failedlogincount' => 'int',
        'dob' => 'int',
        'gender' => 'int',
        'createdon' => 'int',
        'editedon' => 'int',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'role',
    ];

    /**
     * @var int[]
     */
    protected $attributes = [
        'role' => 0,
        'verified' => 1,
    ];

    /**
     * @var string[]
     */
    protected $fillable = [
        'internalKey',
        'fullname',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'mobilephone',
        'verified',
        'blocked',
        'blockeduntil',
        'blockedafter',
        'logincount',
        'lastlogin',
        'thislogin',
        'failedlogincount',
        'sessionid',
        'dob',
        'gender',
        'country',
        'street',
        'city',
        'state',
        'zip',
        'fax',
        'photo',
        'comment',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'internalKey', 'id');
    }
}