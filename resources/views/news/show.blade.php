@extends('layouts.app')

@php
	$siteName = $__site?->site_name ?? 'Jaffna International Cinema Festival';
	$seoTitle = $article->seoTitle($siteName);
	$seoDescription = $article->seoDescription();
	$seoImage = $article->seoImageUrl();
	$canonical = $article->canonicalUrl();
@endphp

@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('canonical', $canonical)
@section('og_type', 'article')
@section('og_title', $seoTitle)
@section('og_description', $seoDescription)
@section('og_url', $canonical)
@section('og_image', $seoImage)
@section('og_image_alt', $article->title)
@section('twitter_title', $seoTitle)
@section('twitter_description', $seoDescription)
@section('twitter_image', $seoImage)
@section('twitter_image_alt', $article->title)
@section('article_published_time', $article->published_at?->toIso8601String() ?? '')
@section('article_modified_time', ($article->updated_at ?? $article->published_at)?->toIso8601String() ?? '')
@section('article_section', 'News')

@push('head')
	@if($article->seoKeywords())
		<meta name="keywords" content="{{ $article->seoKeywords() }}">
	@endif
@endpush

@push('structured_data')
	<script type="application/ld+json">
		{!! json_encode([
			'@context' => 'https://schema.org',
			'@type' => 'NewsArticle',
			'headline' => $article->title,
			'description' => $seoDescription,
			'image' => [$seoImage],
			'datePublished' => optional($article->published_at)->toIso8601String(),
			'dateModified' => optional($article->updated_at ?? $article->published_at)->toIso8601String(),
			'mainEntityOfPage' => [
				'@type' => 'WebPage',
				'@id' => $canonical,
			],
			'author' => [
				'@type' => 'Organization',
				'name' => $siteName,
				'url' => url('/'),
			],
			'publisher' => [
				'@type' => 'Organization',
				'name' => $siteName,
				'logo' => [
					'@type' => 'ImageObject',
					'url' => $__site?->logo_path ? asset('storage/' . $__site->logo_path) : asset('images/og-default.jpg'),
				],
			],
			'articleSection' => 'News',
			'inLanguage' => str_replace('_', '-', app()->getLocale()),
			'url' => $canonical,
		], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) !!}
	</script>
	<script type="application/ld+json">
		{!! json_encode([
			'@context' => 'https://schema.org',
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
				[
					'@type' => 'ListItem',
					'position' => 3,
					'name' => $article->title,
					'item' => $canonical,
				],
			],
		], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_AMP) !!}
	</script>
@endpush

@section('content')
	<article class="container-full py-16 md:py-20" itemscope itemtype="https://schema.org/NewsArticle">
		<meta itemprop="headline" content="{{ $article->title }}">
		<meta itemprop="description" content="{{ $seoDescription }}">
		<meta itemprop="image" content="{{ $seoImage }}">
		<meta itemprop="mainEntityOfPage" content="{{ $canonical }}">
		@if($article->published_at)
			<meta itemprop="datePublished" content="{{ $article->published_at->toIso8601String() }}">
		@endif
		<meta itemprop="dateModified" content="{{ ($article->updated_at ?? $article->published_at)?->toIso8601String() }}">

		<div class="max-w-3xl mx-auto" data-aos="fade-up">
			<nav aria-label="Breadcrumb" class="mb-6 text-sm text-dark/55">
				<ol class="flex flex-wrap items-center gap-1.5">
					<li><a href="{{ route('home') }}" class="hover:text-primary transition">Home</a></li>
					<li aria-hidden="true">/</li>
					<li><a href="{{ route('news.index') }}" class="hover:text-primary transition">News</a></li>
					<li aria-hidden="true">/</li>
					<li class="text-dark/80 line-clamp-1" aria-current="page">{{ $article->title }}</li>
				</ol>
			</nav>

			<a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-accent transition mb-8">
				<span aria-hidden="true">←</span>
				Back to News
			</a>

			<time datetime="{{ $article->published_at?->toIso8601String() }}" class="block text-xs uppercase tracking-wider text-primary font-medium">
				{{ $article->published_at?->format('F j, Y') }}
			</time>
			<h1 class="mt-3 text-3xl md:text-4xl lg:text-5xl font-display font-bold leading-tight" itemprop="headline">
				{{ $article->title }}
			</h1>
			@if($article->excerpt)
				<p class="mt-5 text-lg md:text-xl text-dark/70 leading-relaxed">
					{{ $article->excerpt }}
				</p>
			@endif
		</div>

		@if($article->feature_image_path)
			<div class="mt-10 max-w-4xl mx-auto rounded-xl overflow-hidden bg-secondary shadow-soft" data-aos="fade-up" data-aos-delay="50">
				<img
					src="{{ asset('storage/' . $article->feature_image_path) }}"
					alt="{{ $article->title }}"
					class="w-full h-auto object-cover max-h-[520px]"
					itemprop="image"
				>
			</div>
		@endif

		<div class="mt-10 max-w-3xl mx-auto news-content" data-aos="fade-up" data-aos-delay="100" itemprop="articleBody">
			{!! $article->content !!}
		</div>

		<div itemprop="author" itemscope itemtype="https://schema.org/Organization" class="sr-only">
			<meta itemprop="name" content="{{ $siteName }}">
			<link itemprop="url" href="{{ url('/') }}">
		</div>
		<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization" class="sr-only">
			<meta itemprop="name" content="{{ $siteName }}">
		</div>
	</article>

	@if($related->isNotEmpty())
		<section class="container-full pb-16 md:pb-20">
			<div class="max-w-5xl mx-auto">
				<h2 class="section-title text-2xl md:text-3xl" data-aos="fade-up">More News</h2>
				<div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
					@foreach($related as $item)
						<a href="{{ route('news.show', $item) }}" class="group block border border-black/5 rounded-xl overflow-hidden bg-white shadow-soft hover:shadow-md transition-shadow" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
							<div class="aspect-[16/10] bg-secondary overflow-hidden">
								@if($item->feature_image_path)
									<img src="{{ asset('storage/' . $item->feature_image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
								@endif
							</div>
							<div class="p-4">
								<time class="text-xs uppercase tracking-wider text-primary">{{ $item->published_at?->format('M j, Y') }}</time>
								<h3 class="mt-1 font-display font-bold text-lg group-hover:text-primary transition">{{ $item->title }}</h3>
							</div>
						</a>
					@endforeach
				</div>
			</div>
		</section>
	@endif
@endsection
