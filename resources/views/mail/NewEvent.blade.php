<div>
    Attendance: {{ $attendance->attendance ? 'Present' : 'Absent' }}
    Event Date: {{$event->event_edate}}

    @component('mail::button', ['url' => $url, 'color' => 'success'])
    @component('mail::button', ['url' => $url, 'color' => 'danger'])
    Mark
    @endcomponent
</div>
