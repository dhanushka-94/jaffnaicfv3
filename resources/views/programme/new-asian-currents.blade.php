@extends('layouts.app')

@section('title', 'PROGRAMME — NEW ASIAN CURRENTS – DOCUMENTARY')
@section('meta_description', 'New Asian Currents – Documentary image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="New Asian Currents – Documentary"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Documentary cinema from Asia that explores new voices, perspectives, and cinematic forms" />
@endsection


