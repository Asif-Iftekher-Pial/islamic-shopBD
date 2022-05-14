<!-- END Top Bar -->
<header class="@if (get_setting('header_stikcy') == 'on') sticky-top @endif z-1020 bg-white border-bottom shadow-sm">
    <div class="position-relative logo-bar-area z-1">
        <div class="container">
            <div class="d-flex align-items-center mb-2 mt-4">
                <div class="col-auto col-xl-2 pl-0 pr-3 d-flex align-items-center">
                    <a class="d-block py-5px mr-3 ml-0" href="{{ route('home') }}">
                        @php
                            $header_logo = get_setting('header_logo');
                        @endphp
                        @if ($header_logo != null)
                            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                                class="mw-100 h-60px h-md-80px" height="80">
                        @else
                            <img src="{{ static_asset('assets/img/logo.png') }}" alt="{{ env('APP_NAME') }}"
                                class="mw-100 h-60px h-md-80px" height="80">
                        @endif
                    </a>
                </div>
                <div class="d-lg-none ml-auto mr-0">
                    <a class="p-2 d-block text-reset" href="javascript:void(0);" data-toggle="class-toggle"
                        data-target=".front-header-search">
                        <i class="las la-search la-flip-horizontal la-2x"></i>
                    </a>
                </div>
                <div class="col-lg-7 sm_search_input_slid">
                    <div class="flex-grow-1 front-header-search d-flex align-items-center">
                        <div class="position-relative flex-grow-1">
                            <p class="fs-20 fw-400 d-none d-lg-block text-main">আপনার ঔষধ খুঁজুন, অর্ডার করুন এবং দ্রুত ডেলিভারী নিন . . .</p>
                            <form action="{{ route('search') }}" method="GET" class="stop-propagation">
                                <div class="d-flex position-relative align-items-center">
                                    <div class="d-lg-none" data-toggle="class-toggle"
                                         data-target=".front-header-search">
                                        <button class="btn px-2" type="button"><i
                                                class="la la-2x la-long-arrow-left"></i></button>
                                    </div>
                                    <div class="input-group bg-white border border-dark">
                                        <input type="text" class="border-0 form-control" id="search" name="q"
                                               placeholder="{{ translate('Search in Islamic Shop Bangladesh') }}"
                                               autocomplete="off">
                                    </div>
                                    <div class="input-group-append d-none d-lg-block">
                                        <button class="btn bg-main search_button" type="submit">
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="typed-search-box stop-propagation document-click-d-none d-none bg-white rounded shadow-lg position-absolute left-0 top-100 w-100"
                                 style="min-height: 200px">
                                <div class="search-preloader absolute-top-center">
                                    <div class="dot-loader">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                                <div class="search-nothing d-none p-3 text-center fs-16">

                                </div>
                                <div id="search-content" class="text-left">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="float-right position-absolute contact_number_auth d-flex">
                    <div class="d-none d-lg-none ml-3 mr-0">
                        <div class="nav-search-box">
                            <a href="#" class="nav-box-link">
                                <i class="la la-search la-flip-horizontal d-inline-block nav-box-icon"></i>
                            </a>
                        </div>
                    </div>
                    @auth
                        <div class="d-none d-lg-block ml-3 mr-0 mt-3">
                            <div class="" id="auth">
                                <a href="{{ route('dashboard') }}" class="d-flex align-items-center text-reset">
                                    <i class="la la-home la-2x opacity-80"></i>
                                    <span class="flex-grow-1 ml-1">
                                    <span
                                        class="nav-box-text d-none d-xl-block opacity-70 font-weight-bold text-uppercase">My
                                        Panel</span>
                                </span>
                                </a>
                            </div>
                        </div>
                        <div class="d-none d-lg-block ml-3 mr-0 mt-3">
                            <div class="" id="auth">
                                <a href="{{ route('logout') }}" class="d-flex align-items-center text-reset">
                                    <i class="la la-sign-in la-2x opacity-80"></i>
                                    <span class="flex-grow-1 ml-1">
                                    <span
                                        class="nav-box-text d-none d-xl-block opacity-70 font-weight-bold text-uppercase">Logout</span>
                                </span>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="d-none d-lg-block ml-3 mr-0 mt-3">
                            <div class="" id="auth">
                                <a href="{{ route('user.login') }}" class="d-flex align-items-center text-reset fs-18">
                                    <i class="la la-user la-2x opacity-80 user_fa_icon"></i>
                                        <span class="ml-2 nav-box-text d-none d-xl-block fw-400">Sign In</span>/
                                        <span class="nav-box-text d-none d-xl-block fw-400">Register</span>
                                </a>
                            </div>
                        </div>
                    @endauth
                </div>

            </div>
        </div>
    </div>







    @if (get_setting('main_header_menu_labels') != null)
        <div class="bg-gray-900 border-top border-gray-200 py-md-1 py-0">
            <nav class="navbar navbar-expand-lg navbar-dark d-md-none">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
                    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-brand">
                    <ul class="list-inline mb-0 pl-0">
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('wishlists.index') }}"
                                class="text-white opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                {{ translate('WISHLIST') }}
                            </a>
                        </li>
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('compare') }}"
                                class="text-white opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                {{ translate('COMPARE') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav mr-auto">
                        <li>
                            {{-- @if (Route::currentRouteName() != 'home') --}}
                                <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">
                                    <div class="h-100 d-flex align-items-center" id="category-menu-icon">
                                        <div class="dropdown-toggle navbar-light bg-light h-40px w-50px pl-2 rounded border c-pointer">
                                            <span class="navbar-toggler-icon"></span>
                                        </div>
                                    </div>
                                </div>
                            {{-- @endif --}}
                        </li>
                        @foreach (json_decode(get_setting('main_header_menu_labels'), true) as $key => $value)
                            <li class="nav-item">
                                <a href="{{ json_decode(get_setting('main_header_menu_links'), true)[$key] }}"
                                    class="nav-link text-white opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                    {{ translate($value) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </nav>
            <div class="container d-none d-md-block">
                <div class="d-flex justify-content-between">
                    <ul class="list-inline mb-0 pl-0 mobile-hor-swipe text-left">
                        <li class="list-inline-item mr-0">
                            {{-- @if (Route::currentRouteName() != 'home') --}}
                                <div class="d-none d-xl-block align-self-stretch category-menu-icon-box ml-auto mr-0">

                                    <div class="h-100 d-flex align-items-center text-white" id="category-menu-icon">

                                        <div class=" bg-transparent h-40px pl-2 c-pointer">
                                            <i class="la la-bars"></i>
                                            <span class="text-white opacity-100 fs-16 px-1 py-2 d-inline-block fw-600 hov-opacity-80">Categories</span>
                                        </div>
                                    </div>
                                </div>
                            {{-- @endif --}}
                        </li>
                        @foreach (json_decode(get_setting('main_header_menu_labels'), true) as $key => $value)
                            <li class="list-inline-item mr-0">
                                <a href="{{ json_decode(get_setting('main_header_menu_links'), true)[$key] }}"
                                    class="text-white opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                    {{ translate($value) }}
                                </a>
                            </li>
                        @endforeach
                    </ul>


                    
                    <ul class="list-inline mb-0 pl-0 mobile-hor-swipe">
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('wishlists.index') }}"
                                class="text-white opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                {{ translate('WISHLIST') }}
                            </a>
                        </li>
                        <li class="list-inline-item mr-0">
                            <a href="{{ route('compare') }}"
                                class="text-white opacity-100 fs-16 px-3 py-2 d-inline-block fw-600 hov-opacity-80">
                                {{ translate('COMPARE') }}
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- @if (Route::currentRouteName() != 'home') --}}
                    <div class="hover-category-menu position-absolute w-100 top-100 left-0 right-0 d-none z-3 mt_5"
                        id="hover-category-menu">
                        <div class="container">
                            <div class="row gutters-10 position-relative">
                                <div class="col-lg-3 position-static">
                                    @include('frontend.partials.category_menu')
                                </div>
                            </div>
                        </div>
                    </div>
                {{-- @endif --}}

            </div>
        </div>
    @endif

</header>
