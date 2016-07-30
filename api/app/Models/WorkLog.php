<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Worklog extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'description', 'started_at', 'finished_at'
    ];

    /**
     * Get the user that owns the worklog.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The worklog may have many tags
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class,'worklog_tag');
    }
}