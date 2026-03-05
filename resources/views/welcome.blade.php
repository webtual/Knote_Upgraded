@extends('layouts._landing_master')
@section('title', 'Knote - Home')
@section('content')
	  
	@include('partials.user.slider_section')
	<main id="main">
		@include('partials.user.service_section')
		@include('partials.user.business_proposal_section')
		@include('partials.user.resource_section')
		@include('partials.user.blog_section')
		@include('partials.user.contact_section')
	</main>
@endsection

@section('scripts')

@endsection