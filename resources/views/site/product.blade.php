@php
    use App\Models\Category;
    $name = 'name_'.app()->currentLocale();
    $content = 'content_'.app()->currentLocale();
    @endphp
@extends('site.master')


@section('title',"homepage")

@section('style')
<style>
.m-t-23, .m-tb-23, .m-all-23 {
    margin-top: 100px !important;
}</style>
@endsection
@section('content')


	<!-- Product -->
	<div class="bg0 m-t-23 p-b-140 ">
		<div class="container">
			<div class="flex-w flex-sb-m p-b-52">
				<div class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
						All Products
					</button>

                    @foreach ($categories as $item)
                    @php $real= str_replace(' ','',$item->$name);@endphp
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".{{$real}}">
						{{$item->$name}}
					</button>
                    @endforeach



				</div>



					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>

				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product" placeholder="Search">
					</div>
				</div>


			</div>

            <div class="container">
			<div class="row isotope-grid">

                @foreach ($all_product as $item)
                @php $real= str_replace(' ','',$item->category->$name);@endphp

                      <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$real}}">
                            <!-- Block2 -->
                            <div class="block2">
                                <div class="block2-pic hov-img0">
                                    <img  src="{{asset('uploads/'. $item->image)}}" alt="IMG-PRODUCT">

                                    <a href="#" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                        Quick View
                                    </a>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="{{route('site.product_detail',$item->id)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                            {{$item->$name}}
                                        </a>

                                        <span class="stext-105 cl3">
                                            @if ($item->sale_price)
                                                <span class="stext-105 cl3"><small><del>${{ $item->price }}</del></small>${{ $item->sale_price }}</span>
                                            @endif
                                        </span>
                                    </div>

                                    <div class="block2-txt-child2 flex-r p-t-3">
                                        <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                            <img class="icon-heart1 dis-block trans-04" src="{{asset('siteassets/images/icons/icon-heart-01.png')}}" alt="ICON">
                                            <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{asset('siteassets/images/icons/icon-heart-02.png')}}" alt="ICON">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                @endforeach



			</div>

        </div>

			<!-- Load more -->
			<div class="flex-c-m flex-w w-full p-t-45">
                <div class="nav_link">
				{{$all_product->links()}}
            </div>
			</div>


		</div>
	</div>

    @endsection
