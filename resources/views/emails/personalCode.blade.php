@component('mail::message')
# {{ $event->name }}

Your Code: **{{ $personalCode }}**
@component('mail::button', ['url' => url('/events'. '/'. $event->code) ])
Event Login Page
@endcomponent

@endcomponent
