<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
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
     * Get the user that owns the tag.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get the related worklog.
     */
    public function worklog()
    {
        return $this->belongsToMany(Worklog::class,'worklog_tag');
    }
}
