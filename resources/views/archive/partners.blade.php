@extends('layouts.app')

@section('title', 'Partners ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Partners and sponsors from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-12 md:py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.partners"
			:routeParams="['year' => $year]"
		/>

		@if($categories->isEmpty())
			<div class="mt-10 bg-white rounded-xl p-6 md:p-10 shadow-soft text-center">
				<h2 class="text-2xl md:text-3xl font-bold tracking-tight">No Partners Data Available</h2>
				<p class="mt-3 text-dark/70 max-w-xl mx-auto">
					Partner information for {{ $year }} is not available in the archive.
				</p>
			</div>
		@else
			<p class="text-lg text-dark/80 mb-8 md:mb-12 max-w-3xl" data-aos="fade-up" data-aos-delay="100">
				We are grateful to our partners and sponsors who supported the {{ $year }} edition of the Jaffna International Cinema Festival.
			</p>

			@forelse($categories as $category)
				@if($category->partners->isNotEmpty())
					<div class="mb-12 md:mb-16" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
						<h2 class="text-xl md:text-2xl lg:text-3xl font-display font-bold mb-4 md:mb-6 text-primary">{{ $category->name }}</h2>
						<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 md:gap-6 items-center">
							@foreach($category->partners as $partner)
								<div class="bg-white rounded-lg p-3 sm:p-4 flex items-center justify-center h-24 sm:h-28 md:h-32 hover:shadow-lg transition-shadow">
									@if($partner->logo_path)
										@if($partner->url)
											<a href="{{ $partner->url }}" target="_blank" rel="noopener" class="block w-full h-full flex items-center justify-center">
												<img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-16 sm:max-h-[72px] md:max-h-20 max-w-full object-contain" />
											</a>
										@else
											<img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-16 sm:max-h-[72px] md:max-h-20 max-w-full object-contain" />
										@endif
									@else
										<span class="text-dark/50 text-xs sm:text-sm text-center px-2">{{ $partner->name }}</span>
									@endif
								</div>
							@endforeach
						</div>
					</div>
				@endif
			@empty
				<div class="text-center py-12 md:py-16" data-aos="fade-up">
					<p class="text-dark/70 text-base md:text-lg">Partner information will be displayed here.</p>
				</div>
			@endforelse
		@endif
	</section>
@endsection

