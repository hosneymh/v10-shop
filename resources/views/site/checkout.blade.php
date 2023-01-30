@php
    use App\Models\Category;
    $name = 'name_'.app()->currentLocale();
    $content = 'content_'.app()->currentLocale();
    @endphp
@extends('site.master')


@section('title',"Checkout")

@section('content')


	<!-- breadcrumb -->
	<div class="container mt-5">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="{{route('site.home')}}" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Checkout
			</span>
		</div>
	</div>
<br>
<br>
        <div class="container">
                  <script src="https://eu-test.oppwa.com/v1/paymentWidgets.js?checkoutId={{$id}}"></script>
                  <form action="{{route('site.payment')}}" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>

        </div>




<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
    @endsection
