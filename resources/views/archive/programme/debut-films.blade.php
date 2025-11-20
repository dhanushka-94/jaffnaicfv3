@extends('layouts.app')

@section('title', 'Debut Films ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Debut films from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.debut-films"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="Debut Films"
			:year="$year"
			:active="$active"
			:images="$images"
			description="Debut films in competition from {{ $year }} edition." />
	</section>
@endsection

