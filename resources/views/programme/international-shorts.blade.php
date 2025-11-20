@extends('layouts.app')

@section('title', 'PROGRAMME — INTERNATIONAL SHORT FILMS')
@section('meta_description', 'International short films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="International Short Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="International short films presented in the festival programme." />
@endsection


