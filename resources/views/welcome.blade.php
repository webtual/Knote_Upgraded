@extends('layouts._landing_master')
@section('title', 'Knote - Home')
@section('content')

	@include('partials.user.slider_section')
	<main id="main">
		@include('partials.user.service_section')
	</main>
@endsection

@section('scripts')

@endsection