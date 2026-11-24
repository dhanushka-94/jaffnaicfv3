@extends('layouts.app')

@section('title', 'Master Classes ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Master Classes from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.masterclasses"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="Master Classes"
			:year="$year"
			:active="$active"
			:images="$images"
			description="Filmmaker master classes and conversations from {{ $year }} edition" />
	</section>
@endsection

