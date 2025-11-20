@extends('layouts.app')

@section('title', 'About — JAFFNAICF — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Learn about the Jaffna International Cinema Festival (JAFFNAICF).')

@section('content')
	<section class="container-full py-16">
		<h1 class="section-title" data-aos="fade-up">About JAFFNAICF</h1>
		<p class="mt-4 text-dark/70 max-w-3xl" data-aos="fade-up" data-aos-delay="100">
			The Jaffna International Cinema Festival (JAFFNAICF) celebrates cinema from South Asia and beyond, bringing together filmmakers, artists, and audiences in the historic city of Jaffna.
		</p>

		@if($images->isEmpty())
			<div class="mt-10 text-center py-12">
				<p class="text-dark/70 text-lg">Images will appear here once they are uploaded from the admin panel.</p>
			</div>
		@else
			<div class="mt-10 grid gap-6" data-aos="fade-up" data-aos-delay="200">
				@foreach($images as $image)
					<div class="bg-white rounded-xl overflow-hidden shadow-soft">
						@if($image->image_path && file_exists(storage_path('app/public/' . $image->image_path)))
							<img 
								src="{{ asset('storage/' . $image->image_path) }}" 
								alt="JAFFNAICF Image {{ $loop->iteration }}" 
								class="w-full h-auto object-contain"
								loading="lazy"
							>
						@else
							<div class="text-center p-12 text-dark/40">
								<svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
								</svg>
								<p class="text-sm">Image not found</p>
							</div>
						@endif
					</div>
				@endforeach
			</div>
		@endif
	</section>
@endsection

