@extends('layouts.app')

@section('title', 'Schedule ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Festival schedule from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.schedule"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="Schedule"
			:year="$year"
			:active="$active"
			:images="$images"
			description="Festival schedule and programme timeline from {{ $year }} edition." />
	</section>
@endsection

