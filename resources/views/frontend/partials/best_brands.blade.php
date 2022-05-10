@php
    $brands = \App\Brand::limit(15)->get();
@endphp
@if(!empty($brands))
    <section class="mb-4">
    <div class="container">
        <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
            <div class="d-flex align-items-baseline">
                <h3 class="h5 fw-700 mb-0">
                    <span class="pb-3 d-inline-block">Shop By Brands</span>
                </h3>
                <a href="{{ route('brands.all') }}" class="ml-auto mr-0 btn bg-matt text-white btn-sm shadow-md">{{ translate('VIEW ALL') }}</a>
            </div>
            <div class="aiz-carousel gutters-10 half-outside-arrow" data-items="7" data-lg-items="6"  data-md-items="6" data-sm-items="4" data-xs-items="2" data-rows="1">
                @foreach ($brands as $brand)
                    <div class="carousel-box">
                        <div class="row no-gutters box-3 align-items-center border border-light rounded hov-shadow-md my-2 has-transition">
                            <div class="col-12">
                                <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-3">
                                    <img
                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                        data-src="@if ($brand->logo !== null) {{ uploaded_asset($brand->logo) }} @else {{ static_asset('assets/img/placeholder.jpg') }} @endif"
                                        alt="{{ $brand->getTranslation('name') }}"
                                        class="img-150 lazyload"
                                    >
                                </a>
                                <h2 class="h6 fw-600 text-truncate text-center">
                                    <a href="{{ route('products.brand', $brand->slug) }}" class="text-reset">{{ $brand->getTranslation('name') }}</a>
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif