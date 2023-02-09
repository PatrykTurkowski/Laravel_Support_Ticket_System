<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\RoleEnum;
use App\Models\Scopes\DeletedRowsScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kirschbaum\PowerJoins\PowerJoins;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, LogsActivity, PowerJoins, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function roles()
    {
        return [
            RoleEnum::ADMIN->value => RoleEnum::ADMIN->value,
            RoleEnum::AGENT->value => RoleEnum::AGENT->value,
            RoleEnum::USER->value => RoleEnum::USER->value,
        ];
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }


    public function tickets()
    {
        return $this->hasMany('App\Models\Ticket', 'assigned_agent_id');
    }
    public function creatorTickets()
    {
        return $this->hasMany('App\Models\Ticket', 'user_id');
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
            ->logOnly(['name', 'email', 'role'])
            ->useLogName('user');
        // Chain fluent methods for configuration options
    }
}