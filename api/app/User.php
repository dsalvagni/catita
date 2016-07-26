<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Models as Models;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The user has many workLogs
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workLogs() {
        return $this->hasMany(Models\Worklog::class);
    }
    /**
     * The user may have tags
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags() {
        return $this->hasMany(Models\Tag::class);
    }
}
