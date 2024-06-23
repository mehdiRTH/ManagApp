<x-mail::message>
# Introduction


<div>
    @if ($event == 'created')
        You have a meeting with {{ $meeting->responsible->name }} at {{ $meeting->start_date }}.
    @elseif ($event == 'updated')
        Update: You have a meeting with {{ $meeting->responsible->name }} at {{ $meeting->start_date }}.
    @else
        Your meeting with {{ $meeting->responsible->name }} at {{ $meeting->start_date }} has been canceled.
    @endif
</div>

<x-mail::button :url="route('meetings.show',$meeting)">
More Information
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
