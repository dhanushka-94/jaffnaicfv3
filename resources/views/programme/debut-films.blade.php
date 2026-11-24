@extends('layouts.app')

@section('title', 'PROGRAMME — DEBUT FILMS IN COMPETITION')
@section('meta_description', 'Debut Films in Competition image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Debut Films in Competition"
		:year="$year"
		:active="$active"
		:images="$images"
		description="First features and debut works presented in the festival programme" />
@endsection


