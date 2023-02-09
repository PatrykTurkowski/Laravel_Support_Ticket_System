<?php

namespace App\Observers;

use App\Enums\RoleEnum;
use App\Models\User;
use ProtoneMedia\Splade\Facades\Toast;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        if ($user->role == RoleEnum::ADMIN->value)
            Toast::title(__('You Added new User!'))
                ->leftTop()
                ->autoDismiss(10);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if (array_key_exists('deleted_at', $user->getChanges()) || array_key_exists('remember_token', $user->getChanges())) {
            return;
        }
        Toast::title(__('You Edited User!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {

        Toast::title(__('You delete User!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        Toast::title(__('You restore User!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        Toast::title(__('You definitly deleted User!'))
            ->leftTop()
            ->autoDismiss(10);
    }
}