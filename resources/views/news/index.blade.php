@extends('layouts.app')

@php
	$siteName = $__site?->site_name ?? 'Jaffna International Cinema Festival';
	$seoTitle = 'News — '.$siteName;
	$seoDescription = 'Latest news, announcements, and updates from the Jaffna International Cinema Festival.';
	$canonical = route('news.index', request()->query());
	// Prefer clean canonical without page=1 noise
	if ((int) request('page', 1) <= 1) {
		$canonical = route('news.index');
	}
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('canonical', $canonical)
@section('og_type', 'website')
@section('og_title', $seoTitle)
@section('og_description', $seoDescription)
@section('og_url', $canonical)
@section('twitter_title', $seoTitle)
@section('twitter_description', $seoDescription)

@push('structured_data')
	<script type="application/ld+json">
		{!! json_encode([
			'@context' => 'https://schema.org',
			'@type' => 'CollectionPage',
			'name' => 'News',
			'description' => $seoDescription,
			'url' => route('news.index'),
			'isPartOf' => [
				'@type' => 'WebSite',
				'name' => $siteName,
				'url' => url('/'),
			],
			'breadcrumb' => [
				'@type' => 'BreadcrumbList',
				'itemListElement' => [
					[
						'@type' => 'ListItem',
						'position' => 1,
						'name' => 'Home',
						'item' => url('/'),
					],
					[
						'@type' => 'ListItem',
						'position' => 2,
						'name' => 'News',
						'item' => route('news.index'),
					],
				],
			],
			'mainEntity' => [
				'@type' => 'ItemList',
				'itemListElement' => $articles->getCollection()->values()->map(function ($article, $index) {
					return [
						'@type' => 'ListItem',
						'position' => $index + 1,
						'url' => route('news.show', $article),
						'name' => $article->title,
					];
				})->all(),
			],
		], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) !!}
	</script>
@endpush

@section('content')
	<section class="container-full py-16 md:py-20">
		<div class="max-w-3xl" data-aos="fade-up">
			<nav aria-label="Breadcrumb" class="mb-6 text-sm text-dark/55">
				<ol class="flex flex-wrap items-center gap-1.5">
					<li><a href="{{ route('home') }}" class="hover:text-primary transition">Home</a></li>
					<li aria-hidden="true">/</li>
					<li class="text-dark/80" aria-current="page">News</li>
				</ol>
			</nav>
			<h1 class="section-title">News</h1>
			<p class="mt-4 text-dark/70 text-lg">
				Announcements, festival updates, and stories from JAFFNA ICF.
			</p>
		</div>

		@if($articles->isEmpty())
			<div class="mt-12 text-center py-16 border border-dashed border-dark/15 rounded-xl" data-aos="fade-up">
				<p class="text-dark/60 text-lg">News articles will appear here once they are published.</p>
			</div>
		@else
			<div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
				@foreach($articles as $article)
					<article class="group flex flex-col bg-white border border-black/5 rounded-xl overflow-hidden shadow-soft hover:shadow-md transition-shadow duration-300" data-aos="fade-up" data-aos-delay="{{ min($loop->index * 50, 200) }}">
						<a href="{{ route('news.show', $article) }}" class="block aspect-[16/10] bg-secondary overflow-hidden">
							@if($article->feature_image_path)
								<img
									src="{{ asset('storage/' . $article->feature_image_path) }}"
									alt="{{ $article->title }}"
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
									loading="lazy"
								>
							@else
								<div class="w-full h-full grid place-items-center text-primary/40">
									<svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
									</svg>
								</div>
							@endif
						</a>
						<div class="flex flex-col flex-1 p-5 md:p-6">
							<time datetime="{{ $article->published_at?->toIso8601String() }}" class="text-xs uppercase tracking-wider text-primary font-medium">
								{{ $article->published_at?->format('M j, Y') }}
							</time>
							<h2 class="mt-2 text-xl font-display font-bold leading-snug">
								<a href="{{ route('news.show', $article) }}" class="hover:text-primary transition">
									{{ $article->title }}
								</a>
							</h2>
							@if($article->excerpt)
								<p class="mt-3 text-dark/70 text-sm leading-relaxed line-clamp-3">
									{{ $article->excerpt }}
								</p>
							@endif
							<a href="{{ route('news.show', $article) }}" class="mt-auto pt-5 inline-flex items-center gap-1 text-sm font-medium text-primary hover:text-accent transition">
								Read more
								<span aria-hidden="true">→</span>
							</a>
						</div>
					</article>
				@endforeach
			</div>

			@if($articles->hasPages())
				<div class="mt-12">
					{{ $articles->links() }}
				</div>
			@endif
		@endif
	</section>
@endsection
