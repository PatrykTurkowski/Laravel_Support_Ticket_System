<div class="mb-4 text-sm text-gray-600">
    <p> {{ __('Its a new ticket with id') . $ticket->id }}</p>
    <a href="{{ route('tickets.index') }}">{{ __('show your all tickets!') }}</a><br>
    <a href="{{ route('tickets.edit', $ticket->id) }}">{{ __('show your ticket!') }}</a>
</div>
