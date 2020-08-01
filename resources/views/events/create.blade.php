@extends('layouts.main')

@section('content')
<div class="flex flex-col w-screen h-screen custombg">
	<div class="w-full max-w-xl mx-auto my-auto sm:w-1/2">
		<form class="w-full px-2" method="POST" action="{{ route('events.store') }}">
			@csrf
			<div class="pt-6 pb-1 border-b border-b-2 focus-within:border-gray-900">
				<input class="w-full font-semibold tracking-wider text-gray-900 bg-transparent appearance-none focus:outline-none" type="text" placeholder="EVENT NAME" value="{{ old('event_name') }}" name="event_name" aria-label="event_name" />
			</div>
			@error('event_name')
				<p class="text-xs font-semibold text-red-500">{{ $message }}</p>
			@enderror

			<div class="pt-6 pb-1 border-b border-b-2 focus-within:border-gray-900">
				<input class="w-full font-semibold tracking-wider text-gray-900 bg-transparent appearance-none focus:outline-none" type="text" autocomplete="off" placeholder="EVENT PASSWORD" value="{{ old('event_password') }}" name="event_password" aria-label="event_password" />
			</div>
			@error('event_password')
				<p class="text-xs font-semibold text-red-500">{{ $message }}</p>
			@enderror

			<div class="pt-10 pb-1 border-b border-b-2 focus-within:border-gray-900">
				<input class="w-full font-semibold tracking-wider text-gray-900 bg-transparent appearance-none focus:outline-none" type="text" placeholder="YOUR NAME" value="{{ old('person_name') }}" name="person_name" aria-label="person_name" />
			</div>
			@error('person_name')
				<p class="text-xs font-semibold text-red-500">{{ $message }}</p>
			@enderror

			<div class="pt-6 pb-1 border-b border-b-2 focus-within:border-gray-900">
				<input class="w-full font-semibold tracking-wider text-gray-900 bg-transparent appearance-none focus:outline-none" type="text" placeholder="EMAIL (optional)" value="{{ old('email') }}" name="email" aria-label="email" />
			</div>
			@error('email')
				<p class="text-xs font-semibold text-red-500">{{ $message }}</p>
			@enderror

			<button type="submit" class="w-full p-2 mt-10 text-lg font-bold tracking-wide text-white uppercase bg-black rounded-sm hover:text-orange-500">Create Event</button>
		</form>
	</div>

	<div class="max-w-4xl pb-2 mx-auto text-xs text-center text-gray-600 uppercase">
		Email is optional but we strongly recommend filling it out. A <span class="font-semibold">code is sent to the email </span> with which you can log in to this event. This code <span class="font-semibold">will be displayed only once </span> after registration.
	</div>
	
</div>
@endsection