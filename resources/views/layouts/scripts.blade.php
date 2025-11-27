@extends('layouts.backend')
@push('css')
	<!-- App css -->
	<link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/css/app-modern.min.css') }}" rel="stylesheet" type="text/css" id="light-style" />
	<link href="{{ asset('assets/css/app-modern-dark.min.css') }}" rel="stylesheet" type="text/css" id="dark-style" />
	<link href="{{ asset('assets/css/vendor/jquery.toast.scss') }}" rel="stylesheet" type="text/css"/>
	<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@endpush

@push('scripts')
	<!-- App js -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/metisMenu.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/moment.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/select2.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/simplebar.min.js') }}"></script>
	<script src="{{ asset('assets/js/layout.js') }}"></script>
	<script src="{{ asset('assets/js/hyper.js') }}"></script>

	<!-- plugins  -->
 	<script src="{{ asset('assets/js/vendor/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('assets/js/vendor/jquery.toast.js') }}"></script>
@endpush