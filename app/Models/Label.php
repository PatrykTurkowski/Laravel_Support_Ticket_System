<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Label extends Model
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
     * The default labels
     *
     * @var array
     */
    const defaultLabels = [
        'bug',
        'question',
        'enhancement',
    ];

    public function tickets()
    {
        return $this->belongsToMany('App\Models\Ticket');
    }
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name'])
            ->useLogName('label');
        // Chain fluent methods for configuration options
    }
}