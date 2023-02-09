<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {

        if (auth()->user()->role != RoleEnum::ADMIN->value) {
            return redirect()->route('tickets.index');
        }
        $user = User::where('role', RoleEnum::USER->value)->count();
        $agent = User::where('role', RoleEnum::AGENT->value)->count();
        $ticket = Ticket::with('statuses')->get();
        $countTicket = $ticket->count();
        $closed = $ticket->where('statuses.name', 'closed')->count();
        $open = $ticket->where('statuses.name', 'open')->count();
        $suspended = $ticket->where('statuses.name', 'suspended')->count();

        return view('dashboard', compact('user', 'suspended', 'open', 'closed', 'countTicket', 'agent'));
    }
}