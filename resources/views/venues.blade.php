@extends('layouts.app')

@section('title', 'VENUES — JAFFNA ICF')
@section('meta_description', 'Festival venues in Jaffna including cinemas, auditoriums and cultural centres.')

@section('content')
	<section class="container-full py-16">
		<h1 class="section-title">Venues</h1>
		<p class="mt-4 text-dark/70 max-w-2xl">Screenings and events take place across several venues in Jaffna.</p>

		@if(!empty($inactive))
			<div class="mt-10 relative overflow-hidden bg-gradient-to-br from-dark via-dark/95 to-dark/90 rounded-2xl p-8 md:p-16 shadow-2xl text-center border border-primary/20" data-aos="fade-up">
				<div class="absolute inset-0 opacity-5">
					<div class="absolute inset-0" style="background-image: radial-gradient(circle at 2px 2px, rgba(197, 80, 44, 0.3) 1px, transparent 0); background-size: 40px 40px;"></div>
				</div>
				<div class="relative z-10">
					<div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 mb-6 rounded-full bg-primary/10 border-2 border-primary/30">
						<svg class="w-10 h-10 md:w-12 md:h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
						</svg>
					</div>
					<h2 class="text-3xl md:text-5xl lg:text-6xl font-display font-bold tracking-tighter text-white mb-4 uppercase">
						TO BE ANNOUNCED
					</h2>
					<div class="w-24 h-0.5 bg-primary mx-auto mb-6"></div>
					<p class="text-base md:text-lg text-white/80 max-w-2xl mx-auto leading-relaxed">
						Festival venue details for this edition will be announced soon. Please check back closer to the festival dates.
					</p>
				</div>
			</div>
		@else
			<div class="mt-10 grid gap-8 lg:grid-cols-2">
				@forelse($venues as $venue)
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
				@empty
					<p class="text-dark/70">Venues will appear here once configured in the admin panel.</p>
				@endforelse
			</div>
		@endif
	</section>
@endsection


