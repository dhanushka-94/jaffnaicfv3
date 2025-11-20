@extends('layouts.app')

@section('title', 'CONTACT — JAFFNA ICF')
@section('meta_description', 'Contact the Jaffna International Cinema Festival (JAFFNA ICF). General info, key contacts, and office addresses.')

@section('content')
	<section class="container-full py-16">
		<h1 class="section-title">Contact</h1>
		<p class="mt-4 text-dark/70 max-w-2xl">Reach out to the festival team for general inquiries, submissions, partnerships, and programme information.</p>

		<div class="mt-10 grid gap-8 lg:grid-cols-3">
			<!-- General Info -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-primary/10 grid place-items-center text-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12.713 0 6V4.8L12 11.513 24 4.8V6L12 12.713Zm0 2.774L0 9.487V20h24V9.487L12 15.487Z"/></svg>
					</div>
					<h3 class="text-xl font-semibold">General Info</h3>
				</div>
				<div class="mt-5 space-y-2">
					<div class="text-dark/80"><a href="mailto:jaffnaicf@gmail.com" class="hover:text-primary">jaffnaicf@gmail.com</a></div>
					<div class="text-dark/80"><a href="tel:+94112826027" class="hover:text-primary">+94 11 282 6027</a></div>
				</div>
			</div>

			<!-- Festival Director -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-primary/10 grid place-items-center text-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5Z"/></svg>
					</div>
					<div>
						<h3 class="text-xl font-semibold">Anomaa Rajakaruna</h3>
						<p class="text-dark/60">Festival Director</p>
					</div>
				</div>
				<div class="mt-5 space-y-2">
					<div class="text-dark/80"><a href="mailto:anomaaraj@gmail.com" class="hover:text-primary">anomaaraj@gmail.com</a></div>
					<div class="text-dark/80"><a href="tel:+94777879911" class="hover:text-primary">+94 77 787 9911</a></div>
				</div>
			</div>

			<!-- Festival Manager -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-primary/10 grid place-items-center text-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.33 0-8 2.17-8 5v1h16v-1c0-2.83-3.67-5-8-5Z"/></svg>
					</div>
					<div>
						<h3 class="text-xl font-semibold">Kanaka Abeygunawardana</h3>
						<p class="text-dark/60">Festival Manager</p>
					</div>
				</div>
				<div class="mt-5 space-y-2">
					<div class="text-dark/80"><a href="mailto:kanaka.abey@gmail.com" class="hover:text-primary">kanaka.abey@gmail.com</a></div>
					<div class="text-dark/80"><a href="tel:+94777320398" class="hover:text-primary">+94 77 732 0398</a></div>
				</div>
			</div>
		</div>

		<div class="mt-10 grid gap-8 lg:grid-cols-2">
			<!-- Secretariat -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-primary/10 grid place-items-center text-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 7l11 5 9-4.09V17h2V7L12 2Zm0 8L3.74 7 12 3.74 20.26 7 12 10ZM2 19v2h20v-2H2Z"/></svg>
					</div>
					<h3 class="text-xl font-semibold">Festival Secretariat</h3>
				</div>
				<address class="not-italic mt-5 text-dark/80 leading-relaxed">
					Agenda 14,<br>
					#6B/9,<br>
					Pagoda Road,<br>
					Nugegoda 10250,<br>
					Sri Lanka
				</address>
			</div>

			<!-- Coordinating Office -->
			<div class="bg-white rounded-xl p-6 shadow-soft">
				<div class="flex items-center gap-3">
					<div class="w-10 h-10 rounded-full bg-primary/10 grid place-items-center text-primary">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2 1 7l11 5 9-4.09V17h2V7L12 2Zm0 8L3.74 7 12 3.74 20.26 7 12 10ZM2 19v2h20v-2H2Z"/></svg>
					</div>
					<h3 class="text-xl font-semibold">Coordinating Office</h3>
				</div>
				<address class="not-italic mt-5 text-dark/80 leading-relaxed">
					JAFFNAICF,<br>
					#71/2,<br>
					Kachcheri – Nallur Road,<br>
					Jaffna 40000,<br>
					Sri Lanka
				</address>
			</div>
		</div>
 
 		<div class="mt-10 bg-white rounded-xl p-2 md:p-3 shadow-soft">
 			<div class="container-full !px-0">
 				<h3 class="text-xl font-semibold px-6 pt-6">Map</h3>
 				<div class="mt-4 w-full h-96 rounded-lg overflow-hidden">
 					<iframe
 						src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7865.89652669783!2d80.023407!3d9.685457!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3afe5413b08972ff%3A0x4ad95ec009edba4e!2zRmFjdWx0eSBvZiBBcnRzIHwg4K6V4K6y4K-I4K6q4K-N4K6q4K-A4K6f4K6u4K-N!5e0!3m2!1sen!2slk!4v1763277899119!5m2!1sen!2slk"
 						width="100%"
 						height="100%"
 						style="border:0;"
 						allowfullscreen=""
 						loading="lazy"
 						referrerpolicy="no-referrer-when-downgrade">
 					</iframe>
 				</div>
 				<div class="px-6 py-4">
 					<a href="https://www.google.com/maps?q=9.685457,80.023407" target="_blank" rel="noopener" class="btn-outline">
 						Open in Google Maps
 					</a>
 				</div>
 			</div>
 		</div>
	</section>
@endsection


