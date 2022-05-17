@extends('frontend.layouts.app')

@section('meta_title'){{ $detailedProduct->meta_title }}@stop

@section('meta_description'){{ $detailedProduct->meta_description }}@stop

@section('meta_keywords'){{ $detailedProduct->tags }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $detailedProduct->meta_title }}">
    <meta itemprop="description" content="{{ $detailedProduct->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $detailedProduct->meta_title }}">
    <meta name="twitter:description" content="{{ $detailedProduct->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}">
    <meta name="twitter:data1" content="{{ single_price($detailedProduct->unit_price) }}">
    <meta name="twitter:label1" content="Price">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $detailedProduct->meta_title }}" />
    <meta property="og:type" content="og:product" />
    <meta property="og:url" content="{{ route('product', $detailedProduct->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($detailedProduct->meta_img) }}" />
    <meta property="og:description" content="{{ $detailedProduct->meta_description }}" />
    <meta property="og:site_name" content="{{ get_setting('meta_title') }}" />
    <meta property="og:price:amount" content="{{ single_price($detailedProduct->unit_price) }}" />
    <meta property="product:price:currency"
        content="{{ \App\Currency::findOrFail(\App\BusinessSetting::where('type', 'system_default_currency')->first()->value)->code }}" />
    <meta property="fb:app_id" content="{{ env('FACEBOOK_PIXEL_ID') }}">
@endsection

@section('content')


    <section class="mb-4 pt-3">
        <div class="container">

            <div class="bg-white shadow-sm rounded p-3">
                <div class="row">
                    {{-- category --}}
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

                    {{-- Product details --}}
                    <div class="col-xl-9">
                        <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                            <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
                                data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                            <div class="collapse-sidebar c-scrollbar-light text-left">
                                {{-- <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                    <h3 class="h6 mb-0 fw-600">Filters</h3>
                                    <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                        <i class="las la-times la-2x"></i>
                                    </button>
                                </div> --}}

                                <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-21 fw-600 p-3 border-bottom categoryheader">
                                        {{ $detailedProduct->getTranslation('name') }}
                                    </div>
                                    <div class="d-flex mt-3">
                                        <div class="col-md-6">
                                            <div class="z-3 row gutters-10">
                                                @php
                                                    $photos = explode(',', $detailedProduct->photos);
                                                @endphp
                                                <div class="col order-1 order-md-2 pictureMargin">
                                                    <div class="aiz-carousel product-gallery"
                                                        data-nav-for='.product-gallery-thumb' data-fade='true'
                                                        data-auto-height='true'>
                                                        @foreach ($detailedProduct->stocks as $key => $stock)
                                                            @if ($stock->image != null)
                                                                <div class="carousel-box img-zoom rounded">
                                                                    <img class="img-fluid lazyload"
                                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                        data-src="{{ uploaded_asset($stock->image) }}"
                                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                        @foreach ($photos as $key => $photo)
                                                            <div class="carousel-box img-zoom rounded">
                                                                <img class="img-fluid lazyload"
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($photo) }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-auto w-md-80px order-2  order-md-1 mt-3 mt-md-0">
                                                <div class="aiz-carousel product-gallery-thumb " data-items='5'
                                                    data-nav-for='.product-gallery' data-vertical='true'
                                                    data-vertical-sm='false' data-focus-select='true' data-arrows='true'>
                                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                                        @if ($stock->image != null)
                                                            <div class="carousel-box c-pointer border p-1 rounded"
                                                                data-variation="{{ $stock->variant }}">
                                                                <img class="lazyload mw-100 size-50px mx-auto"
                                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    {{-- product thumbnails images --}}
                                                    {{-- @foreach ($photos as $key => $photo)
                                                        <div class="carousel-box  c-pointer border p-1 rounded">
                                                            <img class="lazyload  mw-100 size-50px mx-auto"
                                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                                data-src="{{ uploaded_asset($photo) }}"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                        </div>
                                                    @endforeach --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-left">
                                                <h1 class="mb-2 fs-24 text-main fw-600">
                                                    {{ $detailedProduct->getTranslation('name') }}
                                                </h1>

                                                <div class="row align-items-center">
                                                    {{-- <div class="col-6">
                                                        @php
                                                            $total = 0;
                                                            $total += $detailedProduct->reviews->count();
                                                        @endphp
                                                        <span class="rating">
                                                            {{ renderStarRating($detailedProduct->rating) }}
                                                        </span>
                                                        <span class="ml-1 opacity-50">({{ $total }}
                                                            {{ translate('reviews') }})</span>
                                                    </div> --}}
                                                    <div class="col-6 text-left">
                                                        @php
                                                            $qty = 0;
                                                            if ($detailedProduct->variant_product) {
                                                                foreach ($detailedProduct->stocks as $key => $stock) {
                                                                    $qty += $stock->qty;
                                                                }
                                                            } else {
                                                                $qty = $detailedProduct->current_stock;
                                                            }
                                                        @endphp
                                                        @if ($qty > 0)
                                                            <span
                                                                class="badge badge-md badge-inline badge-pill badge-success">{{ translate('In stock') }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-md badge-inline badge-pill badge-danger">{{ translate('Out of stock') }}</span>
                                                        @endif
                                                    </div>
                                                    {{-- <div class="col-auto">
                                                        <small
                                                            class="mr-2 opacity-50">{{ translate('Estimate Shipping Time') }}:
                                                        </small>
                                                        @if ($detailedProduct->est_shipping_days)
                                                            {{ $detailedProduct->est_shipping_days }}
                                                            {{ translate('Days') }}
                                                        @endif
                                                    </div> --}}
                                                </div>

                                                <hr>
                                                <div class="d-flex">
                                                    @if (home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))

                                                        <div class="row no-gutters mt-3">
                                                            {{-- <div class="col-sm-2">
                                                            <div class="opacity-50 my-2">{{ translate('Price') }}:</div>
                                                        </div> --}}
                                                            <div class="col-sm-10">
                                                                <div class="fs-20 opacity-60">
                                                                    <del>
                                                                        {{ home_price($detailedProduct->id) }}
                                                                        @if ($detailedProduct->unit != null)
                                                                            {{-- <span>/{{ $detailedProduct->getTranslation('unit') }}</span> --}}
                                                                        @endif
                                                                    </del>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row no-gutters my-2 ">
                                                            {{-- <div class="col-sm-2">
                                                            <div class="opacity-50">
                                                                {{ translate('Discount Price') }}:
                                                            </div>
                                                        </div> --}}
                                                            <div class="col-sm-10">
                                                                <div class="">
                                                                    <strong class="h2 fw-500 discountedPrice text-primary">
                                                                        {{ home_discounted_price($detailedProduct->id) }}
                                                                    </strong>
                                                                    @if ($detailedProduct->unit != null)
                                                                        {{-- <span
                                                                        class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span> --}}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <div class="row no-gutters mt-3">
                                                            <div class="col-sm-2">
                                                                <div class="opacity-50 my-2">{{ translate('Price') }}:
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <div class="">
                                                                    <strong class="h2 fw-600 text-primary">
                                                                        {{ home_discounted_price($detailedProduct->id) }}
                                                                    </strong>
                                                                    @if ($detailedProduct->unit != null)
                                                                        <span
                                                                            class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>


                                                @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated && $detailedProduct->earn_point > 0)
                                                    <div class="row no-gutters mt-4">
                                                        <div class="col-sm-2">
                                                            <div class="opacity-50 my-2">{{ translate('Club Point') }}:
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div
                                                                class="d-inline-block rounded px-2 bg-soft-primary border-soft-primary border">
                                                                <span
                                                                    class="strong-700">{{ $detailedProduct->earn_point }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <hr>

                                                <form id="option-choice-form">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                                    @if ($detailedProduct->choice_options != null)
                                                        @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)
                                                            <div class="row no-gutters">
                                                                <div class="col-sm-2">
                                                                    <div class="opacity-50 my-2">
                                                                        {{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-10">
                                                                    <div class="aiz-radio-inline">
                                                                        @foreach ($choice->values as $key => $value)
                                                                            <label class="aiz-megabox pl-0 mr-2">
                                                                                <input type="radio"
                                                                                    name="attribute_id_{{ $choice->attribute_id }}"
                                                                                    value="{{ $value }}"
                                                                                    @if ($key == 0) checked @endif>
                                                                                <span
                                                                                    class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                                                    {{ $value }}
                                                                                </span>
                                                                            </label>
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @endif

                                                    @if (count(json_decode($detailedProduct->colors)) > 0)
                                                        <div class="row no-gutters">
                                                            <div class="col-sm-2">
                                                                <div class="opacity-50 my-2">{{ translate('Color') }}:
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-10">
                                                                <div class="aiz-radio-inline">
                                                                    @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                                        <label class="aiz-megabox pl-0 mr-2"
                                                                            data-toggle="tooltip"
                                                                            data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                                            <input type="radio" name="color"
                                                                                value="{{ \App\Color::where('code', $color)->first()->name }}"
                                                                                @if ($key == 0) checked @endif>
                                                                            <span
                                                                                class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                                                <span
                                                                                    class="size-30px d-inline-block rounded"
                                                                                    style="background: {{ $color }};"></span>
                                                                            </span>
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <hr>
                                                    @endif

                                                    <!-- Quantity + Add to cart -->
                                                    <div class="row no-gutters">
                                                        <div class="col-sm-2 mt-2">
                                                            <div class="text-black fs-18 text-right my-2">
                                                                {{ translate('Qty') }}:
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="product-quantity d-flex align-items-center">
                                                                <div class="row no-gutters align-items-center aiz-plus-minus mr-3"
                                                                    style="width: 100px;">
                                                                    <button
                                                                        class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                        type="button" data-type="minus"
                                                                        data-field="quantity" disabled="">
                                                                        <i class="las la-minus"></i>
                                                                    </button>
                                                                    <input type="text" name="quantity"
                                                                        class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                                                        placeholder="1"
                                                                        value="{{ $detailedProduct->min_qty }}"
                                                                        min="{{ $detailedProduct->min_qty }}" max="10"
                                                                        readonly>
                                                                    <button
                                                                        class="btn  col-auto btn-icon btn-sm btn-circle btn-light"
                                                                        type="button" data-type="plus"
                                                                        data-field="quantity">
                                                                        <i class="las la-plus"></i>
                                                                    </button>
                                                                </div>
                                                                @if ($qty > 0)
                                                                    <div>
                                                                        <button type="button"
                                                                            class="btn addTocartButton btn-lg btn-primary add-to-cart fw-600"
                                                                            onclick="addToCart()">
                                                                            <i class="las cartIcon la-shopping-cart"></i>

                                                                        </button>
                                                                    </div>
                                                                @else
                                                                    <button type="button" class="btn btn-secondary fw-600"
                                                                        disabled>
                                                                        <i class="la la-cart-arrow-down"></i>
                                                                        {{ translate('Out of Stock') }}
                                                                    </button>
                                                                @endif
                                                                {{-- <div class="avialable-amount opacity-60">
                                                                    @if ($detailedProduct->stock_visibility_state != 'hide')
                                                                        (<span
                                                                            id="available-quantity">{{ $qty }}</span>
                                                                        {{ translate('available') }})
                                                                    @endif
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                                                        <div class="col-sm-2">
                                                            <div class="opacity-50 my-2">{{ translate('Total Price') }}:
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <div class="product-price">
                                                                <strong id="chosen_price" class="h4 fw-600 text-black">

                                                                </strong>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </form>
                                                {{-- <div class="mt-3">
                                                    @if ($qty > 0)
                                                        <button type="button"
                                                            class="btn btn-soft-primary mr-2 add-to-cart fw-600"
                                                            onclick="addToCart()">
                                                            <i class="las la-shopping-bag"></i>
                                                            <span class="d-none d-md-inline-block">
                                                                {{ translate('Add to cart') }}</span>
                                                        </button>
                                                        <button type="button" class="btn btn-primary buy-now fw-600"
                                                            onclick="buyNow()">
                                                            <i class="la la-shopping-cart"></i>
                                                            {{ translate('Buy Now') }}
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-secondary fw-600" disabled>
                                                            <i class="la la-cart-arrow-down"></i>
                                                            {{ translate('Out of Stock') }}
                                                        </button>
                                                    @endif
                                                </div> --}}



                                                {{-- <div class="d-table width-100 mt-3">
                                                    <div class="d-table-cell">
                                                        <!-- Add to wishlist button -->
                                                        <button type="button" class="btn pl-0 btn-link fw-600"
                                                            onclick="addToWishList({{ $detailedProduct->id }})">
                                                            {{ translate('Add to wishlist') }}
                                                        </button>
                                                        <!-- Add to compare button -->
                                                        <button type="button" class="btn btn-link btn-icon-left fw-600"
                                                            onclick="addToCompare({{ $detailedProduct->id }})">
                                                            {{ translate('Add to compare') }}
                                                        </button>
                                                        @if (Auth::check() && \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && (\App\AffiliateOption::where('type', 'product_sharing')->first()->status || \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                                                            @php
                                                                if (Auth::check()) {
                                                                    if (Auth::user()->referral_code == null) {
                                                                        Auth::user()->referral_code = substr(Auth::user()->id . Str::random(10), 0, 10);
                                                                        Auth::user()->save();
                                                                    }
                                                                    $referral_code = Auth::user()->referral_code;
                                                                    $referral_code_url = URL::to('/product') . '/' . $detailedProduct->slug . "?product_referral_code=$referral_code";
                                                                }
                                                            @endphp
                                                            <div>
                                                                <button type=button id="ref-cpurl-btn"
                                                                    class="btn btn-sm btn-secondary"
                                                                    data-attrcpy="{{ translate('Copied') }}"
                                                                    onclick="CopyToClipboard(this)"
                                                                    data-url="{{ $referral_code_url }}">{{ translate('Copy the Promote Link') }}</button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div> --}}

                                                <hr>

                                                {{-- <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <small class="mr-2 opacity-50">{{ translate('Sold by') }}:
                                                        </small><br>
                                                        @if ($detailedProduct->added_by == 'seller' && \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                                            <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}"
                                                                class="text-reset">{{ $detailedProduct->user->shop->name }}</a>
                                                        @else
                                                            {{ env('APP_NAME') . ' Product' }}
                                                        @endif
                                                    </div>
                                                    @if (\App\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                                                        <div class="col-auto">
                                                            <button class="btn btn-sm btn-soft-primary"
                                                                onclick="show_chat_modal()">{{ translate('Message Seller') }}</button>
                                                        </div>
                                                    @endif

                                                    @if ($detailedProduct->brand != null)
                                                        <div class="col-auto">
                                                            <a
                                                                href="{{ route('products.brand', $detailedProduct->brand->slug) }}">
                                                                <img src="{{ uploaded_asset($detailedProduct->brand->logo) }}"
                                                                    alt="{{ $detailedProduct->brand->getTranslation('name') }}"
                                                                    height="30">
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div> --}}


                                                {{-- @php
                                                    $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                                                    $refund_sticker = \App\BusinessSetting::where('type', 'refund_sticker')->first();
                                                @endphp
                                                @if ($refund_request_addon != null && $refund_request_addon->activated == 1 && $detailedProduct->refundable)
                                                    <div class="row no-gutters mt-4">
                                                        <div class="col-sm-2">
                                                            <div class="opacity-50 my-2">{{ translate('Refund') }}:
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-10">
                                                            <a href="{{ route('returnpolicy') }}" target="_blank">
                                                                @if ($refund_sticker != null && $refund_sticker->value != null)
                                                                    <img src="{{ uploaded_asset($refund_sticker->value) }}"
                                                                        height="36">
                                                                @else
                                                                    <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}"
                                                                        height="36">
                                                                @endif
                                                            </a>
                                                            <a href="{{ route('returnpolicy') }}" class="ml-2"
                                                                target="_blank">{{ translate('View Policy') }}</a>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row no-gutters mt-4">
                                                    <div class="col-sm-2">
                                                        <div class="opacity-50 my-2">{{ translate('Share') }}:</div>
                                                    </div>
                                                    <div class="col-sm-10">
                                                        <div class="aiz-share"></div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-xl-12 order-0 order-xl-1">
                                <div class="bg-white mb-3 shadow-sm rounded borderBackground">
                                    <div class="nav descriptionBorder aiz-nav-tabs activeClass">
                                        <a href="#tab_default_1" data-toggle="tab"
                                            class="p-3 fs-16 fw-600 text-reset">Description</a>
                                        <a href="#tab_default_4" data-toggle="tab"
                                            class="p-3 fs-16 fw-600 text-reset ">Reviews</a>
                                    </div>

                                    <div class="tab-content pt-0">
                                        <div class="tab-pane fade  " id="tab_default_1">
                                            <div class="p-4">
                                                <div class="mw-100 overflow-hidden text-left">
                                                    <h2
                                                        style="-webkit-tap-highlight-color: transparent; outline: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 14px; line-height: inherit; padding: 0px; font-family: &quot;Open Sans&quot;, Roboto, Arial, Helvetica, sans-serif, SimSun;">
                                                        <span
                                                            style="-webkit-tap-highlight-color: transparent; outline: 0px; color: rgb(192, 0, 0); font-weight: 700 !important;"><span
                                                                data-spm-anchor-id="a2g0o.detail.1000023.i0.40d66ec1ugOeQN"
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word; font-size: 22px; background-color: rgb(255, 255, 255);">CURREN
                                                                8106 Men Watches Luxury Brand Analog sports Wristwatch
                                                                Display Date Men's Quartz Watch Business Watch Relogio
                                                                Masculino&nbsp;</span></span></h2>
                                                    <p
                                                        style="-webkit-tap-highlight-color: transparent; outline: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 14px; line-height: inherit; padding: 0px; font-family: &quot;Open Sans&quot;, Roboto, Arial, Helvetica, sans-serif, SimSun;">
                                                        <span
                                                            style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: bolder;"><br></span>
                                                    </p>
                                                    <p
                                                        style="-webkit-tap-highlight-color: transparent; outline: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 14px; line-height: inherit; padding: 0px; font-family: &quot;Open Sans&quot;, Roboto, Arial, Helvetica, sans-serif, SimSun;">
                                                        <span
                                                            style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: bolder;">Main
                                                            Features:</span></p>
                                                    <div
                                                        style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; font-family: &quot;Open Sans&quot;, Roboto, Arial, Helvetica, sans-serif, SimSun; font-size: 14px;">
                                                        <span
                                                            style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;">With
                                                            imported quartz movement, high precise travel time.<br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">Classical
                                                            round dial with date showing, interface simple, convenience for
                                                            checking time.<br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">Stainless
                                                            steel band design, make it be a high-end timepiece.<br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">Unique
                                                            folding clasp with safety, easy to put on and off, enhance its
                                                            practicality.<br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">30
                                                            meters water resistance, durable as well as practical.<br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">Curren
                                                            8106 Men Quartz Watch, your best choice for gifts.</span></div>
                                                    <div
                                                        style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; font-family: &quot;Open Sans&quot;, Roboto, Arial, Helvetica, sans-serif, SimSun; font-size: 14px;">
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;"><br></span></span>
                                                        </div>
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Brand:</span>&nbsp;Curren<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Watches
                                                                    categories:</span>&nbsp;Male table</span></div>
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Movement
                                                                    Type:</span>&nbsp;Quartz watch<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">The
                                                                    shape of the dial:</span>&nbsp;Round<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Display
                                                                    Type:</span>&nbsp;Analog<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Case
                                                                    material:</span>&nbsp;Alloy</span></div>
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Band
                                                                    Material:</span>&nbsp;Stainless Steel<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Clasp
                                                                    Type:</span>&nbsp;Folding clasp with safety</span></div>
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Water
                                                                    resistance:</span>&nbsp;30 meters</span></div>
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">The
                                                                    dial thickness:</span>&nbsp;8 mm<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">The
                                                                    dial diameter:</span>&nbsp;40 mm<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">The
                                                                    bandwidth:</span>&nbsp;22 mm<br
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px;"><span
                                                                    style="-webkit-tap-highlight-color: transparent; outline: 0px; font-weight: 700 !important;">Wearable
                                                                    length:</span>&nbsp;206 mm</span></div>
                                                        <div
                                                            style="box-sizing: content-box; -webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px;">
                                                            <span
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><br></span>
                                                        </div>
                                                       
                                                    </div>
                                                    <p
                                                        style="-webkit-tap-highlight-color: transparent; outline: 0px; margin-right: 0px; margin-bottom: 0px; margin-left: 0px; font-size: 14px; line-height: inherit; padding: 0px; font-family: &quot;Open Sans&quot;, Roboto, Arial, Helvetica, sans-serif, SimSun;">
                                                        <span
                                                            style="-webkit-tap-highlight-color: transparent; outline: 0px; margin: 0px; padding: 0px; max-width: 100%; word-break: break-word;"><br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">Water-resistance
                                                            is tested in measurements of the atmosphere (ATM). Each ATM
                                                            denotes 10 meters of static water pressure. This is not the
                                                            depth to which a watch can be worn. Many watch cases will list
                                                            the basic measurement of 1 ATM as "water-resistant." These
                                                            watches will withstand small splashes of water but should not be
                                                            worn while washing the hands or submerging the hands in
                                                            water.<br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;"><br
                                                                style="-webkit-tap-highlight-color: transparent; outline: 0px;">Remember,
                                                            water resistance is tested under static conditions. Wearing a
                                                            watch that is 50 meters water resistant in water will expose the
                                                            watch to a much greater pressure than during a 50-meter static
                                                            test. Therefore the number of meters shown on the watch does not
                                                            indicate the depth that the watch can be taken to.</span></p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="tab_default_2">
                                            <div class="p-4">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_default_3">
                                            <div class="p-4 text-center ">
                                                <a href="" class="btn btn-primary">Download</a>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tab_default_4">
                                            <div class="p-4">
                                                <ul class="list-group list-group-flush">
                                                </ul>

                                                <div class="text-center fs-18 opacity-70">
                                                    There have been no reviews for this product yet.
                                                </div>

                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="bg-white rounded shadow-sm">
                                    <div class="border-bottom p-3">
                                        <h3 class="fs-16 fw-600 mb-0">
                                            <span class="mr-4">Related products</span>
                                        </h3>
                                    </div>
                                    <div class="p-3">
                                        <div class="aiz-carousel gutters-5 half-outside-arrow slick-initialized slick-slider"
                                            data-items="5" data-xl-items="3" data-lg-items="4" data-md-items="3"
                                            data-sm-items="2" data-xs-items="2" data-arrows="true" data-infinite="true">
                                            <div class="slick-list draggable">
                                                <div class="slick-track"
                                                    style="opacity: 1; width: 0px; transform: translate3d(0px, 0px, 0px);">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                                <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle"
                                    data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                                <div class="collapse-sidebar c-scrollbar-light text-left">


                                    <div class="bg-white shadow-sm rounded mb-3">
                                        <div class="fs-15 fw-600 p-3 border-bottom categoryheader">
                                            {{ $detailedProduct->getTranslation('name') }}
                                        </div>
                                    </div>
                                </div> --}}


                            {{-- <div class="col-xl-5 col-lg-6 mb-4">
                        <div class="sticky-top z-3 row gutters-10">
                            @php
                                $photos = explode(',', $detailedProduct->photos);
                            @endphp
                            <div class="col order-1 order-md-2">
                                <div class="aiz-carousel product-gallery" data-nav-for='.product-gallery-thumb' data-fade='true' data-auto-height='true'>
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box img-zoom rounded">
                                                <img
                                                    class="img-fluid lazyload"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach ($photos as $key => $photo)
                                        <div class="carousel-box img-zoom rounded">
                                            <img
                                                class="img-fluid lazyload"
                                                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                data-src="{{ uploaded_asset($photo) }}"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                            >
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-12 col-md-auto w-md-80px order-2 order-md-1 mt-3 mt-md-0">
                                <div class="aiz-carousel product-gallery-thumb" data-items='5' data-nav-for='.product-gallery' data-vertical='true' data-vertical-sm='false' data-focus-select='true' data-arrows='true'>
                                    @foreach ($detailedProduct->stocks as $key => $stock)
                                        @if ($stock->image != null)
                                            <div class="carousel-box c-pointer border p-1 rounded" data-variation="{{ $stock->variant }}">
                                                <img
                                                    class="lazyload mw-100 size-50px mx-auto"
                                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                    data-src="{{ uploaded_asset($stock->image) }}"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                                >
                                            </div>
                                        @endif
                                    @endforeach
                                    @foreach ($photos as $key => $photo)
                                    <div class="carousel-box c-pointer border p-1 rounded">
                                        <img
                                            class="lazyload mw-100 size-50px mx-auto"
                                            src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($photo) }}"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                                        >
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-7 col-lg-6">
                        <div class="text-left">
                            <h1 class="mb-2 fs-20 fw-600">
                                {{ $detailedProduct->getTranslation('name') }}
                            </h1>

                            <div class="row align-items-center">
                                <div class="col-6">
                                    @php
                                        $total = 0;
                                        $total += $detailedProduct->reviews->count();
                                    @endphp
                                    <span class="rating">
                                        {{ renderStarRating($detailedProduct->rating) }}
                                    </span>
                                    <span class="ml-1 opacity-50">({{ $total }} {{ translate('reviews')}})</span>
                                </div>
                                <div class="col-6 text-right">
                                    @php
                                        $qty = 0;
                                        if($detailedProduct->variant_product){
                                            foreach ($detailedProduct->stocks as $key => $stock) {
                                                $qty += $stock->qty;
                                            }
                                        }
                                        else{
                                            $qty = $detailedProduct->current_stock;
                                        }
                                    @endphp
                                    @if ($qty > 0)
                                        <span class="badge badge-md badge-inline badge-pill badge-success">{{ translate('In stock')}}</span>
                                    @else
                                        <span class="badge badge-md badge-inline badge-pill badge-danger">{{ translate('Out of stock')}}</span>
                                    @endif
                                </div>
                                <div class="col-auto">
                                    <small class="mr-2 opacity-50">{{ translate('Estimate Shipping Time')}}: </small>
                                    @if ($detailedProduct->est_shipping_days)
                                        {{ $detailedProduct->est_shipping_days }} {{  translate('Days') }}
                                    @endif
                                </div>
                            </div>

                            <hr>

                            @if (home_price($detailedProduct->id) != home_discounted_price($detailedProduct->id))

                                <div class="row no-gutters mt-3">
                                    <div class="col-sm-2">
                                        <div class="opacity-50 my-2">{{ translate('Price')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="fs-20 opacity-60">
                                            <del>
                                                {{ home_price($detailedProduct->id) }}
                                                @if ($detailedProduct->unit != null)
                                                    <span>/{{ $detailedProduct->getTranslation('unit') }}</span>
                                                @endif
                                            </del>
                                        </div>
                                    </div>
                                </div>

                                <div class="row no-gutters my-2">
                                    <div class="col-sm-2">
                                        <div class="opacity-50">{{ translate('Discount Price')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="">
                                            <strong class="h2 fw-600 text-primary">
                                                {{ home_discounted_price($detailedProduct->id) }}
                                            </strong>
                                            @if ($detailedProduct->unit != null)
                                                <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row no-gutters mt-3">
                                    <div class="col-sm-2">
                                        <div class="opacity-50 my-2">{{ translate('Price')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="">
                                            <strong class="h2 fw-600 text-primary">
                                                {{ home_discounted_price($detailedProduct->id) }}
                                            </strong>
                                            @if ($detailedProduct->unit != null)
                                                <span class="opacity-70">/{{ $detailedProduct->getTranslation('unit') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if (\App\Addon::where('unique_identifier', 'club_point')->first() != null && \App\Addon::where('unique_identifier', 'club_point')->first()->activated && $detailedProduct->earn_point > 0)
                                <div class="row no-gutters mt-4">
                                    <div class="col-sm-2">
                                        <div class="opacity-50 my-2">{{  translate('Club Point') }}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="d-inline-block rounded px-2 bg-soft-primary border-soft-primary border">
                                            <span class="strong-700">{{ $detailedProduct->earn_point }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <hr>

                            <form id="option-choice-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $detailedProduct->id }}">

                                @if ($detailedProduct->choice_options != null)
                                    @foreach (json_decode($detailedProduct->choice_options) as $key => $choice)

                                    <div class="row no-gutters">
                                        <div class="col-sm-2">
                                            <div class="opacity-50 my-2">{{ \App\Attribute::find($choice->attribute_id)->getTranslation('name') }}:</div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="aiz-radio-inline">
                                                @foreach ($choice->values as $key => $value)
                                                <label class="aiz-megabox pl-0 mr-2">
                                                    <input
                                                        type="radio"
                                                        name="attribute_id_{{ $choice->attribute_id }}"
                                                        value="{{ $value }}"
                                                        @if ($key == 0) checked @endif
                                                    >
                                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                        {{ $value }}
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    @endforeach
                                @endif

                                @if (count(json_decode($detailedProduct->colors)) > 0)
                                    <div class="row no-gutters">
                                        <div class="col-sm-2">
                                            <div class="opacity-50 my-2">{{ translate('Color')}}:</div>
                                        </div>
                                        <div class="col-sm-10">
                                            <div class="aiz-radio-inline">
                                                @foreach (json_decode($detailedProduct->colors) as $key => $color)
                                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                    <input
                                                        type="radio"
                                                        name="color"
                                                        value="{{ \App\Color::where('code', $color)->first()->name }}"
                                                        @if ($key == 0) checked @endif
                                                    >
                                                    <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                        <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                                    </span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <hr>
                                @endif

                                <!-- Quantity + Add to cart -->
                                <div class="row no-gutters">
                                    <div class="col-sm-2">
                                        <div class="opacity-50 my-2">{{ translate('Quantity')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="product-quantity d-flex align-items-center">
                                            <div class="row no-gutters align-items-center aiz-plus-minus mr-3" style="width: 130px;">
                                                <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="minus" data-field="quantity" disabled="">
                                                    <i class="las la-minus"></i>
                                                </button>
                                                <input type="text" name="quantity" class="col border-0 text-center flex-grow-1 fs-16 input-number" placeholder="1" value="{{ $detailedProduct->min_qty }}" min="{{ $detailedProduct->min_qty }}" max="10" readonly>
                                                <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button" data-type="plus" data-field="quantity">
                                                    <i class="las la-plus"></i>
                                                </button>
                                            </div>
                                            <div class="avialable-amount opacity-60">
                                                @if ($detailedProduct->stock_visibility_state != 'hide')
                                                (<span id="available-quantity">{{ $qty }}</span> {{ translate('available')}})
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row no-gutters pb-3 d-none" id="chosen_price_div">
                                    <div class="col-sm-2">
                                        <div class="opacity-50 my-2">{{ translate('Total Price')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="product-price">
                                            <strong id="chosen_price" class="h4 fw-600 text-primary">

                                            </strong>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="mt-3">
                                @if ($qty > 0)
                                    <button type="button" class="btn btn-soft-primary mr-2 add-to-cart fw-600" onclick="addToCart()">
                                        <i class="las la-shopping-bag"></i>
                                        <span class="d-none d-md-inline-block"> {{ translate('Add to cart')}}</span>
                                    </button>
                                    <button type="button" class="btn btn-primary buy-now fw-600" onclick="buyNow()">
                                        <i class="la la-shopping-cart"></i> {{ translate('Buy Now')}}
                                    </button>
                                @else
                                    <button type="button" class="btn btn-secondary fw-600" disabled>
                                        <i class="la la-cart-arrow-down"></i> {{ translate('Out of Stock')}}
                                    </button>
                                @endif
                            </div>



                            <div class="d-table width-100 mt-3">
                                <div class="d-table-cell">
                                    <!-- Add to wishlist button -->
                                    <button type="button" class="btn pl-0 btn-link fw-600" onclick="addToWishList({{ $detailedProduct->id }})">
                                        {{ translate('Add to wishlist')}}
                                    </button>
                                    <!-- Add to compare button -->
                                    <button type="button" class="btn btn-link btn-icon-left fw-600" onclick="addToCompare({{ $detailedProduct->id }})">
                                        {{ translate('Add to compare')}}
                                    </button>
                                    @if (Auth::check() && \App\Addon::where('unique_identifier', 'affiliate_system')->first() != null && \App\Addon::where('unique_identifier', 'affiliate_system')->first()->activated && (\App\AffiliateOption::where('type', 'product_sharing')->first()->status || \App\AffiliateOption::where('type', 'category_wise_affiliate')->first()->status) && Auth::user()->affiliate_user != null && Auth::user()->affiliate_user->status)
                                        @php
                                            if(Auth::check()){
                                                if(Auth::user()->referral_code == null){
                                                    Auth::user()->referral_code = substr(Auth::user()->id.Str::random(10), 0, 10);
                                                    Auth::user()->save();
                                                }
                                                $referral_code = Auth::user()->referral_code;
                                                $referral_code_url = URL::to('/product').'/'.$detailedProduct->slug."?product_referral_code=$referral_code";
                                            }
                                        @endphp
                                        <div>
                                            <button type=button id="ref-cpurl-btn" class="btn btn-sm btn-secondary" data-attrcpy="{{ translate('Copied')}}" onclick="CopyToClipboard(this)" data-url="{{$referral_code_url}}">{{ translate('Copy the Promote Link')}}</button>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <small class="mr-2 opacity-50">{{ translate('Sold by')}}: </small><br>
                                    @if ($detailedProduct->added_by == 'seller' && \App\BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1)
                                        <a href="{{ route('shop.visit', $detailedProduct->user->shop->slug) }}" class="text-reset">{{ $detailedProduct->user->shop->name }}</a>
                                    @else
                                        {{  env('APP_NAME').' Product' }}
                                    @endif
                                </div>
                                @if (\App\BusinessSetting::where('type', 'conversation_system')->first()->value == 1)
                                    <div class="col-auto">
                                        <button class="btn btn-sm btn-soft-primary" onclick="show_chat_modal()">{{ translate('Message Seller')}}</button>
                                    </div>
                                @endif

                                @if ($detailedProduct->brand != null)
                                    <div class="col-auto">
                                        <a href="{{ route('products.brand',$detailedProduct->brand->slug) }}">
                                            <img src="{{ uploaded_asset($detailedProduct->brand->logo) }}" alt="{{ $detailedProduct->brand->getTranslation('name') }}" height="30">
                                        </a>
                                    </div>
                                @endif
                            </div>


                            @php
                                $refund_request_addon = \App\Addon::where('unique_identifier', 'refund_request')->first();
                                $refund_sticker = \App\BusinessSetting::where('type', 'refund_sticker')->first();
                            @endphp
                            @if ($refund_request_addon != null && $refund_request_addon->activated == 1 && $detailedProduct->refundable)
                                <div class="row no-gutters mt-4">
                                    <div class="col-sm-2">
                                        <div class="opacity-50 my-2">{{ translate('Refund')}}:</div>
                                    </div>
                                    <div class="col-sm-10">
                                        <a href="{{ route('returnpolicy') }}" target="_blank">
                                            @if ($refund_sticker != null && $refund_sticker->value != null)
                                                <img src="{{ uploaded_asset($refund_sticker->value) }}" height="36">
                                            @else
                                                <img src="{{ static_asset('assets/img/refund-sticker.jpg') }}" height="36">
                                            @endif
                                        </a>
                                        <a href="{{ route('returnpolicy') }}" class="ml-2" target="_blank">{{ translate('View Policy') }}</a>
                                    </div>
                                </div>
                            @endif
                            <div class="row no-gutters mt-4">
                                <div class="col-sm-2">
                                    <div class="opacity-50 my-2">{{ translate('Share')}}:</div>
                                </div>
                                <div class="col-sm-10">
                                    <div class="aiz-share"></div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                        </div>
                    </div>
                </div>
    </section>


@endsection

@section('modal')
    <div class="modal fade" id="chat_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-zoom product-modal" id="modal-size" role="document">
            <div class="modal-content position-relative">
                <div class="modal-header">
                    <h5 class="modal-title fw-600 h5">{{ translate('Any query about this product') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="" action="{{ route('conversations.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $detailedProduct->id }}">
                    <div class="modal-body gry-bg px-3 pt-3">
                        <div class="form-group">
                            <input type="text" class="form-control mb-3" name="title"
                                value="{{ $detailedProduct->name }}" placeholder="{{ translate('Product Name') }}"
                                required>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" rows="8" name="message" required
                                placeholder="{{ translate('Your Question') }}">{{ route('product', $detailedProduct->slug) }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary fw-600"
                            data-dismiss="modal">{{ translate('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary fw-600">{{ translate('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <input type="text"
                                        class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email Or Phone') }}"
                                        name="email" id="email">
                                @else
                                    <input type="email"
                                        class="form-control h-auto form-control-lg {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="{{ translate('Email') }}"
                                        name="email">
                                @endif
                                @if (\App\Addon::where('unique_identifier', 'otp_system')->first() != null && \App\Addon::where('unique_identifier', 'otp_system')->first()->activated)
                                    <span
                                        class="opacity-60">{{ translate('Use country code before number') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" class="form-control h-auto form-control-lg"
                                    placeholder="{{ translate('Password') }}">
                            </div>

                            <div class="row mb-2">
                                <div class="col-6">
                                    <label class="aiz-checkbox">
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <span class=opacity-60>{{ translate('Remember Me') }}</span>
                                        <span class="aiz-square-check"></span>
                                    </label>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('password.request') }}"
                                        class="text-reset opacity-60 fs-14">{{ translate('Forgot password?') }}</a>
                                </div>
                            </div>

                            <div class="mb-5">
                                <button type="submit"
                                    class="btn btn-primary btn-block fw-600">{{ translate('Login') }}</button>
                            </div>
                        </form>

                        <div class="text-center mb-3">
                            <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                            <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                        </div>
                        @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}"
                                            class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}"
                                            class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}"
                                            class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            getVariantPrice();
        });

        function CopyToClipboard(e) {
            var url = $(e).data('url');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(url).select();
            try {
                document.execCommand("copy");
                AIZ.plugins.notify('success', '{{ translate('Link copied to clipboard') }}');
            } catch (err) {
                AIZ.plugins.notify('danger', '{{ translate('Oops, unable to copy') }}');
            }
            $temp.remove();
            // if (document.selection) {
            //     var range = document.body.createTextRange();
            //     range.moveToElementText(document.getElementById(containerid));
            //     range.select().createTextRange();
            //     document.execCommand("Copy");

            // } else if (window.getSelection) {
            //     var range = document.createRange();
            //     document.getElementById(containerid).style.display = "block";
            //     range.selectNode(document.getElementById(containerid));
            //     window.getSelection().addRange(range);
            //     document.execCommand("Copy");
            //     document.getElementById(containerid).style.display = "none";

            // }
            // AIZ.plugins.notify('success', 'Copied');
        }

        function show_chat_modal() {
            @if (Auth::check())
                $('#chat_modal').modal('show');
            @else
                $('#login_modal').modal('show');
            @endif
        }
    </script>
@endsection
