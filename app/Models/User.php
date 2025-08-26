<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'user_name',
        'user_email',
        'password',
        'user_mobile_no',
        'user_type',
        'user_status',
        'parent_id',
        'activation_token',
    ];

    protected $hidden = [
        'password',
        'activation_token',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'user_email';
    }

    // password mutator (auto-hash)
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }
    }

    public function subUsers(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id', 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id', 'user_id');
    }

    public function isAdmin(): bool
    {
        return $this->user_type === 'admin';
    }

    public function isSubUser(): bool
    {
        return $this->user_type === 'sub_user';
    }

     public function getRememberToken() { return null; }
    public function setRememberToken($value) {}
    public function getRememberTokenName() { return null; }
}