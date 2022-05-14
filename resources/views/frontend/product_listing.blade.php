@extends('frontend.layouts.app')

@if (isset($category_id))
    @php
        $meta_title = \App\Category::find($category_id)->meta_title;
        $meta_description = \App\Category::find($category_id)->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = \App\Brand::find($brand_id)->meta_title;
        $meta_description = \App\Brand::find($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title = get_setting('meta_title');
        $meta_description = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">

    <!-- Twitter Card data -->
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
@endsection

@section('content')

    <section class="mb-4 pt-3">
        <div class="container sm-px-0">
            <form class="" id="search-form" action="" method="GET">
                <div class="row">
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
                                        @if (!isset($category_id))
                                            @foreach (\App\Category::where('level', 0)->get() as $category)
                                                <li class="py-2 categoryList">
                                                    <a class="text-reset fs-18"
                                                        href="{{ route('products.category', $category->slug) }}">{{ $category->getTranslation('name') }}</a>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="mb-2 ">
                                                <a class="text-reset fs-14 fw-600" href="{{ route('search') }}">
                                                    <i class="las la-angle-left"></i>
                                                    {{ translate('All Categories') }}
                                                </a>
                                            </li>
                                            @if (\App\Category::find($category_id)->parent_id != 0)
                                                <li class="mb-2">
                                                    <a class="text-reset fs-18 fw-600"
                                                        href="{{ route('products.category', \App\Category::find(\App\Category::find($category_id)->parent_id)->slug) }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ \App\Category::find(\App\Category::find($category_id)->parent_id)->getTranslation('name') }}
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="mb-2">
                                                <a class="text-reset fs-14 fw-600"
                                                    href="{{ route('products.category', \App\Category::find($category_id)->slug) }}">
                                                    <i class="las la-angle-left"></i>
                                                    {{ \App\Category::find($category_id)->getTranslation('name') }}
                                                </a>
                                            </li>
                                            @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category_id) as $key => $id)
                                                <li class="ml-4 mb-2">
                                                    <a class="text-reset fs-14"
                                                        href="{{ route('products.category', \App\Category::find($id)->slug) }}">{{ \App\Category::find($id)->getTranslation('name') }}</a>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                                {{-- End Category --}}


                                {{-- <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom">
                                        {{ translate('Price range')}}
                                    </div>
                                    <div class="p-3">
                                        <div class="aiz-range-slider">
                                            <div
                                                id="input-slider-range"
                                                data-range-value-min="@if (count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->min('unit_price') }} @endif"
                                                data-range-value-max="@if (count(\App\Product::query()->get()) < 1) 0 @else {{ filter_products(\App\Product::query())->get()->max('unit_price') }} @endif"
                                            ></div>

                                            <div class="row mt-2">
                                                <div class="col-6">
                                                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                                                        @if (isset($min_price))
                                                            data-range-value-low="{{ $min_price }}"
                                                        @elseif($products->min('unit_price') > 0)
                                                            data-range-value-low="{{ $products->min('unit_price') }}"
                                                        @else
                                                            data-range-value-low="0"
                                                        @endif
                                                        id="input-slider-range-value-low"
                                                    ></span>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                                                        @if (isset($max_price))
                                                            data-range-value-high="{{ $max_price }}"
                                                        @elseif($products->max('unit_price') > 0)
                                                            data-range-value-high="{{ $products->max('unit_price') }}"
                                                        @else
                                                            data-range-value-high="0"
                                                        @endif
                                                        id="input-slider-range-value-high"
                                                    ></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                {{-- <div class="bg-white shadow-sm rounded mb-3">
                                    <div class="fs-15 fw-600 p-3 border-bottom">
                                        {{ translate('Filter by color')}}
                                    </div>
                                    <div class="p-3">
                                        <div class="aiz-radio-inline">
                                            @foreach ($all_colors as $key => $color)
                                            <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ \App\Color::where('code', $color)->first()->name }}">
                                                <input
                                                    type="radio"
                                                    name="color"
                                                    value="{{ $color }}"
                                                    onchange="filter()"
                                                    @if (isset($selected_color) && $selected_color == $color) checked @endif
                                                >
                                                <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                    <span class="size-30px d-inline-block rounded" style="background: {{ $color }};"></span>
                                                </span>
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- @foreach ($attributes as $key => $attribute)
                                    @if (\App\Attribute::find($attribute['id']) != null)
                                        <div class="bg-white shadow-sm rounded mb-3">
                                            <div class="fs-15 fw-600 p-3 border-bottom">
                                                {{ translate('Filter by') }} {{ \App\Attribute::find($attribute['id'])->getTranslation('name') }}
                                            </div>
                                            <div class="p-3">
                                                <div class="aiz-checkbox-list">
                                                    @if (array_key_exists('values', $attribute))
                                                        @foreach ($attribute['values'] as $key => $value)
                                                            @php
                                                                $flag = false;
                                                                if(isset($selected_attributes)){
                                                                    foreach ($selected_attributes as $key => $selected_attribute) {
                                                                        if($selected_attribute['id'] == $attribute['id']){
                                                                            if(in_array($value, $selected_attribute['values'])){
                                                                                $flag = true;
                                                                                break;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <label class="aiz-checkbox">
                                                                <input
                                                                    type="checkbox"
                                                                    name="attribute_{{ $attribute['id'] }}[]"
                                                                    value="{{ $value }}" @if ($flag) checked @endif
                                                                    onchange="filter()"
                                                                >
                                                                <span class="aiz-square-check"></span>
                                                                <span>{{ $value }}</span>
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach --}}

                                {{-- <button type="submit" class="btn btn-styled btn-block btn-base-4">Apply filter</button> --}}
                            </div>
                        </div>
                    </div>
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
                </div>
            </form>
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function filter() {
            $('#search-form').submit();
        }

        function rangefilter(arg) {
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
@endsection
