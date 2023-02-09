<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Http\Requests\Status\UpdateStatusRequest;
use App\Mail\notification\ChangeStatus;
use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use ProtoneMedia\Splade\Facades\Toast;

class TicketStatusController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateStatusRequest  $request
     * @param  Ticket $ticket
     * @return RedirectResponse
     */
    public function __invoke(UpdateStatusRequest $request, Ticket $ticket): RedirectResponse
    {
        if (auth()->user()->role == RoleEnum::USER->value) {
            abort('403');
        }
        $ticket->update([
            'status_id' => $request->input('status_id')
        ]);
        $ticket->save();

        Mail::to($ticket->assignedAgent)->send(new ChangeStatus($ticket));
        Mail::to($ticket->users)->send(new ChangeStatus($ticket));
        $admins = User::where('role', RoleEnum::ADMIN->value)->get();

        foreach ($admins as $admin) {
            Mail::to($admin)->send(new ChangeStatus($ticket));
        }

        Toast::title(__('You Updated Status!'))
            ->leftTop()
            ->autoDismiss(10);
        return redirect()->route('tickets.index');
    }
}