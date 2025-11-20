@extends('layouts.app')

@section('title', 'Jury – Debut Films ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Jury for Debut Films from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.jury-debut-films"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="Jury – Debut Films"
			:year="$year"
			:active="$active"
			:images="$images"
			description="Jury members for Debut Films competition from {{ $year }} edition." />
	</section>
@endsection

