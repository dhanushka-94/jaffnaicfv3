@extends('layouts.app')

@section('title', 'New Asian Currents ' . $year . ' — ' . ($__site?->site_name ?? 'Jaffna International Cinema Festival'))
@section('meta_description', 'New Asian Currents from ' . $year . ' edition of the Jaffna International Cinema Festival.')

@section('content')
	<section class="container-full py-16">
		<x-year-selector 
			:currentYear="$currentYear"
			:selectedYear="$year"
			:availableYears="$availableYears"
			routeName="archive.programme.new-asian-currents"
			:routeParams="['year' => $year]"
		/>
		<x-programme.gallery
			title="New Asian Currents"
			:year="$year"
			:active="$active"
			:images="$images"
			description="New Asian Currents programme from {{ $year }} edition." />
	</section>
@endsection

