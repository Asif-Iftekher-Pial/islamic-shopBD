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
                            <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-arrows="true"
                                data-dots="true" data-autoplay="true" data-infinite="true">
                                @php $slider_images = json_decode(get_setting('home_slider_images'), true);  @endphp
                                @foreach ($slider_images as $key => $value)
                                    <div class="carousel-box">
                                        <a href="{{ json_decode(get_setting('home_slider_links'), true)[$key] }}">
                                            <img class="d-block mw-100 img-fit rounded shadow-sm"
                                                src="{{ uploaded_asset($slider_images[$key]) }}"
                                                alt="{{ env('APP_NAME') }} promo" height="277"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                {{-- <div class="col-lg-12">

                    @php
                        $featured_categories = \App\Category::where('featured', 1)->get();
                    @endphp
                    @if (count($featured_categories) > 0)
                        <ul class="list-unstyled mb-0 row gutters-5">
                            @foreach ($featured_categories as $key => $category)
                                <li class="minw-0 col-4 col-md mt-3">
                                    <a href="{{ route('products.category', $category->slug) }}"
                                        class="d-block rounded bg-white p-2 text-reset shadow-sm">
                                        <img src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                            data-src="{{ uploaded_asset($category->banner) }}"
                                            alt="{{ $category->getTranslation('name') }}" class="lazyload img-fit"
                                            height="78"
                                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                        <div class="text-truncate fs-12 fw-600 mt-2 opacity-70">
                                            {{ $category->getTranslation('name') }}</div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div> --}}


            </div>
        </div>
    </div>

    {{-- offline banner section --}}
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
    {{-- End offline banner section --}}


    {{-- Best Selling --}}
    <div id="section_best_selling">

    </div>




    <div class="container">
        <div class="common-hr"></div>

        <div class="row">
            <div class="col-md-6">
                <h4>প্রেসক্রিপশন এর মাধ্যমে অর্ডার করুন</h4>
                <ul class="list-group bg-transparent">
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <h5>১. প্রেসক্রিপশন এর ছবি তুলে অথবা স্ক্যান করে আপলোড করুন।</h5>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <h5>২. আমাদের ফার্মাসিস্ট আপনার প্রেসক্রিপশন পেয়ে আপনার দেয়া ফোন নাম্বারে যোগাযোগ করবে। ( সকাল ১০টা
                            থেকে রাত ১০টা )</h5>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <h5>৩. ফার্মাসিস্ট আপনার সাথে কথা বলে ঔষধ সিলেক্ট করে অর্ডার কনফার্ম করবে।</h5>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <h5>৪. নির্দিষ্ট সময়ে আপনার ঔষধ/পণ্য ডেলিভারী নিন।</h5>
                    </li>
                    <li class="list-group-item bg-transparent border-0 p-0">
                        <h5>৫. ঔষধ ডেলিভারীর সময় আপনার প্রেসক্রিপশন প্রদর্শন করুন।</h5>
                    </li>
                </ul>
                <button class="btn order-butotn">Upload Prescription</button>
            </div>

            <div class="col-md-6">
                <img class="img-fluid" src="{{ asset('upload_pres2.jpg') }}" alt="">
            </div>

        </div>
        <div class="common-hr"></div>
    </div>


    {{-- why chose us --}}

    <div class="container" id="whyChoseUs">
        <div class="row category">
            <div class="col-md-12">
                <div class="title text-center">
                    <h4>Why People Love Your Website</h4>
                </div>
            </div>
        </div>

        <div class="common-hr"></div>
        <div class="row">
            <div class="col-md-4 p-0">
                <div class="card c1">
                    <div class="card-body card-bg-image">
                        <div class="card-content">
                            <h3>Convenient & Quick</h3>
                            <p>No waiting in traffic, no haggling, no worries carrying groceries, they're delivered right at
                                your door.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div class="card c2">
                    <div class="card-body card-bg-image">
                        <div class="card-content">
                            <h3>Freshly Picked</h3>
                            <p>Our fresh produce is sourced every morning, you get the best from us.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 p-0">
                <div class="card c3">
                    <div class="card-body card-bg-image">
                        <div class="card-content">
                            <h3>A wide range of Products</h3>
                            <p>With 4000+ Products to choose from, forget scouring those aisles for hours.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- why chose us --}}



    {{-- all category section --}}



    <div class="container" id="whyChoseUs">
        <div class="row category">
            <div class="col-md-12">
                <div class="title text-center">
                    <h4>WHY CHOOSE BANGLAMEDS ?</h4>
                </div>
            </div>
        </div>
        <div class="common-hr"></div>
        <div class="row">
            @include('frontend.partials.page_category_section')
        </div>
        <div class="common-hr"></div>
    </div>

    {{-- all category section --}}






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
                                            <img class="position-absolute left-0 top-0 img-fit h-100"
                                                src="{{ uploaded_asset($category->banner) }}"
                                                alt="{{ $category->name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <div
                                            class="row gutters-5 row-cols-xxl-4 row-cols-xl-2 row-cols-lg-4 row-cols-md-2 row-cols-2">
                                            @if (count(\App\Utility\CategoryUtility::get_immediate_children_ids($category->id)) > 0)
                                                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $ids)
                                                    @php
                                                        $subcat = \App\Category::find($ids);
                                                    @endphp
                                                    <div class="col">
                                                        <a href="{{ route('products.category', $subcat->slug) }}"
                                                            class="d-block p-3" tabindex="0">
                                                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                                data-src="{{ uploaded_asset($subcat->banner) }}"
                                                                alt="{{ $subcat->name }}" class="img-200 lazyload"
                                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                                        </a>
                                                        <h2 class="h6 fw-600 text-truncate text-center">
                                                            <a href="{{ route('products.category', $subcat->slug) }}"
                                                                class="text-reset"
                                                                tabindex="0">{{ $subcat->name }}</a>
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
        $(document).ready(function() {
            $.post('{{ route('home.section.best_selling') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_best_selling').html(data);
                AIZ.plugins.slickCarousel();
            });
            $.post('{{ route('home.section.home_categories') }}', {
                _token: '{{ csrf_token() }}'
            }, function(data) {
                $('#section_home_categories').html(data);
                AIZ.plugins.slickCarousel();
            });
        });
    </script>
@endsection
