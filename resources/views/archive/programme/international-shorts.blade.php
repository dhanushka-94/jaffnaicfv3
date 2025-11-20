@extends('layouts.app')

@section('title', 'International Short Films ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'International Short Films from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.international-short-films"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="International Short Films"
			:year="$year"
			:active="$active"
			:images="$images"
			description="International short films in competition from {{ $year }} edition." />
	</section>
@endsection

