@extends('layouts.app')

@section('title', 'Sitemap — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Complete sitemap of all pages on the Jaffna International Cinema Festival website.')

@section('content')
	<section class="container-full py-16 md:py-20">
		<div class="max-w-4xl mx-auto text-center mb-12" data-aos="fade-up">
			<h1 class="section-title">Sitemap</h1>
			<p class="mt-4 text-dark/70 text-lg max-w-2xl mx-auto">
				Find all pages and sections of the Jaffna International Cinema Festival website. Navigate easily through our complete site structure.
			</p>
		</div>

		<div class="grid gap-6 md:gap-8 md:grid-cols-2 lg:grid-cols-3" data-aos="fade-up" data-aos-delay="100">
			<!-- Main Pages -->
			<div class="bg-white rounded-xl p-6 md:p-8 shadow-soft hover:shadow-md transition-shadow duration-300">
				<div class="flex items-center gap-3 mb-6">
					<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
						</svg>
					</div>
					<h2 class="text-2xl font-display font-bold text-primary">Main Pages</h2>
				</div>
				<ul class="space-y-3">
					<li>
						<a href="{{ route('home') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Home</span>
						</a>
					</li>
					<li>
						<a href="{{ route('about.jaffnaicf') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>About JAFFNAICF</span>
						</a>
					</li>
					<li>
						<a href="{{ route('about.team') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Team</span>
						</a>
					</li>
					<li>
						<a href="{{ route('gallery') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Gallery</span>
						</a>
					</li>
					<li>
						<a href="{{ route('partners') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Partners</span>
						</a>
					</li>
					<li>
						<a href="{{ route('venues') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Venues</span>
						</a>
					</li>
					<li>
						<a href="{{ route('contact') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Contact</span>
						</a>
					</li>
				</ul>
			</div>

			<!-- Programme -->
			<div class="bg-white rounded-xl p-6 md:p-8 shadow-soft hover:shadow-md transition-shadow duration-300">
				<div class="flex items-center gap-3 mb-6">
					<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
						</svg>
					</div>
					<h2 class="text-2xl font-display font-bold text-primary">Programme</h2>
				</div>
				<ul class="space-y-3">
					<li>
						<a href="{{ route('programme.schedule') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Schedule</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.masterclasses') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Masterclasses</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.debut-films') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Debut Films</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.jury-debut-films') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Jury – Debut Films</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.jury-short-films') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Jury – Short Films</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.national-short-films') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>National Short Films</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.international-short-films') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>International Short Films</span>
						</a>
					</li>
					<li>
						<a href="{{ route('programme.new-asian-currents') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>New Asian Currents</span>
						</a>
					</li>
				</ul>
			</div>

			<!-- Archive -->
			@if($pastYears->isNotEmpty())
			<div class="bg-white rounded-xl p-6 md:p-8 shadow-soft hover:shadow-md transition-shadow duration-300 md:col-span-2 lg:col-span-1">
				<div class="flex items-center gap-3 mb-6">
					<div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
						</svg>
					</div>
					<h2 class="text-2xl font-display font-bold text-primary">Archive</h2>
				</div>
				<ul class="space-y-4">
					<li>
						<a href="{{ route('archive.index') }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group font-medium">
							<span class="w-1.5 h-1.5 rounded-full bg-primary/30 group-hover:bg-primary transition"></span>
							<span>Archive Index</span>
						</a>
					</li>
					@foreach($pastYears as $year)
						<li class="border-l-2 border-primary/20 pl-4">
							<a href="{{ route('archive.year', $year) }}" class="flex items-center gap-2 text-dark/80 hover:text-primary transition group font-semibold mb-2">
								<span class="w-2 h-2 rounded-full bg-primary group-hover:bg-primary transition"></span>
								<span>{{ $year }}</span>
							</a>
							<ul class="mt-2 space-y-2 pl-4">
								<li>
									<a href="{{ route('archive.team', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Team</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.partners', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Partners</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.venues', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Venues</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.schedule', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Schedule</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.masterclasses', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Masterclasses</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.debut-films', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Debut Films</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.jury-debut-films', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Jury – Debut Films</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.jury-short-films', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>Jury – Short Films</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.national-short-films', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>National Short Films</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.international-short-films', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>International Short Films</span>
									</a>
								</li>
								<li>
									<a href="{{ route('archive.programme.new-asian-currents', $year) }}" class="flex items-center gap-2 text-dark/60 hover:text-primary transition text-sm group">
										<span class="w-1 h-1 rounded-full bg-primary/20 group-hover:bg-primary transition"></span>
										<span>New Asian Currents</span>
									</a>
								</li>
							</ul>
						</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>

		<!-- XML Sitemap Link -->
		<div class="mt-12 text-center" data-aos="fade-up" data-aos-delay="200">
			<p class="text-dark/60 mb-4">For search engines and developers:</p>
			<a href="{{ route('sitemap.xml') }}" class="inline-flex items-center gap-2 text-primary hover:text-primary/80 transition font-medium">
				<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
				</svg>
				<span>View XML Sitemap</span>
			</a>
		</div>
	</section>
@endsection

