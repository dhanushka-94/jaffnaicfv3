@extends('layouts.app')

@section('title', 'PROGRAMME — MASTER CLASSES')
@section('meta_description', 'Master Classes image gallery for the current edition of the Jaffna International Cinema Festival.')

@section('content')
	<x-programme.gallery
		title="Master Classes"
		:year="$year"
		:active="$active"
		:images="$images"
		description="Filmmaker master classes and conversations presented during this year's festival" />
@endsection


