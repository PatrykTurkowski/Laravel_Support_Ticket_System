<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Kirschbaum\PowerJoins\PowerJoins;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use HasFactory, LogsActivity, PowerJoins, SoftDeletes;


    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'priority_id',
        'status_id',
        'agent_id',
        'user_id',


    ];

    public function getActivitylogOptions(): LogOptions
    {

        return LogOptions::defaults()
            ->logOnly(['title', 'description', 'agent_id', 'User_id', 'statuses.name', 'priorities.name'])
            ->useLogName('ticket');
        // Chain fluent methods for configuration options
    }


    public function files()
    {
        return $this->hasMany('App\Models\File');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
    public function ticketUser()
    {
        return $this->hasManyThrough(Comment::class, User::class);
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
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
    public function checkCategories()
    {
        return $this->categories()->pluck('categories.id');
    }
    public function checkLabels()
    {
        return $this->labels()->pluck('labels.id');
    }
    public function category_id()
    {
        return $this->belongsToMany('App\Models\Category');
    }



    public function labels()
    {
        return $this->belongsToMany('App\Models\Label');
    }
    public function label_id()
    {
        return $this->belongsToMany('App\Models\Label');
    }



    public function creator()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function addFiles($request)
    {
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {

                $this->files()->create([
                    'name' => $file->getClientOriginalName(),
                    'path' => 'files/' . $file->hashname(),
                    'ticket_id' => $this->id
                ]);
                Storage::disk('s3')->put('files', $file);
            }
        }
    }
    public function categoryTicketTest()
    {
        // return $this->hasMany('App\Models\CategoryTicket');
        return $this->hasMany('App\Models\CategoryTicket', 'ticket_id');
    }
    public function categoryTicket()
    {
        // return $this->hasMany('App\Models\CategoryTicket');
        return $this->hasMany('App\Models\CategoryTicket');
    }
    public function categoryTicketLog(array $categories)
    {

        foreach ($categories as $category) {
            $new = new CategoryTicket(['ticket_id' => $this->id, 'category_id' => $category]);
            $new->save();
        }
    }
    public function labelTicketLog(array $labels)
    {

        foreach ($labels as $label) {
            $new = new LabelTicket(['ticket_id' => $this->id, 'label_id' => $label]);
            $new->save();
        }
    }
}
