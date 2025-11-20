@extends('layouts.app')

@section('title', 'Gallery — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Image gallery showcasing moments from the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<h1 class="section-title" data-aos="fade-up">Gallery</h1>
		<p class="mt-4 text-dark/70 max-w-2xl" data-aos="fade-up" data-aos-delay="100">
			Explore moments from the Jaffna International Cinema Festival through our image gallery.
		</p>

		@if($images->isEmpty())
			<div class="mt-10 text-center py-12">
				<p class="text-dark/70 text-lg">Gallery images will appear here once they are published.</p>
			</div>
		@else
			<div class="mt-10 grid gap-6" data-aos="fade-up" data-aos-delay="200">
				@foreach($images as $galleryItem)
					@php($allImages = $galleryItem->getAllImagePaths())
					@if(!empty($allImages))
						<div class="bg-white rounded-xl p-6 md:p-8 shadow-soft">
							@if($galleryItem->title)
								<h2 class="text-2xl md:text-3xl font-display font-bold mb-2">{{ $galleryItem->title }}</h2>
							@endif
							@if($galleryItem->description)
								<p class="text-dark/70 mb-6 max-w-3xl">{{ $galleryItem->description }}</p>
							@endif
							<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
								@foreach($allImages as $imagePath)
									<div class="group bg-white rounded-lg overflow-hidden shadow-soft hover:shadow-xl transition-all duration-300 border border-black/5">
										<div class="aspect-square bg-black/5 relative overflow-hidden">
											@if(file_exists(storage_path('app/public/' . $imagePath)))
												<img 
													src="{{ asset('storage/' . $imagePath) }}" 
													alt="{{ $galleryItem->title ?? 'Gallery Image ' . $loop->parent->iteration . '-' . $loop->iteration }}" 
													class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
													loading="lazy"
												>
											@else
												<div class="text-center p-4 text-dark/40 flex items-center justify-center h-full">
													<svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
													</svg>
												</div>
											@endif
										</div>
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

