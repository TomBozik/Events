@extends('layouts.main')

@section('content')
<div class="flex w-screen h-screen">
	<div class="mx-auto my-auto">
		<div class="flex flex-col">

			@if (session('msg'))
				<div class="font-semibold text-center text-red-500 uppercase">{{ session('msg') }}</div>
			@endif

			<a href="{{ route('events.create') }}">
				<button class="w-64 p-2 m-2 text-lg font-bold tracking-wide text-white uppercase bg-black rounded-sm hover:text-orange-500">Create Event</button>
			</a>

		</div>
	</div>
</div>
@endsection