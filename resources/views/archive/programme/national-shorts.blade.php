@extends('layouts.app')

@section('title', 'National Short Films ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'National Short Films from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.national-short-films"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="National Short Films"
			:year="$year"
			:active="$active"
			:images="$images"
			description="National short films in competition from {{ $year }} edition." />
	</section>
@endsection

