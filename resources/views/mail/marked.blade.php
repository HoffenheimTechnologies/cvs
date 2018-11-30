@component('mail::message')
# Attendance Marked Notice

The attendance for # {{$event->event_edate}} has been marked successfully.

Attendance: {{ $attendance->attendance ? 'Attending' : 'Not Attending' }}

@component('mail::button', ['url' => $url])
View History
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
