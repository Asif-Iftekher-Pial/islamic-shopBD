@extends('frontend.layouts.app')

@section('content')
<div class="home-banner-area mb-4 pt-3">
    <div class="container">
        <div class="row gutters-10">

            <div class="col-lg-12">
                <div class="position-relative ">
                    <div class="position-absolute left-7 right-0 d-none d-lg-block" style="z-index: 999;">
                        {{-- @include('frontend.partials.category_menu') --}}
                    </div>
                    @if (get_setting('home_slider_images') != null)
                        <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true" data-dots="true" data-autoplay="true" data-infinite="true">
                            @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                            @foreach ($slider_images as $key => $value)
                                <div class="carousel-box">
                                    <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                        <img
                                            class="d-block mw-100 img-fit rounded shadow-sm"
                                            src="{{ uploaded_asset($slider_images[$key]) }}"
                                            alt="{{ env('APP_NAME')}} promo"
                                            height="277"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                        >
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
           
            <div class="col-lg-12">
              
                @php
                    $featured_categories = \App\Category::where('featured', 1)->get();
                @endphp
                @if (count($featured_categories) > 0)
                    <ul class="list-unstyled mb-0 row gutters-5">
                        @foreach ($featured_categories as $key => $category)
                            <li class="minw-0 col-4 col-md mt-3">
                                <a href="{{ route('products.category', $category->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="{{ uploaded_asset($category->banner) }}"
                                        alt="{{ $category->getTranslation('name') }}"
                                        class="lazyload img-fit"
                                        height="78"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    >
                                    <div class="text-truncate fs-12 fw-600 mt-2 opacity-70">{{ $category->getTranslation('name') }}</div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>


        </div>
    </div>
</div>


    {{-- Banner section 1 --}}

    {{-- @if (get_setting('home_banner1_images') != null)
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10 text-center">
                @php $banner_1_imags = json_decode(get_setting('home_banner1_images')); @endphp
                @foreach ($banner_1_imags as $key => $value)
                    <div class="col">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner1_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_1_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif --}}

    
        <div class="container banner_fetures">
            <div class="row banner_main_row">
                <div class="col-6">
                    <div class="card">
                        <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                    </div>
                </div>

                <div class="col-6">
                    <div class="row banner_row_top">
                        <div class="col">
                           
                            <div class="card left-card-image">
                                <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="" style="height: 65%;">
                            </div>
                        </div>
                    </div>
                    <div class="row banner_row_bottom">
                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   
    {{-- <div class="container">
        <div class="row">
          <div class="col">
            first col
          </div>
        </div>
        <div class="row">
          <div class="col">

                    <div class="col-6">
                        <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                    </div>

                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                            </div>
                                <div class="col">
                                    <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                                </div>
                                <div class="col">
                                    <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                                </div>
                                <div class="col">
                                    <img src="{{ asset('offline_banner.jpg') }}" alt="" srcset="">
                                </div>

                        </div>
                    </div>
            1 of 3
          </div>
          <div class="col">
            2 of 3
          </div>
          <div class="col">
            3 of 3
          </div>
        </div>
      </div> --}}


    {{-- Flash Deal --}}
    @php
        $flash_deal = \App\FlashDeal::where('status', 1)->where('featured', 1)->first();
    @endphp
    @if($flash_deal != null && strtotime(date('Y-m-d H:i:s')) >= $flash_deal->start_date && strtotime(date('Y-m-d H:i:s')) <= $flash_deal->end_date)
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">

                <div class="d-flex flex-wrap align-items-baseline">
                    <h3 class="h5 fw-700 mb-0">
                        <span class="pb-3 d-inline-block">{{ translate('Flash Sale') }}</span>
                    </h3>
                    <div class="aiz-count-down mx-auto align-items-center mr-5 mb-2" data-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                    <a href="{{ route('flash-deal-details', $flash_deal->slug) }}" class="mr-0 btn bg-matt text-white btn-sm shadow-md w-100 w-md-auto">{{ translate('VIEW ALL') }}</a>
                </div>

                <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                    @foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product)
                        @php
                            $product = \App\Product::find($flash_deal_product->product_id);
                        @endphp
                        @if ($product != null && $product->published != 0)
                            <div class="carousel-box">
                                <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                    <div class="position-relative">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                            <img
                                                class="img-fit lazyload mx-auto h-140px h-md-210px"
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
                                    <div class="p-md-3 p-2 text-left">
                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                        </h3>
                                        {{-- <div class="rating rating-sm mt-1">
                                            {{ renderStarRating($product->rating) }}
                                        </div> --}}
                                        <div class="fs-15">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
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
                        @endif
                        @php
                            if($loop->index > 13) {
                                break;
                            }
                        @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
    
        {{-- Best Selling  --}}
    <div id="section_best_selling">

    </div>
    
        {{-- Banner Section 2 --}}
    @if (get_setting('home_banner2_images') != null)
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @php $banner_2_imags = json_decode(get_setting('home_banner2_images')); @endphp
                @foreach ($banner_2_imags as $key => $value)
                    <div class="col-xl-2 col-md-2 col-sm-6 col-6">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner2_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_2_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    
    {{-- Banner Section 2 --}}
    @if (get_setting('home_banner3_images') != null)
    <div class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @php $banner_3_imags = json_decode(get_setting('home_banner3_images')); @endphp
                @foreach ($banner_3_imags as $key => $value)
                    <div class="col">
                        <div class="mb-3 mb-lg-0">
                            <a href="{{ json_decode(get_setting('home_banner3_links'), true)[$key] }}" class="d-block text-reset">
                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}" data-src="{{ uploaded_asset($banner_3_imags[$key]) }}" alt="{{ env('APP_NAME') }} promo" class="img-fluid lazyload">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Top 10 categories --}}
    <section class="mb-4">
        <div class="container">
            <div class="row gutters-10">
                @if (get_setting('top10_categories') != null)
                    <div class="col-lg-12">
                        <div class="d-flex align-items-baseline">
                            <h3 class="h5 fw-700 mb-0">
                                <span class="pb-3 d-inline-block">{{ translate('Top Categories') }}</span>
                            </h3>
                            <a href="{{ route('categories.all') }}" class="ml-auto mr-0 btn bg-matt text-white btn-sm shadow-md">{{ translate('View All') }}</a>
                        </div>
                        <div class="row gutters-5">
                            @php $top10_categories = json_decode(get_setting('top10_categories')); @endphp
                            @foreach ($top10_categories as $key => $value)
                                @php $category = \App\Category::find($value); @endphp
                                @if ($category != null)
                                    <div class="col-6 col-sm-4 col-md-2 col-lg-2">
                                        <a href="{{ route('products.category', $category->slug) }}" class="d-block p-3">
                                            <img
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($category->banner) }}"
                                                alt="{{ $category->getTranslation('name') }}"
                                                class="img-fluid lazyload"
                                            >
                                        </a>
                                        <h2 class="h6 fw-600 text-truncate text-center">
                                            <a href="{{ route('products.category', $category->slug) }}" class="text-reset">{{ $category->getTranslation('name') }}</a>
                                        </h2>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    
    <div id="new_arrival">
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('New Arrival') }}</span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-rows="2" data-items="5" data-xl-items="5" data-lg-items="5"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                        @foreach (filter_products(\App\Product::where('published', 1)->orderBy('id', 'desc')->limit(20))->get() as $key => $product)
                            <div class="carousel-box">
                                <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                    <div class="position-relative">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                            <img
                                                class="img-fit lazyload mx-auto h-140px h-md-210px"
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
                                    <div class="p-md-3 p-2 text-left">
                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                        </h3>
                                        {{-- <div class="rating rating-sm mt-1">
                                            {{ renderStarRating($product->rating) }}
                                        </div> --}}
                                        <div class="fs-15">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
    
    
    <div id="just_for_you">
        <section class="mb-4">
            <div class="container">
                <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                    <div class="d-flex mb-3 align-items-baseline border-bottom">
                        <h3 class="h5 fw-700 mb-0">
                            <span class="border-bottom border-primary border-width-2 pb-3 d-inline-block">{{ translate('Just For You') }}</span>
                        </h3>
                    </div>
                    <div class="aiz-carousel gutters-10 half-outside-arrow" data-rows="4" data-items="5" data-xl-items="5" data-lg-items="5"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='true'>
                        @foreach (filter_products(\App\Product::where('published', 1)->inRandomOrder()->limit(30))->get() as $key => $product)
                            <div class="carousel-box">
                                <div class="aiz-card-box border border-light rounded hov-shadow-md my-2 has-transition">
                                    <div class="position-relative">
                                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                                            <img
                                                class="img-fit lazyload mx-auto h-140px h-md-210px"
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
                                    <div class="p-md-3 p-2 text-left">
                                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
                                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
                                        </h3>
                                        {{-- <div class="rating rating-sm mt-1">
                                            {{ renderStarRating($product->rating) }}
                                        </div> --}}
                                        <div class="fs-15">
                                            @if(home_base_price($product->id) != home_discounted_base_price($product->id))
                                                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product->id) }}</del>
                                            @endif
                                            <span class="fw-700 text-primary">{{ home_discounted_base_price($product->id) }}</span>
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
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>

    
    <div class="container">
        <div></div>
        <div class="d-flex flex-row">
            <div class="col-6">
                <h4>প্রেসক্রিপশন এর মাধ্যমে অর্ডার করুন</h4>
                <ul class="list-group">
                    <li class="list-group-item"> <h5>১. প্রেসক্রিপশন এর ছবি তুলে অথবা স্ক্যান করে আপলোড করুন।</h5></li>
                    <li class="list-group-item"><h5>২. আমাদের ফার্মাসিস্ট আপনার প্রেসক্রিপশন পেয়ে আপনার দেয়া ফোন নাম্বারে যোগাযোগ করবে। ( সকাল ১০টা থেকে রাত ১০টা )</h5></li>
                    <li class="list-group-item"> <h5>৩. ফার্মাসিস্ট আপনার সাথে কথা বলে ঔষধ সিলেক্ট করে অর্ডার কনফার্ম করবে।</h5></li>
                    <li class="list-group-item"><h5>৪. নির্দিষ্ট সময়ে আপনার ঔষধ/পণ্য ডেলিভারী নিন।</h5></li>
                    <li class="list-group-item"><h5>৫. ঔষধ ডেলিভারীর সময় আপনার প্রেসক্রিপশন প্রদর্শন করুন।</h5></li>
                </ul>

                <div class="up-button d-flex">
                    <button class="btn btn-lg btn-primary">Upload Prescription</button>
                </div>
            </div>
            <div class="col-6">
                <img src="{{ asset('upload_pres2.jpg') }}" alt="">
            </div>

        </div>
    </div>








    {{-- Top 10 categories and Brands --}}
    @if (get_setting('categories_products') != null)
        @php $categories_products = json_decode(get_setting('categories_products')); @endphp
        @foreach ($categories_products as $key => $value)
            <section class="mb-4">
                <div class="container">
                    @php $category = \App\Category::find($value); @endphp
                    <div class="d-flex align-items-center">
                        <h3 class="h5 fw-700 mb-0 w-100">
                            <span class="pb-3 text-center d-inline-block w-100">{{ $category->name }}</span>
                        </h3>
                    </div>
                    <div class="row gutters-10">
                            <div class="col-lg-12">
                                <div class="row gutters-5">
                                @if ($category != null)
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-3 mb-1">
                                        <div class="position-relative overflow-hidden h-100 bg-white">
                                            <img class="position-absolute left-0 top-0 img-fit h-100" src="{{ uploaded_asset($category->banner) }}" alt="{{ $category->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <div class="row gutters-5 row-cols-xxl-4 row-cols-xl-2 row-cols-lg-4 row-cols-md-2 row-cols-2">
                                            @if(count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id))>0)
                                                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $ids) 
                                                    @php
                                                        $subcat = \App\Category::find($ids);
                                                    @endphp
                                                    <div class="col">
                                                        <a href="{{ route('products.category', $subcat->slug) }}" class="d-block p-3" tabindex="0">
                                                            <img
                                                                src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($subcat->banner) }}"
                                                                alt="{{ $subcat->name }}"
                                                                class="img-200 lazyload"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                                            >
                                                        </a>
                                                        <h2 class="h6 fw-600 text-truncate text-center">
                                                            <a href="{{ route('products.category', $subcat->slug) }}" class="text-reset" tabindex="0">{{ $subcat->name }}</a>
                                                        </h2>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $.post('{{ route('home.section.best_selling') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {_token:'{{ csrf_token() }}'}, function(data){
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
