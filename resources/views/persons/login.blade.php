@extends('layouts.main')

@section('content')
<div class="flex w-screen h-screen">
    <div class="w-full max-w-xl mx-auto my-auto sm:w-1/2">
        <div class="text-sm tracking-tight text-center">
            ENTER EVENT <span class="text-lg font-bold tracking-wide uppercase">{{ $event->name }}</span>
        </div>
        
		<form class="w-full px-2" method="POST" action="{{ route('persons.login') }}">
            @csrf

            <input type="hidden" type="text" name="event_id" value="{{ $event->id }}">

			<div class="pt-10 pb-1 border-b border-b-2 focus-within:border-gray-900">
				<input class="w-full font-semibold tracking-wider text-gray-900 bg-transparent appearance-none focus:outline-none" type="text" placeholder="YOUR CODE" name="code" aria-label="code" />
			</div>
			@error('code')
				<p class="text-xs font-semibold text-red-500">{{ $message }}</p>
            @enderror

			<button type="submit" class="w-full p-2 mt-10 text-lg font-bold tracking-wide text-white uppercase bg-black rounded-sm hover:text-orange-500">Enter Event</button>
        </form>

        <div class="pt-4 text-center">or</div>
        
        <a href="{{ route('events.show', $event->code) }}">
            <div class="pt-4 text-sm font-semibold text-center uppercase hover:text-orange-500">Register to event</div>
        </a>

	</div>
</div>
@endsection