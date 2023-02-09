<?php

namespace App\Observers;

use App\Models\Label;
use ProtoneMedia\Splade\Facades\Toast;

class LabelObserver
{
    /**
     * Handle the Label "created" event.
     *
     * @param  \App\Models\Label  $label
     * @return void
     */
    public function created(Label $label)
    {
        Toast::title(__('You Added new label!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Label "updated" event.
     *
     * @param  \App\Models\Label  $label
     * @return void
     */
    public function updated(Label $label)
    {
        if (array_key_exists('deleted_at', $label->getChanges())) {
            return;
        }
        Toast::title(__('You Edited Label!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Label "deleted" event.
     *
     * @param  \App\Models\Label  $label
     * @return void
     */
    public function deleted(Label $label)
    {
        Toast::title(__('You deleted Label!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Label "restored" event.
     *
     * @param  \App\Models\Label  $label
     * @return void
     */
    public function restored(Label $label)
    {
        Toast::title(__('You restored Label!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Label "force deleted" event.
     *
     * @param  \App\Models\Label  $label
     * @return void
     */
    public function forceDeleted(Label $label)
    {
        Toast::title(__('You deleted pernamently Label!'))
            ->leftTop()
            ->autoDismiss(10);
    }
}