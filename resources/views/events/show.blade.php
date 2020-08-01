@extends('layouts.main')

@section('content')
<div class="min-h-screen bg-gray-100 custombg">
	<div class="container flex flex-col mx-auto">
		<div class="flex flex-col flex-1 bg-gray-100 md:flex-row">

			<persons-list :is-admin="{{ $isAdmin }}" :person-id="{{ $person->id }}" class="order-2 pt-4 md:pt-16 md:order-1"></persons-list>
			
			<div class="flex flex-col order-1 w-full pl-0 md:pl-16 md:order-2">
				<event-info :is-admin="{{ $isAdmin }}" url="{{ url('/events'. '/'. $event->code) }}" class="pt-2"></event-info>
				<answers></answers>
				<calendar></calendar>
			</div>
			@if (session('personCode'))
				<modal person-code="{{ session('personCode') }}"></modal>
			@endif
			
		</div>
	</div>
</div>
@endsection