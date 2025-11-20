@extends('layouts.app')

@section('title', 'TEAM — JAFFNA ICF')
@section('meta_description', 'Meet the team behind the Jaffna International Cinema Festival — director, consultants, advisory committee, management, coordinators, and festival team.')

@section('content')
	<section class="container-full py-16">
		<h1 class="section-title">Team</h1>

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
						The festival team for this edition will be announced soon. Please check back closer to the festival dates.
					</p>
				</div>
			</div>
		@else
		<div class="mt-10 grid gap-8">
			@isset($roleOrder, $groups)
				@foreach($roleOrder as $role => $heading)
					@php($members = $groups->get($role, collect()))
					@if($members->isNotEmpty())
						<div class="bg-white rounded-xl p-6 md:p-8 shadow-soft">
							<h2 class="text-2xl md:text-3xl font-bold">{{ $heading }}</h2>

							@if($role === 'Director' || $role === 'Manager')
								@foreach($members as $person)
									<div class="mt-4">
										<div class="text-lg font-semibold">{{ $person->name }}</div>
										@if($person->role)
										<div class="text-xs mt-1 inline-flex items-center gap-2">
											<span class="px-2 py-1 rounded bg-primary/10 text-primary uppercase tracking-wide">{{ $person->role }}</span>
										</div>
										@endif
									</div>
								@endforeach
							@elseif($role === 'Consultant')
								<div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
									@foreach($members as $person)
										<div class="p-4 rounded-lg border border-black/5 hover:shadow-soft transition">
											<div class="font-semibold">{{ $person->name }}</div>
											<div class="text-xs mt-1 text-dark/60 uppercase tracking-wide">Consultant</div>
										</div>
									@endforeach
								</div>
							@elseif($role === 'Advisory Committee')
								<ul class="mt-4 grid sm:grid-cols-2 lg:grid-cols-3 gap-3">
									@foreach($members as $person)
										<li>{{ $person->name }}</li>
									@endforeach
								</ul>
							@elseif($role === 'Festival Team')
								<ul class="mt-4 grid gap-2 sm:grid-cols-2 lg:grid-cols-3">
									@foreach($members as $person)
										<li class="p-3 rounded-lg border border-black/5">{{ $person->name }}</li>
									@endforeach
								</ul>
							@elseif($role === 'Coordinator — Colombo' || $role === 'Coordinator — Jaffna')
								@foreach($members as $person)
									<div class="mt-4 p-4 rounded-lg border border-black/5 w-full sm:w-auto">
										<div class="font-semibold">{{ $person->name }}</div>
										<div class="text-xs mt-1 text-dark/60 uppercase tracking-wide">{{ $person->role }}</div>
									</div>
								@endforeach
							@else
								@foreach($members as $person)
									<div class="mt-4 p-4 rounded-lg border border-black/5 w-full sm:w-auto font-medium">{{ $person->name }}</div>
								@endforeach
							@endif
						</div>
					@endif
				@endforeach
			@endisset
		</div>
		@endif
	</section>
@endsection


