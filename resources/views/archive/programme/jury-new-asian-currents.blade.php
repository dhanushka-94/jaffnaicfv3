@extends('layouts.app')

@section('title', 'Jury – New Asian Currents (Documentary) ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'Jury for New Asian Currents – Documentary from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.jury-new-asian-currents"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="Jury – New Asian Currents (Documentary)"
			:year="$year"
			:active="$active"
			:images="$images"
			description="Jury members for New Asian Currents – Documentary from {{ $year }} edition" />
	</section>
@endsection

