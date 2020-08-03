@extends('layouts.main')

@section('content')
<div class="bg-gray-100 custom-min-h-full custombg">
	<div class="container flex flex-col mx-auto custom-min-h-full">
		<div class="flex flex-col flex-1 bg-gray-100 md:flex-row">

			<persons-list :is-admin="{{ $isAdmin }}" :person-id="{{ $person->id }}" class="order-2 pt-2 md:pt-16 md:order-1"></persons-list>
			
			<div class="flex flex-col order-1 w-full pl-0 md:pl-16 md:order-2">
				<event-info :is-admin="{{ $isAdmin }}" class="pt-2"></event-info>
				<answers></answers>
				<calendar></calendar>
				<invitation-link url="{{ url('/events'. '/'. $event->code) }}" class="self-center hidden text-gray-600 md:block"></invitation-link>
			</div>

			<invitation-link url="{{ url('/events'. '/'. $event->code) }}" class="order-3 pt-2 text-gray-600 md:hidden"></invitation-link>

			
			@if (session('personCode'))
				<modal person-code="{{ session('personCode') }}"></modal>
			@endif
			
		</div>
	</div>
</div>
@endsection