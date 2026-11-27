@extends('layouts.app')

@section('title', 'Jury – Debut Films — ' . ($__site?->site_name ?? 'JaffnaICF'))
@section('meta_description', 'Jury – Debut Films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Jury – Debut Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Jury members for the Debut Films in Competition"
		:announce="true" />
@endsection


