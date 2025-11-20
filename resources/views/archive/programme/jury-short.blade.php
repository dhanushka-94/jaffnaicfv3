@extends('layouts.app')

@section('title', 'Jury – Short Films ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Jury for Short Films from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.jury-short-films"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="Jury – Short Films"
			:year="$year"
			:active="$active"
			:images="$images"
			description="Jury members for Short Films competition from {{ $year }} edition." />
	</section>
@endsection

