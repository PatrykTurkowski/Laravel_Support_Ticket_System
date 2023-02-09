<?php

namespace App\Observers;

use App\Models\Category;
use ProtoneMedia\Splade\Facades\Toast;

class CategoryObserver
{
    /**
     * Handle the Category "created" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        Toast::title(__('You created Category!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Category "updated" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        if (array_key_exists('deleted_at', $category->getChanges())) {
            return;
        }
        Toast::title(__('You updated Category!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Category "deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        Toast::title(__('You deleted Category!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Category "restored" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        Toast::title(__('You restored Category!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Category "force deleted" event.
     *
     * @param  \App\Models\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        Toast::title(__('You pernamently deleted Category!'))
            ->leftTop()
            ->autoDismiss(10);
    }
}