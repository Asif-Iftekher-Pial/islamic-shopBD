@if (\App\BusinessSetting::where('type', 'best_selling')->first()->value == 1)
    <section class="mb-4">
        <div class="container">
            <div class="px-2 py-4 px-md-4 py-md-3 bg-white shadow-sm rounded">
                <div class="d-flex mb-3 align-items-baseline justify-content-center border-bottom border-main border-width-3">
                    <span class="conte pb-3 d-inline-block best_selling_title fw-500 text-main mb-4">{{ translate('Best Selling') }}</span>
                </div>
                <div class="aiz-carousel gutters-10 half-outside-arrow mt-5"
                     data-items="4"
                     data-xl-items="5"
                     data-lg-items="4"
                     data-md-items="3"
                     data-sm-items="2"
                     data-xs-items="2"
                     data-arrows='true'
                     data-infinite='true'>
                    @foreach (filter_products(\App\Product::where('published', 1)->orderBy('num_of_sale', 'desc'))->limit(12)->get() as $key => $product)
                        <div class="carousel-box">
                            <div class="aiz-card-box border-main-1 rounded border-radius-5">
                                <div class="position-relative">
                                    <a href="{{ route('product', $product->slug) }}" class="d-block">
                                        <img
                                            class="img-fit lazyload mx-auto h-140px h-md-210px px-10px pt-10px"
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
                                        <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{  Str::limit($product->getTranslation('name'), 18)  }}</a>
                                    </h3>

                                    <div class="fs-16 mx-5 d-flex align-items-center justify-content-center">
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
@endif
