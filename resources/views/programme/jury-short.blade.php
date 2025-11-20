@extends('layouts.app')

@section('title', 'PROGRAMME — JURY – SHORT FILMS')
@section('meta_description', 'Jury – Short Films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Jury – Short Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Jury members and moments from the Short Films jury of the festival." />
@endsection


