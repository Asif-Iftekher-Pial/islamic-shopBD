@extends('frontend.layouts.app')

@section('content')
<section class="pt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="fw-600 h4">{{ translate('All Sellers') }}</h1>
            </div>
            @if (\App\BusinessSetting::where('type', 'breadcums')->first()->value == 1)                
            {{-- <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('sellers') }}">"{{ translate('All Sellers') }}"</a>
                    </li>
                </ul>
            </div> --}}
            @endif
            <div class="col-lg-6">
                <form class="" id="search-form" action="" method="GET">
                    <div class="d-flex align-items-center">
                        <div class="form-group ml-auto mr-0 w-200px d-none d-xl-block">
                            <label class="mb-0 opacity-50">{{ translate('Locations')}}</label>
                            <select class="form-control form-control-sm aiz-selectpicker" data-live-search="true" name="city" onchange="filter()">
                                <option value="">{{ translate('All Locations')}}</option>
                                @foreach (\App\City::all() as $city)
                                    <option value="{{ $city->id }}" @isset($city_id) @if ($city_id == $city->id) selected @endif @endisset>{{ $city->getTranslation('name') }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-xl-none ml-auto ml-xl-3 mr-0 form-group align-self-end">
                            <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                <i class="la la-filter la-2x"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<section class="mb-2">
    <div class="container">
            <div class="row gutters-10 row-cols-xxl-3 row-cols-xl-3 row-cols-lg-2 row-cols-md-2 row-cols-1">
                @foreach ($shops as $key => $shop)
                @php
                    $total = 0;
                    $rating = 0;
                    foreach ($shop->user->products as $key => $shop_product) {
                        $total += $shop_product->reviews->count();
                        $rating += $shop_product->reviews->sum('rating');
                    }
                @endphp
                    <div class="col">
                        <div class="row no-gutters bg-white align-items-center border border-light rounded hov-shadow-md mb-3 has-transition min-h-150">
                            <div class="col-4">
                                <a href="{{ route('shop.visit', $shop->slug) }}" class="d-block p-3" tabindex="0">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($shop->logo) }}"
                                        alt="{{ $shop->name }}"
                                        class="img-fluid lazyload"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    >
                                </a>
                            </div>
                            <div class="col-8 border-left border-light">
                                <div class="p-3 text-left">
                                    <h2 class="h6 fw-600 text-truncate">
                                        <a href="{{ route('shop.visit', $shop->slug) }}" class="text-reset" tabindex="0">{{ $shop->name }}</a>
                                    </h2>
                                    <div class="rating rating-sm mb-2">
                                        @if ($total > 0)
                                            {{ renderStarRating($rating/$total) }}
                                        @else
                                            {{ renderStarRating(0) }}
                                        @endif
                                    </div>
                                    <a href="{{ route('shop.visit', $shop->slug) }}" class="btn btn-soft-primary btn-sm" tabindex="0">
                                        {{ translate('Visit Store') }}
                                        <i class="las la-angle-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="aiz-pagination aiz-pagination-center mt-4">
                {{ $shops->links() }}
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }
    </script>
@endsection