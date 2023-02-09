<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class File extends Model
{
    use HasFactory, LogsActivity, PowerJoins;

    protected $fillable = [
        'ticket_id',
        'path',
        'name'
    ];

    public function ticket()
    {
        return $this->belongsTo('App\Models\Ticket');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['path'])
            ->useLogName('file');
        // Chain fluent methods for configuration options
    }
}