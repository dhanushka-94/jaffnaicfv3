@extends('layouts.app')

@section('title', 'Jury – Short Films — ' . ($__site?->site_name ?? 'JaffnaICF'))
@section('meta_description', 'Jury – Short Films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Jury – Short Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="One jury for both the International and National Short Films competitions"
		:announce="true" />
@endsection


