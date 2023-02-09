<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class CategoryTicket extends Pivot
{
    use HasFactory, LogsActivity, PowerJoins, SoftDeletes;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = true;
    protected $fillable = [
        'ticket_id', 'category_id'
    ];

    public function tickets()
    {
        return $this->belongsToMany('App\Models\Ticket');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['ticket_id', 'category_id'])
            ->useLogName('categoryTicket');
        // Chain fluent methods for configuration options
    }
}