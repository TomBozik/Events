@extends('layouts.main')

@section('content')
<div class="bg-gray-100">
	<div class="container flex flex-col h-screen mx-auto">
		<div class="flex flex-col flex-1 bg-gray-100 md:overflow-y-hidden md:flex-row">

			<persons-list :is-admin="{{ $isAdmin }}" class="order-2 pt-4 md:pt-16 md:order-1 md:overflow-y-auto"></persons-list>
			
			<div class="flex flex-col order-1 w-full pl-0 md:pl-16 md:order-2 md:overflow-y-auto">
				<event-info :is-admin="{{ $isAdmin }}" class="pt-4"></event-info>
				<answers></answers>
				KRASNY KALENDAR
			</div>

			@if (session('personCode'))
				<modal person-code="{{ session('personCode') }}"></modal>
			@endif
			
		</div>
	</div>
</div>
@endsection