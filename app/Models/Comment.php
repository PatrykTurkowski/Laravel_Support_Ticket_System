<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Comment extends Model
{
    use HasFactory, LogsActivity, PowerJoins, SoftDeletes;

    protected $fillable = [
        'content',
        'ticket_id',
        'user_id',

    ];

    public function tickets()
    {
        return $this->belongsTo('App\Models\Ticket');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['content'])
            ->useLogName('comment');
        // Chain fluent methods for configuration options
    }
}