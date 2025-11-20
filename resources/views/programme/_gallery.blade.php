@props(['title', 'year', 'active' => true, 'images' => collect(), 'description' => null])

<section class="container-full py-16">
	<h1 class="section-title">{{ $title }} @if($year) <span class="text-base md:text-lg font-normal align-middle ml-2 text-dark/60">{{ $year }}</span> @endif</h1>
	@if($description)
		<p class="mt-4 text-dark/70 max-w-2xl">{{ $description }}</p>
	@endif

	@if(!$active)
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
					Programme details for this section will be announced closer to the festival dates. Please check back soon.
				</p>
			</div>
		</div>
	@else
		@if($images->isEmpty())
			<p class="mt-8 text-dark/70">Images for this section will appear here once they are published.</p>
		@else
			@php
				$imageData = $images->map(function($img, $index) use ($title) {
					return [
						'path' => $img->image_path ? asset('storage/' . $img->image_path) : null,
						'alt' => $title . ' - Image ' . ($index + 1)
					];
				})->values()->toArray();
			@endphp
			<div class="mt-10 grid gap-6 grid-cols-1" 
				x-data="{ 
					openLightbox: false, 
					currentIndex: 0,
					images: @json($imageData),
					openImage(index) {
						this.currentIndex = index;
						this.openLightbox = true;
						document.body.style.overflow = 'hidden';
					},
					closeLightbox() {
						this.openLightbox = false;
						document.body.style.overflow = '';
					},
					nextImage() {
						if (this.images.length > 0) {
							this.currentIndex = (this.currentIndex + 1) % this.images.length;
						}
					},
					prevImage() {
						if (this.images.length > 0) {
							this.currentIndex = (this.currentIndex - 1 + this.images.length) % this.images.length;
						}
					}
				}" 
				@keydown.escape.window="if(openLightbox) closeLightbox()" 
				@keydown.arrow-right.window="if(openLightbox) nextImage()" 
				@keydown.arrow-left.window="if(openLightbox) prevImage()">
				@foreach($images as $image)
					<div class="bg-white rounded-xl overflow-hidden shadow-soft cursor-pointer hover:shadow-xl transition-all duration-300" @click="openImage({{ $loop->index }})">
						@if($image->image_path && file_exists(storage_path('app/public/' . $image->image_path)))
							<img 
								src="{{ asset('storage/' . $image->image_path) }}" 
								alt="{{ $title }} - Image {{ $loop->iteration }}" 
								class="w-full h-auto object-contain"
								loading="lazy"
							>
						@else
							<div class="text-center p-12 text-dark/40">
								<svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
								</svg>
								<p class="text-sm">Image {{ $loop->iteration }}</p>
								<p class="text-xs mt-1">Upload via admin</p>
							</div>
						@endif
					</div>
				@endforeach

				<!-- Lightbox Modal -->
				<div 
					x-show="openLightbox"
					x-cloak
					x-transition:enter="transition ease-out duration-300"
					x-transition:enter-start="opacity-0"
					x-transition:enter-end="opacity-100"
					x-transition:leave="transition ease-in duration-200"
					x-transition:leave-start="opacity-100"
					x-transition:leave-end="opacity-0"
					class="fixed inset-0 z-[100] bg-black/95 backdrop-blur-sm flex items-center justify-center p-4"
					@click.self="closeLightbox()"
				>
					<!-- Close Button -->
					<button 
						@click="closeLightbox()"
						class="absolute top-4 right-4 md:top-6 md:right-6 z-10 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors backdrop-blur-sm"
						aria-label="Close lightbox"
					>
						<svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
						</svg>
					</button>

					<!-- Previous Button -->
					<button 
						@click="prevImage()"
						class="absolute left-4 md:left-6 z-10 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors backdrop-blur-sm"
						aria-label="Previous image"
					>
						<svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
						</svg>
					</button>

					<!-- Next Button -->
					<button 
						@click="nextImage()"
						class="absolute right-4 md:right-6 z-10 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-white/10 hover:bg-white/20 text-white transition-colors backdrop-blur-sm"
						aria-label="Next image"
					>
						<svg class="w-6 h-6 md:w-7 md:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
						</svg>
					</button>

					<!-- Image Container -->
					<div class="relative max-w-7xl max-h-[90vh] w-full flex items-center justify-center" x-show="images[currentIndex]">
						<img 
							x-bind:src="images[currentIndex] ? images[currentIndex].path : ''" 
							x-bind:alt="images[currentIndex] ? images[currentIndex].alt : '{{ $title }} Image'"
							class="max-w-full max-h-[90vh] object-contain rounded-lg"
							@click.self="closeLightbox()"
						>
					</div>

					<!-- Image Counter -->
					<div class="absolute bottom-4 md:bottom-6 left-1/2 transform -translate-x-1/2 z-10 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm text-white text-sm">
						<span x-text="currentIndex + 1"></span> / <span x-text="images.length"></span>
					</div>
				</div>
			</div>
		@endif
	@endif
</section>


