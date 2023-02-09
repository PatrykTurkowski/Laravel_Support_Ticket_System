<?php

namespace App\Observers;

use App\Mail\notification\AddAgent;
use App\Mail\notification\NewTicket;
use App\Mail\notification\NewTicketUser;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use ProtoneMedia\Splade\Facades\Toast;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {

        Mail::to(env('MAIL_FROM_ADDRESS'))->send(new NewTicket($ticket));
        Mail::to($ticket->users->email)->send(new NewTicketUser($ticket));
        Toast::title(__('You Created new tictet!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {


        if (array_key_exists('deleted_at', $ticket->getChanges()) || array_key_exists('status_id', $ticket->getChanges())) {
            return;
        }

        if (array_key_exists('assigned_agent_id', $ticket->getChanges())) {
            $agent = User::find($ticket->assigned_agent_id);
            Mail::to($agent)->send(new AddAgent($ticket));
        }

        Toast::title(__('You Updated ticket!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        Toast::title(__('You delete user!'))
            ->leftTop()
            ->autoDismiss(10);
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}