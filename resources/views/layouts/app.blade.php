<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		@php
			$currentYear = (int) date('Y');
			$archiveYears = collect();
			$archiveYears = $archiveYears->merge(\App\Models\TeamMember::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\Partner::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\Venue::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\ScheduleImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\MasterclassImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\DebutFilmImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\JuryDebutImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\JuryShortImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\NationalShortImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\InternationalShortImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->merge(\App\Models\NewAsianCurrentImage::select('year')->distinct()->pluck('year'));
			$archiveYears = $archiveYears->unique()->sortDesc()->values();
		@endphp
		<title>@yield('title', $__site?->site_name ?? 'Jaffna International Cinema Festival')</title>
		<meta name="description" content="@yield('meta_description', 'Jaffna International Cinema Festival (JAFFNA ICF) celebrates cinema, culture, and community with programmes, masterclasses, and screenings.')">
		<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
		<link rel="canonical" href="{{ url()->current() }}">
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

		<meta property="og:type" content="@yield('og_type', 'website')">
		<meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'Jaffna International Cinema Festival')))">
		<meta property="og:description" content="@yield('og_description', $__env->yieldContent('meta_description', 'Jaffna International Cinema Festival (JAFFNA ICF) celebrates cinema, culture, and community with programmes, masterclasses, and screenings.'))">
		<meta property="og:url" content="{{ url()->current() }}">
		<meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">

		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="@yield('twitter_title', trim($__env->yieldContent('title', 'Jaffna International Cinema Festival')))">
		<meta name="twitter:description" content="@yield('twitter_description', $__env->yieldContent('meta_description', 'Jaffna International Cinema Festival (JAFFNA ICF) celebrates cinema, culture, and community with programmes, masterclasses, and screenings.'))">
		<meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">

		<script type="application/ld+json">
		{
			"@context": "https://schema.org",
			"@type": "Organization",
			"name": "{{ $__site?->site_name ?? 'Jaffna International Cinema Festival' }}",
			"alternateName": "JAFFNA ICF",
			"url": "{{ url('/') }}",
			"logo": {
				"@type": "ImageObject",
				"url": "{{ $__site?->logo_path ? asset('storage/' . $__site->logo_path) : asset('images/og-default.jpg') }}"
			},
			"sameAs": [
				"https://www.facebook.com/JaffnaICF"
			],
			"contactPoint": {
				"@type": "ContactPoint",
				"contactType": "General Inquiry",
				"areaServed": "LK",
				"availableLanguage": ["en", "ta"]
			}
		}
		</script>

		<meta name="theme-color" content="#C5502C">
		@vite(['resources/css/app.css', 'resources/js/app.js'])
	</head>
	<body class="bg-secondary text-dark">
		<header x-data="{ scrolled: false, open: false }"
			x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 10 })"
			:class="scrolled ? 'bg-secondary shadow-sm fixed top-0 inset-x-0 z-50 border-b border-black/5' : 'bg-secondary fixed top-0 inset-x-0 z-50 border-b border-black/5'">
			<div class="container-full flex items-center justify-between pt-6 md:pt-8 pb-2 md:pb-3">
				<a href="{{ route('home') }}" class="flex items-center gap-3">
					@if($__site?->logo_path)
						<img src="{{ asset('storage/' . $__site->logo_path) }}" alt="{{ $__site->site_name }}" class="h-20 md:h-28 lg:h-32 w-auto">
					@else
						<div class="w-16 h-16 md:w-20 md:h-20 lg:w-24 lg:h-24 rounded-full bg-primary"></div>
					@endif
				</a>
				<nav class="hidden md:flex items-center gap-8 lg:gap-12 font-medium" x-data="{ about:false, programme:false, archive:false }">
					<a href="{{ route('home') }}" class="hover:text-primary uppercase tracking-wider text-[15px] md:text-base">Home</a>

					<div class="relative" @mouseenter="about=true" @mouseleave="about=false">
						<button class="inline-flex items-center gap-1 hover:text-primary" @click.prevent="about=!about">
							<span class="uppercase tracking-wider text-[15px] md:text-base">About</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z" clip-rule="evenodd"/></svg>
						</button>
						<div x-show="about" x-transition class="absolute left-0 mt-3 w-56 bg-white shadow-lg rounded-md border p-2">
							<a href="{{ route('about.jaffnaicf') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">JAFFNAICF</a>
							<a href="{{ route('about.team') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">Team</a>
						</div>
					</div>

					<div class="relative" @mouseenter="programme=true" @mouseleave="programme=false">
						<button class="inline-flex items-center gap-1 hover:text-primary" @click.prevent="programme=!programme">
							<span class="uppercase tracking-wider text-[15px] md:text-base">Programme</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z" clip-rule="evenodd"/></svg>
						</button>
						<div x-show="programme" x-transition class="absolute left-0 mt-3 w-64 bg-white shadow-lg rounded-md border p-2">
							<a href="{{ route('programme.schedule') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">Schedule</a>
							<a href="{{ route('programme.masterclasses') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">Masterclasses</a>
							<a href="{{ route('programme.debut-films') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">Debut Films</a>
							<a href="{{ route('programme.jury-debut-films') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">Jury – Debut Films</a>
							<a href="{{ route('programme.jury-short-films') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">Jury – Short Films</a>
							<a href="{{ route('programme.national-short-films') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">National Short Films</a>
							<a href="{{ route('programme.international-short-films') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">International Short Films</a>
							<a href="{{ route('programme.new-asian-currents') }}" class="block px-3 py-2 rounded hover:bg-secondary uppercase tracking-wider text-sm">New Asian Currents</a>
						</div>
					</div>

					<a href="{{ route('partners') }}" class="hover:text-primary uppercase tracking-wider text-[15px] md:text-base">Partners</a>
					<a href="{{ route('venues') }}" class="hover:text-primary uppercase tracking-wider text-[15px] md:text-base">Venues</a>
					<a href="{{ route('gallery') }}" class="hover:text-primary uppercase tracking-wider text-[15px] md:text-base">Gallery</a>

					<div class="relative" @mouseenter="archive=true" @mouseleave="archive=false">
						<button class="inline-flex items-center gap-1 hover:text-primary" @click.prevent="archive=!archive">
							<span class="uppercase tracking-wider text-[15px] md:text-base">Archive</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z" clip-rule="evenodd"/></svg>
						</button>
						<div x-show="archive" x-transition class="absolute left-0 mt-3 w-[800px] bg-white shadow-lg rounded-md border p-4">
							@php($pastYears = $archiveYears->filter(fn($y) => $y != $currentYear))
							@if($pastYears->isEmpty())
								<div class="text-center py-4">
									<p class="text-dark/70">No archive content available yet.</p>
								</div>
							@else
								<div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-sm">
									@foreach($pastYears->take(9)->chunk(3) as $yearChunk)
										<div>
											@foreach($yearChunk as $year)
												<h4 class="font-semibold mb-2 uppercase tracking-wide">{{ $year }}</h4>
												<ul class="space-y-1 mb-4">
													<li><a href="{{ route('archive.programme.schedule', $year) }}" class="hover:text-primary uppercase tracking-wide">Schedule</a></li>
													<li><a href="{{ route('archive.programme.masterclasses', $year) }}" class="hover:text-primary uppercase tracking-wide">Masterclasses</a></li>
													<li><a href="{{ route('archive.programme.debut-films', $year) }}" class="hover:text-primary uppercase tracking-wide">Debut Films</a></li>
													<li><a href="{{ route('archive.programme.jury-debut-films', $year) }}" class="hover:text-primary uppercase tracking-wide">Jury – Debut Films</a></li>
													<li><a href="{{ route('archive.programme.jury-short-films', $year) }}" class="hover:text-primary uppercase tracking-wide">Jury – Short Films</a></li>
													<li><a href="{{ route('archive.programme.national-short-films', $year) }}" class="hover:text-primary uppercase tracking-wide">National Short Films</a></li>
													<li><a href="{{ route('archive.programme.international-short-films', $year) }}" class="hover:text-primary uppercase tracking-wide">International Short Films</a></li>
													<li><a href="{{ route('archive.programme.new-asian-currents', $year) }}" class="hover:text-primary uppercase tracking-wide">New Asian Currents</a></li>
													<li><a href="{{ route('archive.team', $year) }}" class="hover:text-primary uppercase tracking-wide">Team</a></li>
													<li><a href="{{ route('archive.partners', $year) }}" class="hover:text-primary uppercase tracking-wide">Partners</a></li>
													<li><a href="{{ route('archive.venues', $year) }}" class="hover:text-primary uppercase tracking-wide">Venues</a></li>
												</ul>
											@endforeach
										</div>
									@endforeach
								</div>
								@if($pastYears->count() > 9)
									<div class="mt-4 pt-4 border-t text-center">
										<a href="{{ route('archive.index') }}" class="text-primary hover:underline uppercase tracking-wide text-sm">View All Years</a>
									</div>
								@endif
							@endif
						</div>
					</div>

					<a href="{{ route('contact') }}" class="hover:text-primary uppercase tracking-wider text-[15px] md:text-base">Contact</a>
					@if($__app?->application_open && $__app?->application_pdf_path)
						<a href="{{ asset('storage/' . $__app->application_pdf_path) }}" target="_blank" rel="noopener" class="inline-flex items-center justify-center px-5 py-3 bg-primary text-white rounded-md hover:bg-accent transition shadow-soft uppercase tracking-wider text-[15px] md:text-base font-medium">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
							</svg>
							Download Application
						</a>
					@else
						<span class="inline-flex items-center justify-center px-5 py-3 rounded-md bg-dark/5 border-2 border-dark/20 text-dark/50 uppercase tracking-wider text-[15px] md:text-base cursor-not-allowed select-none font-medium">
							<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
							</svg>
							Applications Closed
						</span>
					@endif
				</nav>
				<button class="md:hidden" @click="open = !open">
					<svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
					</svg>
				</button>
			</div>
			<div x-show="open" x-transition class="md:hidden bg-white border-t">
				<div class="container-full py-4 grid gap-4" x-data="{ about:false, programme:false, archive:false }">
					<a href="{{ route('home') }}" class="py-2 uppercase tracking-wide">Home</a>

					<div>
						<button class="w-full text-left py-2 flex items-center justify-between" @click="about=!about">
							<span class="uppercase tracking-wide">About</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z" clip-rule="evenodd"/></svg>
						</button>
						<div x-show="about" x-transition class="pl-4 grid gap-2">
							<a href="{{ route('about.jaffnaicf') }}" class="py-1 uppercase tracking-wide">JAFFNAICF</a>
							<a href="{{ route('about.team') }}" class="py-1 uppercase tracking-wide">Team</a>
						</div>
					</div>

					<div>
						<button class="w-full text-left py-2 flex items-center justify-between" @click="programme=!programme">
							<span class="uppercase tracking-wide">Programme</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z" clip-rule="evenodd"/></svg>
						</button>
						<div x-show="programme" x-transition class="pl-4 grid gap-2">
							<a href="{{ route('programme.schedule') }}" class="py-1 uppercase tracking-wide">Schedule</a>
							<a href="{{ route('programme.masterclasses') }}" class="py-1 uppercase tracking-wide">Masterclasses</a>
							<a href="{{ route('programme.debut-films') }}" class="py-1 uppercase tracking-wide">Debut Films</a>
							<a href="{{ route('programme.jury-debut-films') }}" class="py-1 uppercase tracking-wide">Jury – Debut Films</a>
							<a href="{{ route('programme.jury-short-films') }}" class="py-1 uppercase tracking-wide">Jury – Short Films</a>
							<a href="{{ route('programme.national-short-films') }}" class="py-1 uppercase tracking-wide">National Short Films</a>
							<a href="{{ route('programme.international-short-films') }}" class="py-1 uppercase tracking-wide">International Short Films</a>
							<a href="{{ route('programme.new-asian-currents') }}" class="py-1 uppercase tracking-wide">New Asian Currents</a>
						</div>
					</div>

					<a href="{{ route('partners') }}" class="py-2 uppercase tracking-wide">Partners</a>
					<a href="{{ route('venues') }}" class="py-2 uppercase tracking-wide">Venues</a>
					<a href="{{ route('gallery') }}" class="py-2 uppercase tracking-wide">Gallery</a>

					<div>
						<button class="w-full text-left py-2 flex items-center justify-between" @click="archive=!archive">
							<span class="uppercase tracking-wide">Archive</span>
							<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 10.94l3.71-3.71a.75.75 0 1 1 1.06 1.06l-4.24 4.25a.75.75 0 0 1-1.06 0L5.21 8.29a.75.75 0 0 1 .02-1.08z" clip-rule="evenodd"/></svg>
						</button>
						<div x-show="archive" x-transition class="pl-4 grid gap-3">
							@php($pastYears = $archiveYears->filter(fn($y) => $y != $currentYear))
							@if($pastYears->isEmpty())
								<div class="text-dark/70 text-sm">No archive content available yet.</div>
							@else
								@foreach($pastYears->take(6) as $year)
									<div>
										<div class="font-semibold uppercase tracking-wide">{{ $year }}</div>
										<ul class="pl-3 grid gap-1">
											<li><a href="{{ route('archive.programme.schedule', $year) }}" class="py-1 uppercase tracking-wide">Schedule</a></li>
											<li><a href="{{ route('archive.programme.masterclasses', $year) }}" class="py-1 uppercase tracking-wide">Masterclasses</a></li>
											<li><a href="{{ route('archive.programme.debut-films', $year) }}" class="py-1 uppercase tracking-wide">Debut Films</a></li>
											<li><a href="{{ route('archive.programme.jury-debut-films', $year) }}" class="py-1 uppercase tracking-wide">Jury – Debut Films</a></li>
											<li><a href="{{ route('archive.programme.jury-short-films', $year) }}" class="py-1 uppercase tracking-wide">Jury – Short Films</a></li>
											<li><a href="{{ route('archive.programme.national-short-films', $year) }}" class="py-1 uppercase tracking-wide">National Short Films</a></li>
											<li><a href="{{ route('archive.programme.international-short-films', $year) }}" class="py-1 uppercase tracking-wide">International Short Films</a></li>
											<li><a href="{{ route('archive.programme.new-asian-currents', $year) }}" class="py-1 uppercase tracking-wide">New Asian Currents</a></li>
											<li><a href="{{ route('archive.team', $year) }}" class="py-1 uppercase tracking-wide">Team</a></li>
											<li><a href="{{ route('archive.partners', $year) }}" class="py-1 uppercase tracking-wide">Partners</a></li>
											<li><a href="{{ route('archive.venues', $year) }}" class="py-1 uppercase tracking-wide">Venues</a></li>
										</ul>
									</div>
								@endforeach
								@if($pastYears->count() > 6)
									<div class="pt-2">
										<a href="{{ route('archive.index') }}" class="text-primary hover:underline uppercase tracking-wide text-sm">View All Years →</a>
									</div>
								@endif
							@endif
						</div>
					</div>

					<a href="{{ route('contact') }}" class="py-2 uppercase tracking-wide">Contact</a>
					
					<!-- Download Application Button - Mobile -->
					<div class="pt-2 border-t border-dark/10">
						@if($__app?->application_open && $__app?->application_pdf_path)
							<a href="{{ asset('storage/' . $__app->application_pdf_path) }}" target="_blank" rel="noopener" class="block w-full">
								<span class="inline-flex items-center justify-center w-full px-5 py-2 bg-primary text-white rounded-md hover:bg-accent transition shadow-lg uppercase tracking-wide font-medium text-sm">
									<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
									</svg>
									Download Application
								</span>
							</a>
						@else
							<span class="inline-flex items-center justify-center w-full px-5 py-2 rounded-md bg-dark/5 border-2 border-dark/20 text-dark/50 uppercase tracking-wide cursor-not-allowed select-none font-medium text-sm">
								<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
								</svg>
								Applications Closed
							</span>
						@endif
					</div>
				</div>
			</div>
		</header>
		
		<!-- Mobile Download Application Button - Below Header -->
		<div class="md:hidden sticky top-[104px] z-40 bg-secondary border-b border-black/5 shadow-sm">
			<div class="container-full py-3">
				@if($__app?->application_open && $__app?->application_pdf_path)
					<a href="{{ asset('storage/' . $__app->application_pdf_path) }}" target="_blank" rel="noopener" class="block w-full">
						<span class="inline-flex items-center justify-center w-full px-4 py-3 bg-primary text-white rounded-md hover:bg-accent transition shadow-lg uppercase tracking-wide font-medium text-sm">
							<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
							</svg>
							Download Application
						</span>
					</a>
				@else
					<span class="inline-flex items-center justify-center w-full px-4 py-3 rounded-md bg-dark/5 border-2 border-dark/20 text-dark/50 uppercase tracking-wide cursor-not-allowed select-none font-medium text-sm">
						<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
						</svg>
						Applications Closed
					</span>
				@endif
			</div>
		</div>

		<main class="pt-[112px] md:pt-[156px]">
			@yield('content')
		</main>

		<footer class="mt-20 bg-dark text-white">
			<div class="container-full py-14 grid gap-10 md:grid-cols-4">
				<div>
					<div class="flex items-center gap-3">
						@if($__site?->logo_path)
							<img src="{{ asset('storage/' . $__site->logo_path) }}" alt="{{ $__site->site_name }}" class="h-12 w-auto">
						@else
							<div class="w-9 h-9 rounded-full bg-primary"></div>
						@endif
						<span class="font-display font-bold text-xl">{{ $__site?->site_name ?? 'JAFFNA ICF' }}</span>
					</div>
					<p class="mt-4 text-white/70">A celebration of cinema, culture, and community in Jaffna.</p>
					<div class="mt-4 inline-flex items-center gap-3 rounded-full border border-primary/60 bg-primary/10 px-4 py-2">
						<span class="uppercase tracking-wider text-white/80 text-xs">Presented by</span>
						<span class="font-semibold text-primary text-sm">Agenda 14</span>
					</div>
					<div class="mt-6 flex gap-3">
						<a href="https://www.facebook.com/JaffnaICF" target="_blank" rel="noopener" aria-label="Facebook" class="w-10 h-10 grid place-items-center rounded-full bg-primary/20 text-white hover:bg-primary transition">
							<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12.06C22 6.49 17.52 2 12 2S2 6.49 2 12.06c0 5.02 3.66 9.18 8.44 9.94v-7.03H7.9v-2.91h2.54V9.41c0-2.5 1.49-3.88 3.77-3.88 1.09 0 2.23.2 2.23.2v2.46h-1.26c-1.24 0-1.62.77-1.62 1.56v1.88h2.77l-.44 2.91h-2.33V22c4.78-.76 8.44-4.92 8.44-9.94Z"/></svg>
						</a>
					</div>
				</div>
				<div>
					<h4 class="font-semibold mb-4 text-primary">Festival</h4>
					<ul class="space-y-2 text-white/80">
						<li><a href="{{ route('about.jaffnaicf') }}" class="hover:text-primary transition">About</a></li>
						<li><a href="{{ route('about.team') }}" class="hover:text-primary transition">Team</a></li>
						<li><a href="{{ route('gallery') }}" class="hover:text-primary transition">Gallery</a></li>
						<li><a href="{{ route('sitemap') }}" class="hover:text-primary transition">Sitemap</a></li>
					</ul>
				</div>
				<div>
					<h4 class="font-semibold mb-4 text-primary">Participate</h4>
					<ul class="space-y-2 text-white/80">
						@if($__app?->application_open && $__app?->application_pdf_path)
							<li><a href="{{ asset('storage/' . $__app->application_pdf_path) }}" target="_blank" rel="noopener" class="hover:text-primary transition">Download Application</a></li>
						@else
							<li><span class="text-white/50 cursor-not-allowed">Applications Closed</span></li>
						@endif
						<li><a href="{{ route('partners') }}" class="hover:text-primary transition">Partners</a></li>
						<li><a href="{{ route('venues') }}" class="hover:text-primary transition">Venues</a></li>
						<li><a href="{{ route('contact') }}" class="hover:text-primary transition">Contact</a></li>
					</ul>
				</div>
				<div>
					<h4 class="font-semibold mb-4 text-primary">Contact</h4>
					<ul class="space-y-2 text-white/80">
						<li><span class="text-white/60">Email:</span> <a href="mailto:jaffnaicf@gmail.com" class="hover:text-primary">jaffnaicf@gmail.com</a></li>
						<li><span class="text-white/60">Phone:</span> <a href="tel:+94112826027" class="hover:text-primary">+94 11 282 6027</a></li>
						<li><span class="text-white/60">Address:</span> Agenda 14, #6B/9, Pagoda Road, Nugegoda 10250</li>
					</ul>
					<a href="{{ route('contact') }}" class="mt-4 inline-flex btn-primary">Contact Us</a>
				</div>
			</div>
			<div class="border-t border-white/10">
				<div class="container-full py-6 text-sm text-white/70 flex flex-col md:flex-row items-start md:items-center justify-between gap-2">
					<div>© {{ date('Y') }} Jaffna International Cinema Festival</div>
					<div>Website design & development by <a href="https://olexto.com/" target="_blank" rel="noopener" class="text-primary hover:text-white">olexto Digital Solutions (Pvt) Ltd</a></div>
				</div>
			</div>
		</footer>
		<!-- Back to top -->
		<div x-data="{ show: false }"
			x-init="window.addEventListener('scroll', () => { show = window.scrollY > 300 })">
			<button x-show="show" x-transition @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="back-to-top" aria-label="Back to top">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 6.586 5.293 13.293a1 1 0 1 1-1.414-1.414l8-8a1 1 0 0 1 1.414 0l8 8a1 1 0 1 1-1.414 1.414L12 6.586Z"/><path d="M12 3a1 1 0 0 1 1 1v15a1 1 0 1 1-2 0V4a1 1 0 0 1 1-1Z"/></svg>
			</button>
		</div>
	</body>
</html>


