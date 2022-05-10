@extends('frontend.layouts.app')

@section('content')

    <section class="mb-4 mt-4" id="cart-summary">
        <div class="container">
            @if (Session::has('cart') && count(Session::get('cart')) > 0)
                <div class="row mb-3">
                    <div class="col-xxl-10 col-xl-11 mx-auto">
                        <h6 class="h6 bg-matt text-white rounded p-2 mb-0 fw-700">Cart Details</h6>
                        <div class="shadow-sm bg-white p-3 p-lg-4 rounded text-left">
                            <div class="mb-4">
                                <div class="row gutters-5 d-none d-lg-flex border-bottom mb-3 pb-3">
                                    <div class="col-md-5 fw-600">{{ translate('Product') }}</div>
                                    <div class="col fw-600">{{ translate('Price') }}</div>
                                    <div class="col fw-600">{{ translate('Tax') }}</div>
                                    <div class="col fw-600">{{ translate('Quantity') }}</div>
                                    <div class="col fw-600">{{ translate('Total') }}</div>
                                    <div class="col-auto fw-600">{{ translate('Remove') }}</div>
                                </div>
                                <ul class="list-group list-group-flush">
                                    @php
                                        $total = 0;
                                    @endphp
                                    @foreach (Session::get('cart') as $key => $cartItem)
                                        @php
                                            $product = \App\Product::find($cartItem['id']);
                                            $total = $total + $cartItem['price'] * $cartItem['quantity'];
                                            $product_name_with_choice = $product->getTranslation('name');
                                            if ($cartItem['variant'] != null) {
                                                $product_name_with_choice = $product->getTranslation('name') . ' - ' . $cartItem['variant'];
                                            }
                                        @endphp
                                        <li class="list-group-item px-0 px-lg-3">
                                            <div class="row gutters-5">
                                                <div class="col-lg-5 d-flex">
                                                    <span class="mr-2 ml-0">
                                                        <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                            class="img-fit size-60px rounded"
                                                            alt="{{ $product->getTranslation('name') }}">
                                                    </span>
                                                    <span class="fs-14 opacity-60">{{ $product_name_with_choice }}</span>
                                                </div>

                                                <div class="col-lg col-4 order-1 order-lg-0 my-3 my-lg-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-lg-none">{{ translate('Price') }}</span>
                                                    <span
                                                        class="fw-600 fs-16">{{ single_price($cartItem['price']) }}</span>
                                                </div>
                                                <div class="col-lg col-4 order-2 order-lg-0 my-3 my-lg-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-lg-none">{{ translate('Tax') }}</span>
                                                    <span
                                                        class="fw-600 fs-16">{{ single_price($cartItem['tax']) }}</span>
                                                </div>

                                                <div class="col-lg col-6 order-4 order-lg-0">
                                                    @if ($cartItem['digital'] != 1)
                                                        <div
                                                            class="row no-gutters align-items-center aiz-plus-minus mr-2 ml-0">
                                                            <button
                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                type="button" data-type="minus"
                                                                data-field="quantity[{{ $key }}]">
                                                                <i class="las la-minus"></i>
                                                            </button>
                                                            <input type="text" name="quantity[{{ $key }}]"
                                                                class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                                                placeholder="1" value="{{ $cartItem['quantity'] }}"
                                                                min="1" max="10" readonly
                                                                onchange="updateQuantity({{ $key }}, this)">
                                                            <button
                                                                class="btn col-auto btn-icon btn-sm btn-circle btn-light"
                                                                type="button" data-type="plus"
                                                                data-field="quantity[{{ $key }}]">
                                                                <i class="las la-plus"></i>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-lg col-4 order-3 order-lg-0 my-3 my-lg-0">
                                                    <span
                                                        class="opacity-60 fs-12 d-block d-lg-none">{{ translate('Total') }}</span>
                                                    <span
                                                        class="fw-600 fs-16 text-primary">{{ single_price(($cartItem['price'] + $cartItem['tax']) * $cartItem['quantity']) }}</span>
                                                </div>
                                                <div class="col-lg-auto col-6 order-5 order-lg-0 text-right">
                                                    <a href="javascript:void(0)"
                                                        onclick="removeFromCartView(event, {{ $key }})"
                                                        class="btn btn-icon btn-sm btn-soft-primary btn-circle">
                                                        <i class="las la-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="px-3 py-2 mb-4 border-top d-flex justify-content-between">
                                <span class="opacity-60 fs-15">{{ translate('Subtotal') }}</span>
                                <span class="fw-600 fs-17">{{ single_price($total) }}</span>
                            </div>
                            {{-- <div class="row align-items-center">
                            <div class="col-md-6 text-center text-md-left order-1 order-md-0">
                                <a href="{{ route('home') }}" class="btn btn-link">
                                    <i class="las la-arrow-left"></i>
                                    {{ translate('Return to shop')}}
                                </a>
                            </div>
                            <div class="col-md-6 text-center text-md-right">
                                @if (Auth::check())
                                    <a href="{{ route('checkout.shipping_info') }}" class="btn btn-primary fw-600">{{ translate('Continue to Shipping')}}</a>
                                @else
                                    <button class="btn btn-primary fw-600" onclick="showCheckoutModal()">{{ translate('Continue to Shipping')}}</button>
                                @endif
                            </div>
                        </div> --}}
                        </div>
                    </div>
                </div>
                <form class="form-default" data-toggle="validator" action="{{ route('checkout.store_delivery_info') }}"
                    role="form" method="POST">
                    @csrf
                    <div class="row cols-xs-space cols-sm-space cols-md-space">
                        <div class="col-xxl-10 col-xl-11 mx-auto">
                            <h6 class="h6 bg-matt text-white rounded p-2 mb-0 fw-700">Shipping info</h6>
                            @if (Auth::check())
                                <div class="shadow-sm bg-white p-4 rounded mb-4">
                                    <div class="row gutters-5">
                                        @foreach (Auth::user()->addresses as $key => $address)
                                            <div class="col-md-6 mb-3">
                                                <label class="aiz-megabox d-block bg-white mb-0">
                                                    <input type="radio" name="address_id" value="{{ $address->id }}" @if ($address->set_default) checked @endif required>
                                                    <span class="d-flex p-3 aiz-megabox-elem">
                                                        <span class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                        <span class="flex-grow-1 pl-3 text-left">
                                                            <div>
                                                                <span
                                                                    class="opacity-60">{{ translate('Address') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->address }}</span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="opacity-60">{{ translate('Postal Code') }}:</span>
                                                                <span
                                                                    class="fw-600 ml-2">{{ $address->postal_code }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="opacity-60">{{ translate('City') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->ccity }}</span>
                                                            </div>
                                                            <div>
                                                                <span
                                                                    class="opacity-60">{{ translate('Country') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->country }}</span>
                                                            </div>
                                                            <div>
                                                                <span class="opacity-60">{{ translate('Phone') }}:</span>
                                                                <span class="fw-600 ml-2">{{ $address->phone }}</span>
                                                            </div>
                                                        </span>
                                                    </span>
                                                </label>
                                                <div class="dropdown position-absolute right-0 top-0">
                                                    <button class="btn bg-gray px-2" type="button" data-toggle="dropdown">
                                                        <i class="la la-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right"
                                                        aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item"
                                                            onclick="edit_address('{{ $address->id }}')">
                                                            {{ translate('Edit') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        <input type="hidden" name="checkout_type" value="logged">
                                        <div class="col-md-6 mx-auto mb-3">
                                            <div class="border p-3 rounded mb-3 c-pointer text-center bg-white h-100 d-flex flex-column justify-content-center"
                                                onclick="add_new_address()">
                                                <i class="las la-plus la-2x mb-3"></i>
                                                <div class="alpha-7">{{ translate('Add New Address') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="shadow-sm bg-white p-4 rounded mb-4">
                                    <div class="form-group">
                                        <label class="control-label">{{ translate('Name') }}</label>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="{{ translate('Name') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{ translate('Email') }}</label>
                                        <input type="text" class="form-control" name="email"
                                            placeholder="{{ translate('Email') }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">{{ translate('Address') }}</label>
                                        <input type="text" class="form-control" name="address"
                                            placeholder="{{ translate('Address') }}" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label
                                                    class="control-label">{{ translate('Select your country') }}</label>
                                                <select class="form-control aiz-selectpicker" data-live-search="true"
                                                    name="country">
                                                    @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                                        <option value="{{ $country->name }}">{{ $country->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'area_wise_shipping')
                                                    <label class="control-label">{{ translate('Courier') }}</label>
                                                    <select class="form-control aiz-selectpicker" data-live-search="true"
                                                        name="city" required>
                                                        @foreach (\App\City::get() as $key => $city)
                                                            <option value="{{ $city->name }}">
                                                                {{ $city->getTranslation('name') }}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <label class="control-label">{{ translate('City') }}</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ translate('City') }}" name="city" required>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('City') }}</label>
                                                <input type="text" class="form-control"
                                                    placeholder="{{ translate('City') }}" name="ccity"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('Postal code') }}</label>
                                                <input type="text" class="form-control"
                                                    placeholder="{{ translate('Postal code') }}" name="postal_code"
                                                    >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group has-feedback">
                                                <label class="control-label">{{ translate('Phone') }}</label>
                                                <input type="number" lang="en" min="0" class="form-control"
                                                    placeholder="{{ translate('Phone') }}" name="phone" required>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="checkout_type" value="guest">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row cols-xs-space cols-sm-space cols-md-space">
                        <div class="col-xxl-10 col-xl-11 mx-auto text-left">
                            @php
                                $admin_products = [];
                                $seller_products = [];
                                foreach (Session::get('cart') as $key => $cartItem) {
                                    if (\App\Product::find($cartItem['id'])->added_by == 'admin') {
                                        array_push($admin_products, $cartItem['id']);
                                    } else {
                                        $product_ids = [];
                                        if (array_key_exists(\App\Product::find($cartItem['id'])->user_id, $seller_products)) {
                                            $product_ids = $seller_products[\App\Product::find($cartItem['id'])->user_id];
                                        }
                                        array_push($product_ids, $cartItem['id']);
                                        $seller_products[\App\Product::find($cartItem['id'])->user_id] = $product_ids;
                                    }
                                }
                            @endphp

                            @if (!empty($admin_products))
                                <div class="card mb-3 shadow-sm border-0 rounded">
                                    <div class="card-header p-3">
                                        <h5 class="fs-16 fw-600 mb-0">{{ get_setting('site_name') }}
                                            {{ translate('Products') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="list-group list-group-flush">
                                            @foreach ($admin_products as $key => $cartItem)
                                                @php
                                                    $product = \App\Product::find($cartItem);
                                                @endphp
                                                <li class="list-group-item">
                                                    <div class="d-flex">
                                                        <span class="mr-2">
                                                            <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                class="img-fit size-60px rounded"
                                                                alt="{{ $product->getTranslation('name') }}">
                                                        </span>
                                                        <span
                                                            class="fs-14 opacity-60">{{ $product->getTranslation('name') }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                            <div class="row border-top pt-3">
                                                <div class="col-md-6">
                                                    <h6 class="fs-15 fw-600">{{ translate('Choose Delivery Type') }}</h6>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row gutters-5">
                                                        <div class="col-6">
                                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                                <input type="radio"
                                                                    name="shipping_type_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                                    value="home_delivery" onchange="show_pickup_point(this)"
                                                                    data-target=".pickup_point_id_admin" checked>
                                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                                    <span
                                                                        class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                    <span
                                                                        class="flex-grow-1 pl-3 fw-600">{{ translate('Home Delivery') }}</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="aiz-megabox d-block bg-white mb-0">
                                                                <input type="radio"
                                                                    name="shipping_type_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                                    value="pickup_point" onchange="show_pickup_point(this)"
                                                                    data-target=".pickup_point_id_admin">
                                                                <span class="d-flex p-3 aiz-megabox-elem">
                                                                    <span
                                                                        class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                    <span
                                                                        class="flex-grow-1 pl-3 fw-600">{{ translate('Local Pickup') }}</span>
                                                                </span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4 pickup_point_id_admin d-none">
                                                        <select class="form-control aiz-selectpicker"
                                                            name="pickup_point_id_{{ \App\User::where('user_type', 'admin')->first()->id }}"
                                                            data-live-search="true">
                                                            <option>{{ translate('Select your nearest pickup point') }}
                                                            </option>
                                                            @foreach (\App\PickupPoint::where('pick_up_status', 1)->get() as $key => $pick_up_point)
                                                                <option value="{{ $pick_up_point->id }}" data-content="<span class='d-block'>
                                                                                <span class='d-block fs-16 fw-600 mb-2'>{{ $pick_up_point->getTranslation('name') }}</span>
                                                                                <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ $pick_up_point->getTranslation('address') }}</span>
                                                                                <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i>{{ $pick_up_point->phone }}</span>
                                                                            </span>">
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer text-center">
                                        <input type="hidden" name="owner_id"
                                            value="{{ App\User::where('user_type', 'admin')->first()->id }}">
                                        @if (Auth::check())
                                            <button type="submit"
                                                class="btn btn-primary fw-600">{{ translate('Continue to Payment') }}</button>
                                        @else
                                            <button class="btn btn-primary fw-600"
                                                onclick="showCheckoutModal()">{{ translate('Continue to Payment') }}</button>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            @if (!empty($seller_products))
                                @foreach ($seller_products as $key => $seller_product)
                                    <div class="card mb-3 shadow-sm border-0 rounded">
                                        <div class="card-header p-3">
                                            <h5 class="fs-16 fw-600 mb-0">
                                                {{ \App\Shop::where('user_id', $key)->first()->name }}
                                                {{ translate('Products') }}</h5>
                                        </div>
                                        <div class="card-body">
                                            <ul class="list-group list-group-flush">
                                                @foreach ($seller_product as $cartItem)
                                                    @php
                                                        $product = \App\Product::find($cartItem);
                                                    @endphp
                                                    <li class="list-group-item">
                                                        <div class="d-flex">
                                                            <span class="mr-2">
                                                                <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                                                                    class="img-fit size-60px rounded"
                                                                    alt="{{ $product->getTranslation('name') }}">
                                                            </span>
                                                            <span
                                                                class="fs-14 opacity-60">{{ $product->getTranslation('name') }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                                <div class="row border-top pt-3">
                                                    <div class="col-md-6">
                                                        <h6 class="fs-15 fw-600">{{ translate('Choose Delivery Type') }}
                                                        </h6>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row gutters-5">
                                                            <div class="col-6">
                                                                <label class="aiz-megabox d-block bg-white mb-0">
                                                                    <input type="radio"
                                                                        name="shipping_type_{{ $key }}"
                                                                        value="home_delivery"
                                                                        onchange="show_pickup_point(this)"
                                                                        data-target=".pickup_point_id_{{ $key }}"
                                                                        checked>
                                                                    <span class="d-flex p-3 aiz-megabox-elem">
                                                                        <span
                                                                            class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                        <span
                                                                            class="flex-grow-1 pl-3 fw-600">{{ translate('Home Delivery') }}</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            @if (is_array(json_decode(\App\Shop::where('user_id',
                                                            $key)->first()->pick_up_point_id)))
                                                            <div class="col-6">
                                                                <label class="aiz-megabox d-block bg-white mb-0">
                                                                    <input type="radio"
                                                                        name="shipping_type_{{ $key }}"
                                                                        value="pickup_point"
                                                                        onchange="show_pickup_point(this)"
                                                                        data-target=".pickup_point_id_{{ $key }}">
                                                                    <span class="d-flex p-3 aiz-megabox-elem">
                                                                        <span
                                                                            class="aiz-rounded-check flex-shrink-0 mt-1"></span>
                                                                        <span
                                                                            class="flex-grow-1 pl-3 fw-600">{{ translate('Local Pickup') }}</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                            @endif
                                        </div>
                                        @if (\App\BusinessSetting::where('type', 'pickup_point')->first()->value == 1)
                                            @if (is_array(json_decode(\App\Shop::where('user_id',
                                            $key)->first()->pick_up_point_id)))
                                            <div class="mt-4 pickup_point_id_{{ $key }} d-none">
                                                <select class="form-control aiz-selectpicker"
                                                    name="pickup_point_id_{{ $key }}" data-live-search="true">
                                                    <option>{{ translate('Select your nearest pickup point') }}</option>
                                                    @foreach (json_decode(\App\Shop::where('user_id', $key)->first()->pick_up_point_id) as $pick_up_point)
                                                        @if (\App\PickupPoint::find($pick_up_point) != null)
                                                            <option
                                                                value="{{ \App\PickupPoint::find($pick_up_point)->id }}"
                                                                data-content="<span class='d-block'>
                                                                                                <span class='d-block fs-16 fw-600 mb-2'>{{ \App\PickupPoint::find($pick_up_point)->getTranslation('name') }}</span>
                                                                                                <span class='d-block opacity-50 fs-12'><i class='las la-map-marker'></i> {{ \App\PickupPoint::find($pick_up_point)->getTranslation('address') }}</span>
                                                                                                <span class='d-block opacity-50 fs-12'><i class='las la-phone'></i> {{ \App\PickupPoint::find($pick_up_point)->phone }}</span>
                                                                                            </span>">
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                @endif
                        </div>
                    </div>
            @endif
        </div>
        <div class="card-footer text-center">
            <input type="hidden" name="owner_id" value="{{ $key }}">
            @if (Auth::check())
                <button type="submit" class="btn btn-primary fw-600">{{ translate('Continue to Payment') }}</button>
            @else
                <button class="btn btn-primary fw-600"
                    onclick="showCheckoutModal()">{{ translate('Continue to Payment') }}</button>
            @endif
        </div>
        </div>
        @endforeach
        @endif
        </div>
        </form>
    @else
        <div class="row">
            <div class="col-xl-10 mx-auto">
                <div class="shadow-sm bg-white p-4 rounded">
                    <div class="text-center p-3">
                        <i class="las la-frown la-3x opacity-60 mb-3"></i>
                        <h3 class="h4 fw-700">{{ translate('Your Cart is empty') }}</h3>
                    </div>
                </div>
            </div>
        </div>
        @endif
        </div>
    </section>

@endsection

@section('modal')
    <div class="modal fade" id="GuestCheckout">
        <div class="modal-dialog modal-dialog-zoom">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title fw-600">{{ translate('Login') }}</h6>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="p-3">
                        <form class="form-default" role="form" action="{{ route('cart.login.submit') }}" method="POST">
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
                                    <span class="opacity-60">{{ translate('Use country code before number') }}</span>
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

                    </div>
                    <div class="text-center mb-3">
                        <p class="text-muted mb-0">{{ translate('Dont have an account?') }}</p>
                        <a href="{{ route('user.registration') }}">{{ translate('Register Now') }}</a>
                    </div>
                    @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1 || \App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                        <div class="separator mb-3">
                            <span class="bg-white px-3 opacity-60">{{ translate('Or Login With') }}</span>
                        </div>
                        <ul class="list-inline social colored text-center mb-3">
                            @if (\App\BusinessSetting::where('type', 'facebook_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                        <i class="lab la-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'google_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                        <i class="lab la-google"></i>
                                    </a>
                                </li>
                            @endif
                            @if (\App\BusinessSetting::where('type', 'twitter_login')->first()->value == 1)
                                <li class="list-inline-item">
                                    <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                        <i class="lab la-twitter"></i>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                    @if (\App\BusinessSetting::where('type', 'guest_checkout_active')->first()->value == 1)
                        <!-- <div class="separator mb-3">
                                        <span class="bg-white px-3 opacity-60">{{ translate('Or') }}</span>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ route('checkout.shipping_info') }}" class="btn btn-soft-primary">{{ translate('Guest Checkout') }}</a>
                                    </div> -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-address-modal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-zoom" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form-default" role="form" action="{{ route('addresses.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="p-3">
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Address') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <textarea class="form-control textarea-autogrow mb-3"
                                        placeholder="{{ translate('Your Address') }}" rows="1" name="address"
                                        required></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Country') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                        name="country" required>
                                        <option value="">Select Country</option>
                                        @foreach (\App\Country::where('status', 1)->get() as $key => $country)
                                            <option value="{{ $country->name }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if (\App\BusinessSetting::where('type', 'shipping_type')->first()->value == 'area_wise_shipping')
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('City') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <select class="form-control mb-3 aiz-selectpicker" data-live-search="true"
                                            name="city" required>

                                        </select>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-2">
                                        <label>{{ translate('City') }}</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control mb-3"
                                            placeholder="{{ translate('Your City') }}" name="city" value="" required>
                                    </div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Postal code') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3"
                                        placeholder="{{ translate('Your Postal Code') }}" name="postal_code" value=""
                                        required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>{{ translate('Phone') }}</label>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control mb-3" placeholder="{{ translate('+880') }}"
                                        name="phone" value="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit-address-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ translate('New Address') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body" id="edit_modal_body">

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        function removeFromCartView(e, key) {
            e.preventDefault();
            removeFromCart(key);
        }

        function updateQuantity(key, element) {
            $.post('{{ route('cart.updateQuantity') }}', {
                _token: '{{ csrf_token() }}',
                key: key,
                quantity: element.value
            }, function(data) {
                updateNavCart();
                $('#cart-summary').html(data);
            });
        }

        function showCheckoutModal() {
            $('#GuestCheckout').modal();
        }
    </script>
    <script type="text/javascript">
        function edit_address(address) {
            var url = '{{ route('addresses.edit', ':id') }}';
            url = url.replace(':id', address);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#edit_modal_body').html(response);
                    $('#edit-address-modal').modal('show');
                    AIZ.plugins.bootstrapSelect('refresh');
                    var country = $("#edit_country").val();
                    get_city(country);
                }
            });
        }

        $(document).on('change', '[name=country]', function() {
            var country = $(this).val();
            get_city(country);
        });

        function get_city(country) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('get-city') }}",
                type: 'POST',
                data: {
                    country_name: country
                },
                success: function(response) {
                    var obj = JSON.parse(response);
                    if (obj != '') {
                        $('[name="city"]').html(obj);
                        AIZ.plugins.bootstrapSelect('refresh');
                    }
                }
            });
        }

        function add_new_address() {
            $('#new-address-modal').modal('show');
        }
    </script>
@endsection