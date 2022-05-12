{{-- <section class="bg-white border-top mt-auto">
    <div class="container">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('terms') }}">
                    <i class="la la-file-text la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Terms & conditions') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('returnpolicy') }}">
                    <i class="la la-mail-reply la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Return Policy') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left text-center p-4 d-block" href="{{ route('supportpolicy') }}">
                    <i class="la la-support la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Support Policy') }}</h4>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a class="text-reset border-left border-right text-center p-4 d-block" href="{{ route('privacypolicy') }}">
                    <i class="las la-exclamation-circle la-3x text-primary mb-2"></i>
                    <h4 class="h6">{{ translate('Privacy Policy') }}</h4>
                </a>
            </div>
        </div>
    </div>
</section> --}}

<section class="bg-white py-5 text-light footer-widget">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                @php
                    $footer_logo = get_setting('footer_logo');
                @endphp
                @if($footer_logo != null)
                    <img src="{{ uploaded_asset($footer_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px h-md-80px" height="80">
                @else
                    <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px h-md-80px" height="80">
                @endif
                <div class="text-main footerText font-weight-bold text-center text-md-left mt-4">
                    <div class="my-3 fs-18 text-justify fw-400 lh-1-3">
                        {!! get_setting('about_us_description') !!}
                    </div>
                </div>
            </div>

            {{-- customer care --}}
            <div class="col-md-4">
                <div class="text-main font-weight-bold text-center text-md-left mt-4">
                    <h4 class="fs-19 fw-400 mb-3">
                        {{ get_setting('widget_one') }}
                    </h4>
                    <ul class="list-unstyled customerCare">
                        @if ( get_setting('widget_one_labels') !=  null )
                            @foreach (json_decode( get_setting('widget_one_labels'), true) as $key => $value)
                            <li class="mb-2">
                                <a href="{{ json_decode( get_setting('widget_one_links'), true)[$key] }}" class="text-black fw-500 fs-18 text-hov-underline">
                                    {{ $value }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>

            {{-- earm with isb --}}
            <div class="col-md-4 contant_us_footer">
                <div class="text-main font-weight-bold text-center text-md-left mt-4">
                    <h4 class="fs-19 fw-400 mb-3">
                        {{ translate('Contact Us') }}
                    </h4>
                    <div class="text-center text-md-left mt-4">
                        <ul class="list-unstyled text-black fw-500 fs-18">
                            <li class="mb-2 lh-1-2">
                                {{ get_setting('contact_address') }}
                            </li>
                            <li class="mb-2 lh-1-2">
                               <a href="tel:+88{{ get_setting('contact_phone') }}" class="text-reset text-hov-underline">{{ "+88". get_setting('contact_phone') }}</a>
                            </li>
                            <li class="mb-2 lh-1-2">
                                <a href="mailto:{{ get_setting('contact_email') }}" class="text-reset text-hov-underline">{{ get_setting('contact_email')  }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="pt-3 pb-7 pb-xl-3 bg-white text-black ">
    <div class="container border-top footer_boder_color">
        <div class="row align-items-center pt-3 justify-content-between">
                <p>Developed and maintained with love by Trenza Softwares</p>
                <p>
                    @php
                        echo get_setting('frontend_copyright_text');
                    @endphp
                </p>
        </div>
    </div>
</footer>


<div class="aiz-mobile-bottom-nav d-xl-none fixed-bottom bg-yellow shadow-lg border-top">
    <div class="d-flex justify-content-around align-items-center">
        <a href="{{ route('home') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-success {{ areActiveRoutes(['home'],'bg-soft-primary')}}">
            <i class="las la-campground la-2x"></i>
        </a>
        <a href="{{ route('categories.all') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-success {{ areActiveRoutes(['categories.all'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="las la-table la-2x"></i>
            </span>
        </a>
        <a href="{{ route('cart') }}" class="text-reset flex-grow-1 text-center py-3 border-right border-success {{ areActiveRoutes(['cart'],'bg-soft-primary')}}">
            <span class="d-inline-block position-relative px-2">
                <i class="las la-cart-arrow-down la-2x"></i>
                @if(Session::has('cart'))
                    <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">{{ count(Session::get('cart'))}}</span>
                @else
                    <span class="badge badge-circle badge-primary position-absolute absolute-top-right" id="cart_items_sidenav">0</span>
                @endif
            </span>
        </a>
        @if (Auth::check())
            @if(isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="text-reset flex-grow-1 text-center py-2">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if(Auth::user()->photo != null)
                            <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @else
                <a href="javascript:void(0)" class="text-reset flex-grow-1 text-center py-2 mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                    <span class="avatar avatar-sm d-block mx-auto">
                        @if(Auth::user()->photo != null)
                            <img src="{{ custom_asset(Auth::user()->avatar_original)}}">
                        @else
                            <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                        @endif
                    </span>
                </a>
            @endif
        @else
            <a href="{{ route('user.login') }}" class="text-reset flex-grow-1 text-center py-2">
                <span class="avatar avatar-sm d-block mx-auto">
                    <img src="{{ static_asset('assets/img/avatar-place.png') }}">
                </span>
            </a>
        @endif
    </div>
</div>
@if (Auth::check() && !isAdmin())
    <div class="aiz-mobile-side-nav collapse-sidebar-wrap sidebar-xl d-xl-none z-1035">
        <div class="overlay dark c-pointer overlay-fixed" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav" data-same=".mobile-side-nav-thumb"></div>
        <div class="collapse-sidebar bg-white">
            @include('frontend.inc.user_side_nav')
        </div>
    </div>
@endif
