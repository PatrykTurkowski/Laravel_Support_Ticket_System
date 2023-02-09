<?php

namespace App\Observers;

use App\Models\Comment;
use ProtoneMedia\Splade\Facades\Toast;

class CommentObserver
{
    /**
     * Handle the Comment "created" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        Toast::title(__('You Created new comment!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Comment "updated" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function updated(Comment $comment)
    {
        Toast::title(__('You Updated comment!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Comment "deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function deleted(Comment $comment)
    {
        Toast::title(__('You deleted comment!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Comment "restored" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function restored(Comment $comment)
    {
        Toast::title(__('You restored comment!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Comment "force deleted" event.
     *
     * @param  \App\Models\Comment  $comment
     * @return void
     */
    public function forceDeleted(Comment $comment)
    {
        Toast::title(__('You forceDeleted comment!'))
            ->leftTop()
            ->autoDismiss(10);
    }
}