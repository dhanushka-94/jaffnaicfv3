@extends('layouts.app')

@section('title', 'PROGRAMME — NATIONAL SHORT FILMS')
@section('meta_description', 'National short films image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="National Short Films"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Sri Lankan short films presented in the national competition and programmes." />
@endsection


