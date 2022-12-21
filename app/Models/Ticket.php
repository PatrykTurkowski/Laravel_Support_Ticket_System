<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use HasFactory, LogsActivity;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'file',
        'priority_id',
        'status_id',
        'agent_id',
        'user_id',


    ];

    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    public function priorities()
    {
        return $this->belongsTo('App\Models\Priority', 'priority_id');
    }
    public function statuses()
    {
        return $this->belongsTo('App\Models\Status', 'status_id');
    }

    public function assignedAgent()
    {
        return $this->belongsTo('App\Models\User', 'assigned_agent_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function labels()
    {
        return $this->belongsToMany('App\Models\Label');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text']);
        // Chain fluent methods for configuration options
    }

    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}