@extends('layouts.app')

@section('title', ($__site?->site_name ?? 'Jaffna International Cinema Festival') . ' — Celebrating Cinema, Culture & Community')
@section('meta_description', 'Jaffna International Cinema Festival (JAFFNA ICF) celebrates cinema, culture, and community with diverse film programmes, masterclasses, screenings, and cultural events in Jaffna, Sri Lanka.')

@section('content')
	<section class="relative -mt-[112px] md:-mt-[156px] pt-[112px] md:pt-[180px]">
		<div class="hero-swiper swiper w-full h-[50vh] sm:h-[55vh] md:h-[70vh] min-h-[350px] md:min-h-[500px]">
			<div class="swiper-wrapper">
				@forelse($sliders as $slide)
					<div class="swiper-slide relative">
						@if($slide->image_path || $slide->mobile_image_path)
							@if($slide->mobile_image_path)
								<!-- Mobile Image - Portrait (3:4) - Fit to screen -->
								<div class="md:hidden w-full h-full flex items-center justify-center bg-dark/10">
									<img src="{{ asset('storage/' . $slide->mobile_image_path) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-full h-full object-contain object-center" />
								</div>
								<!-- Desktop Image - Landscape (16:9) - Fit to screen -->
								@if($slide->image_path)
									<div class="hidden md:flex w-full h-full items-center justify-center bg-dark/10">
										<img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-full h-full object-contain object-center" />
									</div>
								@else
									<div class="hidden md:flex w-full h-full items-center justify-center bg-dark/10">
										<img src="{{ asset('storage/' . $slide->mobile_image_path) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-full h-full object-contain object-center" />
									</div>
								@endif
							@elseif($slide->image_path)
								<!-- Desktop Image (used for both if no mobile image) - Fit to screen -->
								<div class="w-full h-full flex items-center justify-center bg-dark/10">
									<img src="{{ asset('storage/' . $slide->image_path) }}" alt="{{ $slide->title ?? 'Slide' }}" class="w-full h-full object-contain object-center" />
								</div>
							@endif
						@else
							<div class="w-full h-full bg-dark/10"></div>
						@endif
						@if($slide->title || $slide->subtitle || $slide->button_text)
							<div class="absolute inset-x-0 bottom-3 md:bottom-10 left-0 right-0 px-4 md:px-0">
								<div class="container-full text-white">
									@if($slide->title)
										<h1 class="text-xl sm:text-2xl md:text-4xl lg:text-6xl font-display font-bold leading-tight mb-2 md:mb-0" data-aos="fade-up">{{ $slide->title }}</h1>
									@endif
									@if($slide->subtitle)
										<p class="mt-1 md:mt-4 max-w-3xl text-xs sm:text-sm md:text-lg text-white/90 leading-relaxed mobile-line-clamp" data-aos="fade-up" data-aos-delay="100">
											{{ $slide->subtitle }}
										</p>
									@endif
									@if($slide->button_text && $slide->button_url)
										<div class="mt-3 md:mt-6 flex flex-wrap gap-2 md:gap-3" data-aos="fade-up" data-aos-delay="200">
											<a href="{{ $slide->button_url }}" class="btn-primary text-xs md:text-base px-3 py-1.5 md:px-6 md:py-3">{{ $slide->button_text }}</a>
										</div>
									@endif
								</div>
							</div>
						@endif
					</div>
				@empty
					<div class="swiper-slide">
						<div class="w-full h-full bg-dark/10"></div>
					</div>
				@endforelse
			</div>
			<div class="swiper-button-prev text-white !w-7 !h-7 md:!w-12 md:!h-12 !left-2 md:!left-4"></div>
			<div class="swiper-button-next text-white !w-7 !h-7 md:!w-12 md:!h-12 !right-2 md:!right-4"></div>
			<div class="swiper-pagination !bottom-1 md:!bottom-4"></div>

			<div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
		</div>
	</section>

	<!-- About Festival Section -->
	<section class="container-full py-16 md:py-20">
		<div class="grid md:grid-cols-2 gap-12 items-center">
			<div data-aos="fade-up">
				<h2 class="section-title">About JAFFNA ICF</h2>
				<p class="mt-6 text-lg text-dark/80 leading-relaxed">
					The Jaffna International Cinema Festival (JAFFNA ICF) is a celebration of cinema, culture, and community. Since its inception, the festival has been dedicated to showcasing diverse voices from South Asia and beyond, bringing together filmmakers, artists, and audiences in the historic city of Jaffna.
				</p>
				<p class="mt-4 text-lg text-dark/80 leading-relaxed">
					We aim to inspire, educate, and connect audiences through the power of cinema, fostering a vibrant film culture that bridges communities and celebrates storytelling in all its forms.
				</p>
				<div class="mt-8 flex flex-wrap gap-4">
					<a href="{{ route('about.jaffnaicf') }}" class="btn-primary">Learn More</a>
					<a href="{{ route('programme.schedule') }}" class="btn-outline">View Programme</a>
				</div>
			</div>
			<div class="bg-white rounded-xl p-8 shadow-soft" data-aos="fade-up" data-aos-delay="100">
				<h3 class="text-2xl font-display font-bold mb-6">Festival Highlights</h3>
				<div class="space-y-6">
					<div class="flex items-start gap-4">
						<div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
							<svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
							</svg>
						</div>
						<div>
							<h4 class="font-semibold text-lg">Film Screenings</h4>
							<p class="text-dark/70 mt-1">Premieres, retrospectives, and curated selections from around the world.</p>
						</div>
					</div>
					<div class="flex items-start gap-4">
						<div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
							<svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
							</svg>
						</div>
						<div>
							<h4 class="font-semibold text-lg">Masterclasses</h4>
							<p class="text-dark/70 mt-1">Learn from renowned filmmakers and industry professionals.</p>
						</div>
					</div>
					<div class="flex items-start gap-4">
						<div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
							<svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
							</svg>
						</div>
						<div>
							<h4 class="font-semibold text-lg">Jury & Awards</h4>
							<p class="text-dark/70 mt-1">Recognizing excellence in filmmaking across multiple categories.</p>
						</div>
					</div>
					<div class="flex items-start gap-4">
						<div class="flex-shrink-0 w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center">
							<svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
							</svg>
						</div>
						<div>
							<h4 class="font-semibold text-lg">Cultural Events</h4>
							<p class="text-dark/70 mt-1">Engaging discussions, exhibitions, and community gatherings.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Programme Highlights Section -->
	<section class="container-full py-16 md:py-20 bg-white rounded-xl">
		<h2 class="section-title text-center mb-12" data-aos="fade-up">Programme Highlights</h2>
		<div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
			<a href="{{ route('programme.schedule') }}" class="group bg-secondary rounded-xl p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="100">
				<div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
					<svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
					</svg>
				</div>
				<h3 class="text-xl font-bold mb-2">Schedule</h3>
				<p class="text-dark/70">View the complete festival schedule with all screenings and events.</p>
			</a>
			<a href="{{ route('programme.masterclasses') }}" class="group bg-secondary rounded-xl p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="200">
				<div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
					<svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
					</svg>
				</div>
				<h3 class="text-xl font-bold mb-2">Masterclasses</h3>
				<p class="text-dark/70">Learn from industry experts and renowned filmmakers.</p>
			</a>
			<a href="{{ route('programme.debut-films') }}" class="group bg-secondary rounded-xl p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="300">
				<div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
					<svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
					</svg>
				</div>
				<h3 class="text-xl font-bold mb-2">Debut Films</h3>
				<p class="text-dark/70">Discover first features and emerging voices in cinema.</p>
			</a>
			<a href="{{ route('programme.jury-debut-films') }}" class="group bg-secondary rounded-xl p-6 hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="400">
				<div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 transition">
					<svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
					</svg>
				</div>
				<h3 class="text-xl font-bold mb-2">Jury</h3>
				<p class="text-dark/70">Meet the distinguished jury members evaluating the films.</p>
			</a>
		</div>
	</section>

	<!-- Featured Films Section -->
	@if($featuredFilms->isNotEmpty())
	<section class="container-full py-16 md:py-20">
		<div class="flex items-center justify-between mb-8" data-aos="fade-up">
			<h2 class="section-title">Featured Films</h2>
			<a href="{{ route('programme.schedule') }}" class="text-primary hover:text-accent font-medium">View all →</a>
		</div>
		<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
			@foreach($featuredFilms as $film)
				<a href="#" class="group rounded-xl overflow-hidden bg-white shadow-soft hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
					@if($film->poster_path)
						<div class="aspect-[2/3] overflow-hidden">
							<img src="{{ asset($film->poster_path) }}" alt="{{ $film->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
						</div>
					@else
						<div class="aspect-[2/3] bg-dark/10 flex items-center justify-center">
							<svg class="w-16 h-16 text-dark/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
							</svg>
						</div>
					@endif
					<div class="p-4">
						<h4 class="font-semibold text-lg mb-1">{{ $film->title }}</h4>
						<p class="text-sm text-dark/60">{{ $film->director }}@if($film->year) • {{ $film->year }}@endif</p>
					</div>
				</a>
			@endforeach
		</div>
	</section>
	@endif

	<!-- Call to Action Section -->
	<section class="container-full py-16 md:py-20">
		<div class="bg-gradient-to-br from-primary via-primary/95 to-accent rounded-2xl p-8 md:p-12 text-white text-center" data-aos="fade-up">
			<h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold mb-4">Join Us in Jaffna</h2>
			<p class="text-lg md:text-xl text-white/90 max-w-2xl mx-auto mb-8">
				Experience the magic of cinema in the heart of Northern Sri Lanka. Connect with filmmakers, discover new voices, and celebrate the art of storytelling.
			</p>
			<div class="flex flex-wrap justify-center gap-4">
				@if($__app?->application_open && $__app?->application_pdf_path)
					<a href="{{ asset('storage/' . $__app->application_pdf_path) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-6 py-3 bg-white text-primary rounded-md hover:bg-secondary hover:text-white transition shadow-lg font-medium">
						<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
						</svg>
						Download Application
					</a>
				@else
					<span class="inline-flex items-center justify-center px-6 py-3 rounded-md bg-white/10 border-2 border-white/30 text-white/70 uppercase tracking-wide cursor-not-allowed select-none font-medium backdrop-blur-sm">
						<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
						</svg>
						Applications Closed
					</span>
				@endif
				<a href="{{ route('programme.schedule') }}" class="btn-outline border-white text-white hover:bg-white hover:text-primary">
					View Programme
				</a>
				<a href="{{ route('contact') }}" class="btn-ghost text-white hover:text-white/80">
					Contact Us
				</a>
			</div>
		</div>
	</section>

	<!-- Reviews Section -->
	@if($reviews->isNotEmpty())
	<section class="container-full py-16 md:py-20 bg-white rounded-xl">
		<h2 class="section-title text-center mb-12" data-aos="fade-up">What People Say</h2>
		<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
			@foreach($reviews as $review)
				<div class="bg-secondary rounded-xl p-6 md:p-8 shadow-soft hover:shadow-xl transition-all duration-300" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
					<div class="mb-4">
						<svg class="w-8 h-8 text-primary mb-4" fill="currentColor" viewBox="0 0 24 24">
							<path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.996 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.984zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
						</svg>
						<p class="text-dark/80 leading-relaxed italic">"{{ $review->review }}"</p>
					</div>
					<div class="mt-6 pt-6 border-t border-dark/10">
						<h4 class="font-semibold text-lg">{{ $review->name }}</h4>
						@if($review->designation || $review->company)
							<p class="text-sm text-dark/60 mt-1">
								@if($review->designation)
									{{ $review->designation }}
								@endif
								@if($review->designation && $review->company)
									<span class="mx-1">•</span>
								@endif
								@if($review->company)
									{{ $review->company }}
								@endif
							</p>
						@endif
					</div>
				</div>
			@endforeach
		</div>
	</section>
	@endif

	<!-- Partners Section -->
	@if($partners->isNotEmpty())
	<section class="container-full py-16 md:py-20">
		<h2 class="section-title text-center mb-12" data-aos="fade-up">Our Partners</h2>
		<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 items-center" data-aos="fade-up" data-aos-delay="100">
			@foreach($partners as $partner)
				@if($partner->logo_path && file_exists(storage_path('app/public/' . $partner->logo_path)))
					<a href="{{ $partner->url ?? '#' }}" target="{{ $partner->url ? '_blank' : '_self' }}" rel="noopener" class="bg-white rounded-lg p-4 flex items-center justify-center h-24 hover:shadow-lg transition-all duration-300">
						<img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="max-h-16 max-w-full object-contain" />
					</a>
				@else
					<div class="bg-white rounded-lg p-4 flex items-center justify-center h-24">
						<span class="text-dark/50 text-sm text-center">{{ $partner->name }}</span>
					</div>
				@endif
			@endforeach
		</div>
		<div class="text-center mt-8">
			<a href="{{ route('partners') }}" class="text-primary hover:text-accent font-medium">View all partners →</a>
		</div>
	</section>
	@endif
@endsection


