@extends('layouts.app')

@section('title', 'PROGRAMME — NEW ASIAN CURRENTS')
@section('meta_description', 'New Asian Currents image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="New Asian Currents"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Asian cinema that explores new voices, perspectives, and cinematic forms." />
@endsection


