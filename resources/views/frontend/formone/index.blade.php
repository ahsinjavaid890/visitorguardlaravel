@include('frontend.companypages.includes.mettatittle')
@extends('frontend.layouts.maintwo')
@section('content')
<script type="text/javascript" src="{{ url('public/front/daterangepicker/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ url('public/front/daterangepicker/moment.min.js')}}"></script>
<script type="text/javascript" src="{{ url('public/front/daterangepicker/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('public/front/daterangepicker/daterangepicker.css')}}" />
<!-- <link rel="stylesheet" type="text/css" href="{{ url('public/front/css/bootstraptwo.min.css')}}"> -->
<link rel="stylesheet" type="text/css" href="{{ url('public/front/css/essentials.css')}}">
<link rel="stylesheet" type="text/css" href="{{ url('public/front/css/tab_style.css') }}">
<style type="text/css">
	@media only screen and (max-width: 600px)
	{
		.col-xs-6{
			width: 50% !important;
		}
		.col-xs-4 {
		    width: 33%;
		    padding: 0 5px !important;
		}
		.hidden-xs{
			display: none;
		}
	}
</style>
<section class="tabshead" style="margin-top: -20px">
	<div class="container">
		<div class="row tabs">
			<div class="col-md-4 col-xs-4 text-center information_qoutes">
				<button class="btn active">
					<i class="fa fa-user"></i> Information
				</button>
			</div>
			<div class="col-md-4 col-xs-4 text-center price_qoutes">
				<button class="btn ">
					<i class="fa fa-shopping-cart"></i> Quotes
				</button>
			</div>
			<div class="col-md-4 col-xs-4 text-center apply_qoutes">
				<button class="btn ">
					<i class="fa fa-edit"></i> Apply / Buy
				</button>
			</div>
		</div>
	</div>
</section>

<section class="tabscontent">
	@if($fields['form_layout'] == 'layout_1')
		@include('frontend.formone.includes.formlayoutone')
	@elseif($fields['form_layout'] == 'layout_2')
		@include('frontend.formone.includes.formlayouttwo')
	@elseif($fields['form_layout'] == 'layout_3')
		@include('frontend.formone.includes.formlayoutthree')
	@elseif($fields['form_layout'] == 'layout_4')
		@include('frontend.formone.includes.formlayoutfour')
	@elseif($fields['form_layout'] == 'layout_5')
		@include('frontend.formone.includes.formlayoutfive')
	@elseif($fields['form_layout'] == 'layout_6')
		@include('frontend.formone.includes.formlayoutsix')
	@elseif($fields['form_layout'] == 'layout_7')
		@include('frontend.formone.includes.formlayoutseven')
	@endif
</section>
@endsection