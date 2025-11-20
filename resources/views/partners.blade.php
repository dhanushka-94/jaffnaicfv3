@extends('layouts.app')

@section('title', 'Partners - ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Our partners and sponsors who make the Jaffna International Cinema Festival possible.')

@section('content')
	<section class="container-full py-12 md:py-16">
		<h1 class="section-title mb-6 md:mb-8" data-aos="fade-up">Our Partners</h1>

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
						Our partners and sponsors for this edition will be announced soon. Please check back closer to the festival dates.
					</p>
				</div>
			</div>
		@else
			<p class="text-lg text-dark/80 mb-8 md:mb-12 max-w-3xl" data-aos="fade-up" data-aos-delay="100">
				We are grateful to our partners and sponsors who support the Jaffna International Cinema Festival and help us celebrate cinema, culture, and community.
			</p>

			@forelse($categories ?? [] as $category)
				<div class="mb-12 md:mb-16" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
					<h2 class="text-xl md:text-2xl lg:text-3xl font-display font-bold mb-4 md:mb-6 text-primary">{{ $category->name }}</h2>
					<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 md:gap-6 items-center">
						@forelse($category->partners as $partner)
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
						@empty
							<p class="col-span-full text-dark/60 text-sm">No partners in this category yet.</p>
						@endforelse
					</div>
				</div>
			@empty
				<div class="text-center py-12 md:py-16" data-aos="fade-up">
					<p class="text-dark/70 text-base md:text-lg">Partner information will be displayed here.</p>
				</div>
			@endforelse

			{{-- Partners without category --}}
			@php
				$uncategorizedPartners = \App\Models\Partner::whereNull('category_id')->orderBy('sort_order')->get();
			@endphp

			@if($uncategorizedPartners->count() > 0)
				<div class="mb-12 md:mb-16" data-aos="fade-up">
					<h2 class="text-xl md:text-2xl lg:text-3xl font-display font-bold mb-4 md:mb-6 text-primary">Partners</h2>
					<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4 md:gap-6 items-center">
						@foreach($uncategorizedPartners as $partner)
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
		@endif
	</section>
@endsection

