@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = get_setting('meta_title');
        $meta_description = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

    <section class="mb-4 pt-3">
        <div class="container sm-px-0">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">
                    <div class="col-xl-3">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
                                data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left">
                                <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb"
                                        data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div>
                                {{-- Category --}}
                                <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom categoryheader">
                                        {{ translate('Categories') }}
                                    </div>
                                    {{-- <div class="p-3">

                                    </div> --}}
                                    <ul class="list-unstyled">
                                        @foreach (\App\Category::where('level', 0)->get() as $category)
                                            <li class="py-2 categoryList">
                                                <a class="text-reset fs-18"
                                                   href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9">
                        @if($products->count() > 0)
                        <div class="row" id="post_data">
                            @foreach ($nonPagisateProducts as $key => $product)
                                <div class="col-md-3 mb-3 product_card_padding">
                                    <div class="carousel-box single_product_card">
                                        <div class="aiz-card-box rounded border-radius-5">
                                            <div class="position-relative">
                                                <a href="{{ route('product', $product->slug) }}" class="d-block">
                                                    <img
                                                        class="img-fit lazyload mx-auto h-140px h-md-130px px-10px pt-10px"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                        alt="{{  $product->getTranslation('name')  }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                                <div class="absolute-top-right aiz-p-hov-icon">
                                                    <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                                        <i class="la la-heart-o"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                                        <i class="las la-sync"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                        <i class="las la-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="py-md-3 p-1 py-2 p-md-1 text-center">
                                                <h3 class="fw-600 fs-15 text-truncate-2 lh-1-4 mb-0 h-35px">
                                                    <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  Str::limit($product->getTranslation('name'), 10)  }}</a>
                                                </h3>

                                                <div class="fs-16 mx-5 d-flex align-items-center justify-content-center">
                                                    <span class="fw-700 text-black">{{ home_discounted_base_price($product->id) }}</span>
                                                </div>

                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated)
                                                    <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                                                        {{ translate('Club Point') }}:
                                                        <span class="fw-700 float-right">{{ $product->earn_point }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-4">
                            <button class="btn LoadMore bg-main text-white"
                            id="loadMore"
                            type="button"
                            data-id="{{ $nonPagisateProducts->last()->id }}">Load More Product {{ $nonPagisateProducts->last()->id }}</button>
                        </div>
                        @else
                            <h2 class="d-flex align-items-center justify-content-center h-300px w-100">No Product Found</h2>
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </section>


    <div class="container" id="whyChoseUs">
        <div class="row category">
            <div class="col-md-12">
                <div class="title text-center">
                    <h4>Over The Counter Products</h4>
                </div>
            </div>
        </div>
        <div class="common-hr"></div>
        <div class="row">
            @include('frontend.partials.page_category_section')
        </div>
        <div class="common-hr"></div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        function filter() {
            $('#search-form').submit();
        }

        function rangefilter(arg) {
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>



<script>
     var _token = $('input[name="csrf-token"]').val();

    $(document).on('click','#loadMore',function (e) {

        e.preventDefault();
        var id = $(this).data('id');
        loadMoredata(id, _token);
        console.log(id)
        console.log(_token)
    });

    function loadMoredata(id="", _token){
        $.ajax({
                url:"{{ route('loadmore.load_data') }}",
                method:"POST",
                data:{request_product_id:id, _token:"{{ csrf_token() }}"},
                beforeSend:function(){
                    $('#loadMore').html('Loding.........'); //s
                },
                success:function(data)
                {
                    console.log(data);
                    $('#loadMore').html('Load more');
                    var len = data.length;
                    data.forEach(function (value, id) {
                        console.log(id);
                        if (id === (len - 1)){
                            $('#loadMore').data('id', value.id); //setter
                        }
                        $('#post_data').append(`

                                <div class="col-md-3 mb-3 product_card_padding">
                                    <div class="carousel-box single_product_card">
                                        <div class="aiz-card-box rounded border-radius-5">
                                            <div class="position-relative">
                                                <a href="#" class="d-block">
                                                    <img
                                                        class="img-fit lazyload mx-auto h-140px h-md-130px px-10px pt-10px"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src=""
                                                        alt="$product->getTranslation(${value.name})"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                    >
                                                </a>
                                                <div class="absolute-top-right aiz-p-hov-icon">
                                                    <a href="javascript:void(0)" onclick="addToWishList({${value.id})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                                                        <i class="la la-heart-o"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="addToCompare(${value.id})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                                                        <i class="las la-sync"></i>
                                                    </a>
                                                    <a href="javascript:void(0)" onclick="showAddToCartModal( ${value.id})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                                                        <i class="las la-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                    </div>
                </div>
            </div>




`);
                    })
                }
            })
    }

</script>


@endsection
