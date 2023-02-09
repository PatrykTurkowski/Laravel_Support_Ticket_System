<div class="mb-4 text-sm text-gray-600">
    <p> {{ __('Its a new ticket with id') . $ticket->id }}</p>
    <a href="{{ route('tickets.show', $ticket->id) }}">{{ __('Add agent to This ticket') }}</a>
</div>
