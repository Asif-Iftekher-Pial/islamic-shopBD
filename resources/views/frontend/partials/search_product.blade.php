
<div class="col-xl-9">
    <ul class="list-unstyled fs-18 d-flex align-items-center justify-content-between py-3 border-main-1 rounded-bottom rounded-top search-item-text">
        <li><a class="p-2 text-black" href="http://">A</a></li>
        <li><a class="p-2 text-black" href="http://">B</a></li>
        <li><a class="p-2 text-black" href="http://">C</a></li>
        <li><a class="p-2 text-black" href="http://">D</a></li>
        <li><a class="p-2 text-black" href="http://">E</a></li>
        <li><a class="p-2 text-black" href="http://">F</a></li>
        <li><a class="p-2 text-black" href="http://">G</a></li>
        <li><a class="p-2 text-black" href="http://">H</a></li>
        <li><a class="p-2 text-black" href="http://">I</a></li>
        <li><a class="p-2 text-black" href="http://">J</a></li>
        <li><a class="p-2 text-black" href="http://">K</a></li>
        <li><a class="p-2 text-black" href="http://">L</a></li>
        <li><a class="p-2 text-black" href="http://">M</a></li>
        <li><a class="p-2 text-black" href="http://">N</a></li>
        <li><a class="p-2 text-black" href="http://">O</a></li>
        <li><a class="p-2 text-black" href="http://">P</a></li>
        <li><a class="p-2 text-black" href="http://">Q</a></li>
        <li><a class="p-2 text-black" href="http://">R</a></li>
        <li><a class="p-2 text-black" href="http://">S</a></li>
        <li><a class="p-2 text-black" href="http://">T</a></li>
        <li><a class="p-2 text-black" href="http://">U</a></li>
        <li><a class="p-2 text-black" href="http://">V</a></li>
        <li><a class="p-2 text-black" href="http://">W</a></li>
        <li><a class="p-2 text-black" href="http://">X</a></li>
        <li><a class="p-2 text-black" href="http://">Y</a></li>
        <li><a class="p-2 text-black" href="http://">Z</a></li>
        <li><a class="p-2 text-black" href="http://">All</a></li>


    </ul>


    <table class="table text-center product-tables">
        <thead class="bg-main text-white">
        <th scope="col">NAME</th>
        <th scope="col">MANUFACTURER</th>
        <th scope="col">PACK SIZE</th>
        <th scope="col">MRP</th>
        <th scope="col">CART</th>
        </thead>
        <tbody >
        <tr>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
            <td>@mdo</td>
            <td class="d-flex">
                <select class="form-control col- mr-2" aria-label="Default select example w-50">
                    <option selected="">QTY</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>

                <button class="btn btnSize categoryheader">
                    <i class="la la-shopping-cart" style="font-size: 30px;"></i>
                </button>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="text-center">
        <button class="btn LoadMore bg-main text-white">Load More Product</button>
    </div>

    {{-- <input type="hidden" name="min_price" value="">
    <input type="hidden" name="max_price" value="">
    <div class="row gutters-5 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2">
        @foreach ($products as $key => $product)
            <div class="col mb-3">
                <div class="aiz-card-box h-100 border border-light rounded shadow-sm hov-shadow-md has-transition bg-white">
                    <div class="position-relative">
                        <a href="{{ route('product', $product->slug) }}" class="d-block">
                            <img
                                class="img-fit lazyload mx-auto h-160px h-md-220px h-xl-270px h-xxl-250px"
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
                        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0">
                            <a href="{{ route('product', $product->slug) }}" class="d-block text-reset">{{ $product->getTranslation('name') }}</a>
                        </h3>
                        <div class="rating rating-sm mt-1">
                            {{ renderStarRating($product->rating) }}
                        </div>
                        <div class="fs-15">
                            @if (home_base_price($product->id) != home_discounted_base_price($product->id))
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
    <div class="aiz-pagination aiz-pagination-center mt-4">
        {{ $products->links() }}
    </div> --}}
</div>
