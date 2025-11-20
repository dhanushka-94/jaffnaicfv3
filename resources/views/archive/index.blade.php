@extends('layouts.app')

@section('title', 'Archive — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Browse archived content from past editions of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<div class="mb-8 md:mb-12" data-aos="fade-up">
			<h1 class="section-title">Archive</h1>
			<p class="mt-4 text-lg text-dark/80 max-w-3xl">
				Browse content from past editions of the Jaffna International Cinema Festival.
			</p>
		</div>

		@if(empty($availableYears) || count($availableYears) === 0)
			<div class="mt-10 bg-white rounded-xl p-6 md:p-10 shadow-soft text-center">
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">No Archive Available</h2>
				<p class="mt-3 text-dark/70 max-w-xl mx-auto">
					Archive content will be available once past editions are archived.
				</p>
			</div>
		@else
			@php
				// Filter out current year and ensure all years are integers
				$archiveYears = collect($availableYears)
					->map(fn($y) => (int) $y)
					->filter(fn($y) => $y !== (int) $currentYear)
					->sortDesc()
					->values();
			@endphp
			
			@if($archiveYears->isEmpty())
				<div class="mt-10 bg-white rounded-xl p-6 md:p-10 shadow-soft text-center">
					<h2 class="text-2xl md:text-3xl font-bold tracking-tight">No Archive Available</h2>
					<p class="mt-3 text-dark/70 max-w-xl mx-auto">
						Archive content will be available once past editions are archived.
					</p>
				</div>
			@else
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="100">
					@foreach($archiveYears as $archiveYear)
						<a href="{{ route('archive.year', $archiveYear) }}" class="bg-white rounded-xl p-6 shadow-soft hover:shadow-lg transition-shadow">
							<h2 class="text-2xl font-display font-bold text-primary mb-2">{{ $archiveYear }}</h2>
							<p class="text-dark/70 text-sm">View archived content from {{ $archiveYear }}</p>
						</a>
					@endforeach
				</div>
			@endif
		@endif
	</section>
@endsection

