<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, SoftDeletes;

    protected $api_token;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'deleted_at'
    ];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The user has many workLogs
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function workLogs() {
        return $this->hasMany(Worklog::class);
    }
    /**
     * The user may have tags
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags() {
        return $this->hasMany(Tag::class);
    }
    /**
     * The user may many sessions
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions() {
        return $this->hasMany(UserSession::class);
    }

    public function getApiToken() {
        return $this->api_token;
    }

    public function setApiToken($token) {
        $this->api_token = $token;
    }
}
