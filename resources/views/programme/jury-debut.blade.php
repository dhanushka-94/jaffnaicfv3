@extends('layouts.app')

@section('title', 'PROGRAMME — JURY – DEBUT FILMS')
@section('meta_description', 'Jury – Debut Films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Jury – Debut Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Jury members and moments from the Debut Films jury of the festival." />
@endsection


