@extends('layouts.app')

@section('title', 'PROGRAMME — SCHEDULE')
@section('meta_description', 'Festival schedule image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Schedule"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Screenings, events, and special programmes for this year's festival." />
@endsection


