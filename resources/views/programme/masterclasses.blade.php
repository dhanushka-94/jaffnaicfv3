@extends('layouts.app')

@section('title', 'PROGRAMME — MASTERCLASSES')
@section('meta_description', 'Masterclasses image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Masterclasses"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Filmmaker masterclasses and conversations presented during this year's festival." />
@endsection


