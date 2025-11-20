@extends('layouts.app')

@section('title', 'Venues ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Festival venues from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.venues"
			:routeParams="['year' => $year]"
		/>

		@if($venues->isEmpty())
			<div class="mt-10 bg-white rounded-xl p-6 md:p-10 shadow-soft text-center">
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">No Venues Data Available</h2>
				<p class="mt-3 text-dark/70 max-w-xl mx-auto">
					Venue information for {{ $year }} is not available in the archive.
				</p>
			</div>
		@else
			<p class="mt-4 text-dark/70 max-w-2xl">Screenings and events took place across several venues in Jaffna during {{ $year }}.</p>
			<div class="mt-10 grid gap-8 lg:grid-cols-2">
				@foreach($venues as $venue)
					<div class="bg-white rounded-xl p-6 shadow-soft">
						<h3 class="text-xl font-semibold">{{ $venue->name }}</h3>
						@if($venue->address)
							<div class="mt-2 text-dark/80 leading-relaxed">
								{!! nl2br(e($venue->address)) !!}
							</div>
						@endif
						@if($venue->contacts)
							<div class="mt-1 text-dark/80 leading-relaxed">
								{{ $venue->contacts }}
							</div>
						@endif
						@if($venue->map_iframe)
							<div class="mt-4 map-embed rounded-lg overflow-hidden">
								{!! $venue->map_iframe !!}
							</div>
						@endif
					</div>
				@endforeach
			</div>
		@endif
	</section>
@endsection

