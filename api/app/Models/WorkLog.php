<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
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
        return $this->belongsTo(\App\User::class);
    }
}
