@extends('layouts.app')

@section('title', 'Team ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Meet the team from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.team"
			:routeParams="['year' => $year]"
		/>

		@if($groups->isEmpty())
			<div class="mt-10 bg-white rounded-xl p-6 md:p-10 shadow-soft text-center">
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">No Team Data Available</h2>
				<p class="mt-3 text-dark/70 max-w-xl mx-auto">
					Team information for {{ $year }} is not available in the archive
				</p>
			</div>
		@else
			<div class="mt-10 grid gap-8">
				@php
					// Get all roles from groups (including those not in roleOrder)
					$allRoles = $groups->keys();
					// Merge with roleOrder to maintain order, then add any missing roles
					$displayRoles = collect($roleOrder ?? [])->keys()->merge($allRoles)->unique();
				@endphp
				
				@foreach($displayRoles as $role)
					@php($members = $groups->get($role, collect()))
					@if($members->isNotEmpty())
						<div class="bg-white rounded-xl p-6 md:p-8 shadow-soft">
							@if(isset($roleOrder[$role]))
								<h2 class="text-2xl md:text-3xl font-bold">{{ $roleOrder[$role] }}</h2>
							@else
								<h2 class="text-2xl md:text-3xl font-bold uppercase tracking-wide">{{ $role }}</h2>
							@endif

							<div class="mt-6 grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
								@foreach($members as $person)
									<div class="p-4 rounded-lg border border-black/5 hover:shadow-soft transition">
										<div class="font-semibold break-words">{{ $person->name }}</div>
									</div>
								@endforeach
							</div>
						</div>
					@endif
				@endforeach
			</div>
		@endif
	</section>
@endsection

