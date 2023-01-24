@php
    use App\Models\Category;
    $name = 'name_' . app()->currentLocale();
    $content = 'content_' . app()->currentLocale();
@endphp
@extends('site.master')


@section('title', 'homepage')

@section('style')
    <style>
@import url(//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);

fieldset, label { margin: 0; padding: 0; }

h1 { font-size: 1.5em; margin: 10px; }

/****** Style Star Rating Widget *****/

.rating {
  border: none;
  float: left;
}

.rating > input { display: none; }
.rating > label:before {
  margin: 5px;
  font-size: 1.25em;
  font-family: FontAwesome;
  display: inline-block;
  content: "\f005";
}

.rating > .half:before {
  content: "\f089";
  position: absolute;
}

.rating > label {
  color: #ddd;
 float: right;
}

/***** CSS Magic to Highlight Stars on Hover *****/

.rating > input:checked ~ label, /* show gold star when clicked */
.rating:not(:checked) > label:hover, /* hover current star */
.rating:not(:checked) > label:hover ~ label { color: #FFD700;  } /* hover previous stars in list */

.rating > input:checked + label:hover, /* hover current star when changing rating */
.rating > input:checked ~ label:hover,
.rating > label:hover ~ input:checked ~ label, /* lighten current selection */
.rating > input:checked ~ label:hover ~ label { color: #FFED85;  }
    </style>
@endsection
@section('content')


    <!-- breadcrumb -->
    <div class="container" style="margin-top: 100px">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{ route('site.home') }}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <a href="{{ route('site.shop') }}" class="stext-109 cl8 hov-cl1 trans-04">
                {{ $product->category->$name }}
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>

            <span class="stext-109 cl4">
                {{ $product->$name }}
            </span>
        </div>
    </div>



    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">


                            <div class="slick3 gallery-lb">
                                <div class="item-slick3" data-thumb="{{ asset('uploads/' . $product->image) }}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{ asset('uploads/' . $product->image) }}" alt="IMG-PRODUCT">
                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                            href="{{ asset('siteassets/' . $product->image) }}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->$name }}
                        </h4>

                        <span class="mtext-106 cl2">
                            @if ($product->sale_price)
                                <span
                                    class="stext-105 cl3"><small><del>${{ $product->price }}</del></small>${{ $product->sale_price }}</span>
                            @endif
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {{ Str::words($product->$content, 50, '...') }}
                        </p>


                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                <i class="fs-16 zmdi zmdi-minus"></i>
                            </div>

                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                value="1">

                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                <i class="fs-16 zmdi zmdi-plus"></i>
                            </div>
                        </div>
                        <div class="flex-w flex-r-m p-b-10 mt-5">
                            <div class="size-204 flex-w flex-m respon6-next">
                                <button
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Add to cart
                                </button>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                        </li>



                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews
                                ({{ count($product->reviews) }})</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {{ $product->$content }}
                                </p>
                            </div>
                        </div>


                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <!-- Review -->
                                        @foreach ($product->reviews as $review)
                                            <div class="flex-w flex-t p-b-68">
                                                <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">
                                                    <img src="https://ui-avatars.com/api/?name={{ $review->user->name }}"
                                                        alt="AVATAR">
                                                </div>

                                                <div class="size-207">
                                                    <div class="flex-w flex-sb-m p-b-17">
                                                        <span class="mtext-107 cl2 p-r-20">
                                                            {{ $review->user->name }}
                                                        </span>

                                                        <span class="fs-18 cl11">
                                                            <i>{{ $review->star / 2 }}</i>
                                                            <i class="zmdi zmdi-star"></i>

                                                        </span>
                                                    </div>

                                                    <p class="stext-102 cl6">
                                                        {{ $review->content }}
                                                    </p>
                                                </div>
                                            </div>
                                        @endforeach


                                        <!-- Add review -->
                                        <form action="{{ route('site.review', $product->id) }}" method="POST"
                                            class="w-full">
                                            @csrf
                                            <h5 class="mtext-108 cl2 p-b-7">
                                                Add a review
                                            </h5>

                                            <p class="stext-102 cl6">
                                                Your email address will not be published. Required fields are marked *
                                            </p>

                                            <div class="flex-w flex-m p-t-50 p-b-23">
                                                <span class="stext-102 cl3 m-r-16">
                                                    Your Rating
                                                </span>

                                                <span class="wrap-rating fs-18 cl11 pointer">
                                                    <fieldset class="rating">
                                                        <input type="radio" id="star5" name="rating"
                                                            value="10" /><label class="full" for="star5"
                                                            title="Awesome - 5 stars"></label>
                                                        <input type="radio" id="star4half" name="rating"
                                                            value="9" /><label class="half" for="star4half"
                                                            title="Pretty good - 4.5 stars"></label>
                                                        <input type="radio" id="star4" name="rating"
                                                            value="8" /><label class="full" for="star4"
                                                            title="Pretty good - 4 stars"></label>
                                                        <input type="radio" id="star3half" name="rating"
                                                            value="7" /><label class="half" for="star3half"
                                                            title="Meh - 3.5 stars"></label>
                                                        <input type="radio" id="star3" name="rating"
                                                            value="6" /><label class="full" for="star3"
                                                            title="Meh - 3 stars"></label>
                                                        <input type="radio" id="star2half" name="rating"
                                                            value="5" /><label class="half" for="star2half"
                                                            title="Kinda bad - 2.5 stars"></label>
                                                        <input type="radio" id="star2" name="rating"
                                                            value="4" /><label class="full" for="star2"
                                                            title="Kinda bad - 2 stars"></label>
                                                        <input type="radio" id="star1half" name="rating"
                                                            value="3" /><label class="half" for="star1half"
                                                            title="Meh - 1.5 stars"></label>
                                                        <input type="radio" id="star1" name="rating"
                                                            value="2" /><label class="full" for="star1"
                                                            title="Sucks big time - 1 star"></label>
                                                        <input type="radio" id="starhalf" name="rating"
                                                            value="1" /><label class="half" for="starhalf"
                                                            title="Sucks big time - 0.5 stars"></label>

                                                    </fieldset>
                                                </span>
                                            </div>

                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Your review</label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review"></textarea>
                                                </div>
                                                    

                                            </div>

                                            <button
                                                class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Submit
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">


            <span class="stext-107 cl6 p-lr-25">
                Categories: {{ $product->category->$name }}
            </span>
        </div>
    </section>


    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
        <div class="container">
            <div class="p-b-45">
                <h3 class="ltext-106 cl5 txt-center">
                    Related Products
                </h3>
            </div>

            <!-- Slide2 -->
            <div class="wrap-slick2">
                <div class="slick2">

                    @foreach ($all_product as $prod)
                        <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img src="{{ asset('uploads/' . $prod->image) }}" alt="IMG-PRODUCT">

                                    <a href="{{ route('site.product_detail', $prod->id) }}"
                                        class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="{{ route('site.product_detail', $prod->id) }}"
                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{ $prod->$name }}
                                        </a>

                                        @if ($prod->sale_price)
                                            <span
                                                class="stext-105 cl3"><small><del>${{ $prod->price }}</del></small>${{ $prod->sale_price }}</span>
                                        @endif
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04"
                                                src="{{ asset('siteassets/images/icons/icon-heart-01.png') }}"
                                                alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                src="{{ asset('siteassets/images/icons/icon-heart-02.png') }}"
                                                alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>


            </div>
            {{ $all_product->links() }}
        </div>
    </section>

@endsection
