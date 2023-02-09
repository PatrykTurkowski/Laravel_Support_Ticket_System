<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Priority extends Model
{
    use HasFactory, LogsActivity, PowerJoins, SoftDeletes;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
    ];
    /**
     * The default priorities
     *
     * @var array
     */
    const defaultPriorities = [
        'high',
        'midium',
        'low'
    ];

    public function tickets()
    {
        return $this->hasMany('App\Models\Priority', 'priority_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'text'])
            ->useLogName('priority');
        // Chain fluent methods for configuration options
    }
}