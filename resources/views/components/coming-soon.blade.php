@props([
    'message' => 'This part of the festival will be published closer to the dates. Please check back soon.',
])

<div {{ $attributes->merge(['class' => 'relative mt-10 overflow-hidden rounded-2xl border border-primary/20 bg-gradient-to-br from-dark via-dark/95 to-dark/90 p-8 text-center shadow-2xl md:p-14']) }} data-aos="fade-up">
	<div class="pointer-events-none absolute inset-0 opacity-10" aria-hidden="true" style="background-image: radial-gradient(circle at 2px 2px, rgba(197, 80, 44, 0.45) 1px, transparent 0); background-size: 36px 36px;"></div>
	<div class="relative z-10">
		<p class="text-xs font-semibold uppercase tracking-[0.28em] text-primary">JaffnaICF</p>
		<h2 class="mt-3 font-display text-3xl font-bold uppercase tracking-tight text-white md:text-5xl">Coming soon</h2>
		<div class="mx-auto mt-5 h-0.5 w-16 bg-primary"></div>
		<p class="mx-auto mt-5 max-w-xl text-base leading-relaxed text-white/80 md:text-lg">{{ $message }}</p>
	</div>
</div>
