<div class="mb-4 text-sm text-gray-600">
    <p> {{ __('Ticket with id ') . $ticket->id . __('change status to:') . $ticket->statuses->name }}</p>
    <a href="{{ route('tickets.index') }}">{{ __('show your all tickets!') }}</a><br>
    <a href="{{ route('tickets.show', $ticket->id) }}">{{ __('show your ticket!') }}</a>
</div>
