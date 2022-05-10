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

<section class="bg-matt py-5 text-light footer-widget">
    <div class="container">
        <div class="row">
            {{-- <div class="col-md-3 text-center text-md-left mt-4">
                <div class="fb-page" data-href="https://www.facebook.com/IslamicShopBD" data-tabs="timeline" data-width="" data-height="120" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><blockquote cite="https://www.facebook.com/IslamicShopIndia" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/IslamicShopIndia">Islamic Shop</a></blockquote></div>
            </div> --}}
            <div class="col-md-3">
                <div class="text-yellow font-weight-bold text-center text-md-left mt-4">
                    <h4 class="fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                        {{ get_setting('widget_one') }}
                    </h4>
                    <ul class="list-unstyled">
                        @if ( get_setting('widget_one_labels') !=  null )
                            @foreach (json_decode( get_setting('widget_one_labels'), true) as $key => $value)
                            <li class="mb-2">
                                <a href="{{ json_decode( get_setting('widget_one_links'), true)[$key] }}" class="opacity-50 hov-opacity-100 text-reset">
                                    {{ $value }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-yellow font-weight-bold text-center text-md-left mt-4">
                    <h4 class="fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                        {{ get_setting('widget_two') }}
                    </h4>
                    <ul class="list-unstyled">
                        @if ( get_setting('widget_two_labels') !=  null )
                            @foreach (json_decode( get_setting('widget_two_labels'), true) as $key => $value)
                            <li class="mb-2">
                                <a href="{{ json_decode( get_setting('widget_two_links'), true)[$key] }}" class="opacity-50 hov-opacity-100 text-reset">
                                    {{ $value }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-yellow font-weight-bold text-center text-md-left mt-4">
                    <h4 class="fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                        {{ get_setting('widget_three') }}
                    </h4>
                    <ul class="list-unstyled">
                        @if ( get_setting('widget_three_labels') !=  null )
                            @foreach (json_decode( get_setting('widget_three_labels'), true) as $key => $value)
                            <li class="mb-2">
                                <a href="{{ json_decode( get_setting('widget_three_links'), true)[$key] }}" class="opacity-50 hov-opacity-100 text-reset">
                                    {{ $value }}
                                </a>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="text-yellow font-weight-bold text-center text-md-left mt-4">
                    <h4 class="text-yellow font-weight-bold fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                        {{ get_setting('about_widget_title') }}
                    </h4>
                    @php
                        $footer_logo = get_setting('footer_logo');
                    @endphp
                    @if($footer_logo != null)
                        <img src="{{ uploaded_asset($footer_logo) }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px h-md-80px" height="80">
                    @else
                        <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}" class="mw-100 h-60px h-md-80px" height="80">
                    @endif
                    <div class="my-3">
                        {!! get_setting('about_us_description') !!}
                    </div>
                    <div class="text-center text-md-left mt-4">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                               <span class="opacity-30">{{ translate('Address') }}:</span>
                               <span class="opacity-70">{{ get_setting('contact_address') }}</span>
                            </li>
                            <li class="mb-2">
                               <span class="opacity-30">{{translate('Phone')}}:</span> <span class="opacity-70"><a href="tel:+88{{ get_setting('contact_phone') }}" class="text-reset">{{ get_setting('contact_phone') }}</a></span>
                            </li>
                            <li class="mb-2">
                               <span class="opacity-30">{{translate('Email')}}:</span>
                               <span class="opacity-70">
                                   <a href="mailto:{{ get_setting('contact_email') }}" class="text-reset">{{ get_setting('contact_email')  }}</a>
                                </span>
                            </li>
                        </ul>
                    </div>
                    {{-- <div class="w-300px mw-100 mx-auto mx-md-0">
                        <a href="{{ get_setting('play_store_link') }}" target="_blank" class="d-inline-block mr-3 ml-0">
                            <img src="{{ static_asset('assets/img/play.png') }}" class="mx-100 h-40px">
                        </a>
                        <a href="{{ get_setting('app_store_link') }}" target="_blank" class="d-inline-block">
                            <img src="{{ static_asset('assets/img/app.png') }}" class="mx-100 h-40px">
                        </a>
                    </div> --}}
                    <h4 class="fs-13 text-uppercase fw-600 pb-2 mb-2 mt-2">
                        {{ translate('Follow Us') }}
                    </h4>
                    <ul class="list-inline my-3 my-md-0 social colored">
                        @if ( get_setting('facebook_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('facebook_link') }}" target="_blank" class="facebook"><i class="lab la-facebook-f"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('twitter_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('twitter_link') }}" target="_blank" class="twitter"><i class="lab la-twitter"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('instagram_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('instagram_link') }}" target="_blank" class="instagram"><i class="lab la-instagram"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('youtube_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('youtube_link') }}" target="_blank" class="youtube"><i class="lab la-youtube"></i></a>
                        </li>
                        @endif
                        @if ( get_setting('linkedin_link') !=  null )
                        <li class="list-inline-item">
                            <a href="{{ get_setting('linkedin_link') }}" target="_blank" class="linkedin"><i class="lab la-linkedin-in"></i></a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
            {{-- <div class="col-md-3">
                <div class="text-center text-md-left mt-4">
                    <h4 class="text-yellow font-weight-bold fs-15 text-uppercase fw-600 border-bottom border-gray-900 pb-2 mb-4">
                        {{ translate('Contact Info') }}
                    </h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                           <span class="d-block opacity-30">{{ translate('Address') }}:</span>
                           <span class="d-block opacity-70">{{ get_setting('contact_address') }}</span>
                        </li>
                        <li class="mb-2">
                           <span class="d-block opacity-30">{{translate('Phone')}}:</span>
                           <span class="d-block opacity-70">{{ get_setting('contact_phone') }}</span>
                        </li>
                        <li class="mb-2">
                           <span class="d-block opacity-30">{{translate('Email')}}:</span>
                           <span class="d-block opacity-70">
                               <a href="mailto:{{ get_setting('contact_email') }}" class="text-reset">{{ get_setting('contact_email')  }}</a>
                            </span>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="pt-3 pb-7 pb-xl-3 bg-yellow text-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="text-center">
                    <ul class="list-inline mb-0">
                        @if ( get_setting('payment_method_images') !=  null )
                            @foreach (explode(',', get_setting('payment_method_images')) as $key => $value)
                                <li class="list-inline-item">
                                    <img src="{{ uploaded_asset($value) }}" height="30" class="mw-100 h-auto">
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="text-center">
                    @php
                        echo get_setting('frontend_copyright_text');
                    @endphp
                </div>
            </div>
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
