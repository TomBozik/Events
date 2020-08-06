@component('mail::message')
# {{ $event->name }}

Your Code: **{{ $personalCode }}**
@component('mail::button', ['url' => url('/login'. '/'. $event->code) ])
Event Login Page
@endcomponent

@endcomponent
