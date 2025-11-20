@extends('layouts.app')

@section('title', 'Sitemap — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Complete sitemap of all pages on the Jaffna International Cinema Festival website.')

@section('content')
	<section class="container-full py-16">
		<h1 class="section-title" data-aos="fade-up">Sitemap</h1>
		<p class="mt-4 text-dark/70 max-w-3xl" data-aos="fade-up" data-aos-delay="100">
			Find all pages and sections of the Jaffna International Cinema Festival website.
		</p>

		<div class="mt-10 grid gap-8 md:grid-cols-2 lg:grid-cols-3" data-aos="fade-up" data-aos-delay="200">
			<!-- Main Pages -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<h2 class="text-2xl font-display font-bold mb-4 text-primary">Main Pages</h2>
				<ul class="space-y-2">
					<li><a href="{{ route('home') }}" class="text-dark/80 hover:text-primary transition">Home</a></li>
					<li><a href="{{ route('about.jaffnaicf') }}" class="text-dark/80 hover:text-primary transition">About JAFFNAICF</a></li>
					<li><a href="{{ route('about.team') }}" class="text-dark/80 hover:text-primary transition">Team</a></li>
					<li><a href="{{ route('gallery') }}" class="text-dark/80 hover:text-primary transition">Gallery</a></li>
					<li><a href="{{ route('partners') }}" class="text-dark/80 hover:text-primary transition">Partners</a></li>
					<li><a href="{{ route('venues') }}" class="text-dark/80 hover:text-primary transition">Venues</a></li>
					<li><a href="{{ route('contact') }}" class="text-dark/80 hover:text-primary transition">Contact</a></li>
				</ul>
			</div>

			<!-- Programme -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<h2 class="text-2xl font-display font-bold mb-4 text-primary">Programme</h2>
				<ul class="space-y-2">
					<li><a href="{{ route('programme.schedule') }}" class="text-dark/80 hover:text-primary transition">Schedule</a></li>
					<li><a href="{{ route('programme.masterclasses') }}" class="text-dark/80 hover:text-primary transition">Masterclasses</a></li>
					<li><a href="{{ route('programme.debut-films') }}" class="text-dark/80 hover:text-primary transition">Debut Films</a></li>
					<li><a href="{{ route('programme.jury-debut-films') }}" class="text-dark/80 hover:text-primary transition">Jury – Debut Films</a></li>
					<li><a href="{{ route('programme.jury-short-films') }}" class="text-dark/80 hover:text-primary transition">Jury – Short Films</a></li>
					<li><a href="{{ route('programme.national-short-films') }}" class="text-dark/80 hover:text-primary transition">National Short Films</a></li>
					<li><a href="{{ route('programme.international-short-films') }}" class="text-dark/80 hover:text-primary transition">International Short Films</a></li>
					<li><a href="{{ route('programme.new-asian-currents') }}" class="text-dark/80 hover:text-primary transition">New Asian Currents</a></li>
				</ul>
			</div>

			<!-- Archive -->
			@if($pastYears->isNotEmpty())
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<h2 class="text-2xl font-display font-bold mb-4 text-primary">Archive</h2>
				<ul class="space-y-2">
					<li><a href="{{ route('archive.index') }}" class="text-dark/80 hover:text-primary transition">Archive Index</a></li>
					@foreach($pastYears as $year)
						<li class="pl-4">
							<a href="{{ route('archive.year', $year) }}" class="text-dark/80 hover:text-primary transition font-medium">{{ $year }}</a>
							<ul class="mt-1 space-y-1 pl-4 text-sm">
								<li><a href="{{ route('archive.team', $year) }}" class="text-dark/60 hover:text-primary transition">Team</a></li>
								<li><a href="{{ route('archive.partners', $year) }}" class="text-dark/60 hover:text-primary transition">Partners</a></li>
								<li><a href="{{ route('archive.venues', $year) }}" class="text-dark/60 hover:text-primary transition">Venues</a></li>
								<li><a href="{{ route('archive.programme.schedule', $year) }}" class="text-dark/60 hover:text-primary transition">Schedule</a></li>
								<li><a href="{{ route('archive.programme.masterclasses', $year) }}" class="text-dark/60 hover:text-primary transition">Masterclasses</a></li>
								<li><a href="{{ route('archive.programme.debut-films', $year) }}" class="text-dark/60 hover:text-primary transition">Debut Films</a></li>
								<li><a href="{{ route('archive.programme.jury-debut-films', $year) }}" class="text-dark/60 hover:text-primary transition">Jury – Debut Films</a></li>
								<li><a href="{{ route('archive.programme.jury-short-films', $year) }}" class="text-dark/60 hover:text-primary transition">Jury – Short Films</a></li>
								<li><a href="{{ route('archive.programme.national-short-films', $year) }}" class="text-dark/60 hover:text-primary transition">National Short Films</a></li>
								<li><a href="{{ route('archive.programme.international-short-films', $year) }}" class="text-dark/60 hover:text-primary transition">International Short Films</a></li>
								<li><a href="{{ route('archive.programme.new-asian-currents', $year) }}" class="text-dark/60 hover:text-primary transition">New Asian Currents</a></li>
							</ul>
						</li>
					@endforeach
				</ul>
			</div>
			@endif
		</div>
	</section>
@endsection

