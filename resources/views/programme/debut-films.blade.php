@extends('layouts.app')

@section('title', 'PROGRAMME — DEBUT FILMS')
@section('meta_description', 'Debut films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Debut Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="First features and debut works presented in the festival programme." />
@endsection


