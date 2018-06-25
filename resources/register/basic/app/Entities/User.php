<?php

namespace App\Entities;

use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NF\Roles\Contracts\HasRoleAndPermission as HasRoleAndPermissionContract;
use NF\Roles\Traits\HasRoleAndPermission;
use Prettus\Repository\Traits\TransformableTrait;

class User extends Authenticatable implements HasRoleAndPermissionContract, CanResetPassword
{
    use Notifiable;
    use TransformableTrait;
    use HasRoleAndPermission;
    use CanResetPasswordTrait;

    const STATUS_ACTIVE  = 1;
    const STATUS_PENDING = 0;

    const EMAIL_VERIFIED     = 1;
    const EMAIL_NOT_VERIFIED = 0;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'birth',
        'phone_area_code',
        'phone_number',
        'address',
        'avatar',
        'gender',
        'description',
        'account_type',
        'social_id',
        'order',
    ];
}
