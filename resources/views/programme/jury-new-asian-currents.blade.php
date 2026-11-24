@extends('layouts.app')

@section('title', 'PROGRAMME — JURY – NEW ASIAN CURRENTS (DOCUMENTARY)')
@section('meta_description', 'Jury for New Asian Currents – Documentary at the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Jury – New Asian Currents (Documentary)"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Jury members for the New Asian Currents – Documentary competition"
		:announce="true" />
@endsection