<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\User;
use App\Observers\CategoryObserver;
use App\Observers\CommentObserver;
use App\Observers\LabelObserver;
use App\Observers\TicketObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        User::observe(UserObserver::class);
        Label::observe(LabelObserver::class);
        Category::observe(CategoryObserver::class);
        Ticket::observe(TicketObserver::class);
        Comment::observe(CommentObserver::class);





        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}