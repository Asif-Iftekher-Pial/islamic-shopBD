@extends('frontend.layouts.app')

@section('content')
<section class="mb-4 mt-3">
    <div class="container text-left">
        <div class="row">
            <div class="col-lg-8">
                <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST" id="checkout-form">
                    @csrf
                    <div class="card shadow-sm border-0 rounded">
                        {{-- <div class="card-header p-3">
                            <h3 class="fs-16 fw-600 mb-0">
                                {{ translate('Select a payment option')}}
                            </h3>
                        </div> --}}
                        <div class="card-body text-center">
                            @php
                                $subtotal = 0;
                                $tax = 0;
                                $shipping = 0;
                                $product_shipping_cost = 0;
                                $shipping_region = Session::get('shipping_info')['city'];
                            @endphp
                            @foreach (Session::get('cart')->where('owner_id', Session::get('owner_id')) as $key => $cartItem)
                                @php
                                    $product = \App\Product::find($cartItem['id']);
                                    $subtotal += $cartItem['price']*$cartItem['quantity'];
                                    $tax += $cartItem['tax']*$cartItem['quantity'];
                                    
                                    if(isset($cartItem['shipping']) && is_array(json_decode($cartItem['shipping'], true))) {
                                        foreach(json_decode($cartItem['shipping'], true) as $shipping_info => $val) {
                                            if($shipping_region == $shipping_info) {
                                                $product_shipping_cost = (double) $val;
                                            }
                                        }
                                    } else {
                                        $product_shipping_cost = (double) $cartItem['shipping'];
                                    }
                                    
                                    if($product->is_quantity_multiplied == 1 && get_setting('shipping_type') == 'product_wise_shipping') {
                                        $product_shipping_cost = $product_shipping_cost * $cartItem['quantity'];
                                    }
                                    
                                    $shipping += $product_shipping_cost;
                                @endphp
                            @endforeach

                            @php
                                $ttotal = $subtotal+$tax+$shipping;
                                if(Session::has('club_point')) {
                                    $ttotal -= Session::get('club_point');
                                }
                                if(Session::has('coupon_discount')){
                                    $ttotal -= Session::get('coupon_discount');
                                }
                            @endphp
                            @if (Auth::check() && \App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                                <div class="text-center py-4">
                                    <div class="h6 mb-3">
                                        <span class="opacity-80">{{ translate('Your wallet balance :')}}</span>
                                        <span class="fw-600">{{ single_price(Auth::user()->balance) }}</span>
                                    </div>
                                    @if(Auth::user()->balance < $ttotal)
                                        <button type="button" class="btn btn-secondary" disabled>{{ translate('Insufficient balance')}}</button>
                                    @else
                                        <button  type="button" onclick="use_wallet()" class="btn btn-primary fw-600">{{ translate('Pay with wallet')}}</button>
                                    @endif
                                </div>
                            @endif
                            @if (Auth::check() && \App\BusinessSetting::where('type', 'partial_system')->first()->value == 1)
                                @php
                                    $digital_pro = 0;
                                    foreach(Session::get('cart') as $cartItem){
                                        if($cartItem['digital'] == 1){
                                            $digital_pro = 1;
                                        }
                                    }
                                @endphp
                                @if($digital_pro != 1)
                                <div id="partial_payment">
                                    @if (Auth::check() && \App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1)
                                    <div class="separator mb-3 partial_payment_info">
                                        <span class="bg-white px-3">
                                            <span class="opacity-60">{{ translate('Or')}}</span>
                                        </span>
                                    </div>
                                    @endif
                                    <div class="text-center py-4">
                                        <button  type="button" onclick="use_partialPayment()" class="btn btn-info fw-600">{{ translate('Pay Partial Amount')}}</button>
                                    </div>
                                </div>
                                @endif
                            @endif
                            @if (Auth::check() && (\App\BusinessSetting::where('type', 'wallet_system')->first()->value == 1 || \App\BusinessSetting::where('type', 'partial_system')->first()->value == 1))
                            <div class="separator mb-3">
                                <span class="bg-white px-3">
                                    <span class="opacity-60">{{ translate('Or')}}</span>
                                </span>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-xxl-8 col-xl-10 mx-auto">
                                    <div class="row gutters-10">
                                        @if(\App\BusinessSetting::where('type', 'sslcommerz_payment')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="sslcommerz" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/sslcommerz.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('sslcommerz')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\BusinessSetting::where('type', 'shurjopay')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="shurjopay" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/shurjoPay.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('shurjoPay')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\BusinessSetting::where('type', 'nagad')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="nagad" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/nagad.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Nagad')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\BusinessSetting::where('type', 'bkash')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="bkash" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/bkash.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Bkash')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        
                                        @if(\App\BusinessSetting::where('type', 'cash_payment')->first()->value == 1)
                                            @php
                                                $digital = 0;
                                                $cod_on = 1;
                                                foreach(Session::get('cart') as $cartItem){
                                                    if($cartItem['digital'] == 1){
                                                        $digital = 1;
                                                    }
                                                    if($cartItem['cash_on_delivery'] == 0){
                                                        $cod_on = 0;
                                                    }
                                                }
                                            @endphp
                                            @if($digital != 1 && $cod_on == 1)
                                                <div class="col-6 col-md-4">
                                                    <label class="aiz-megabox d-block mb-3">
                                                        <input value="cash_on_delivery" class="online_payment partial_not_available" type="radio" name="payment_option" checked>
                                                        <span class="d-block p-3 aiz-megabox-elem">
                                                            <img src="{{ static_asset('assets/img/cards/cod.png')}}" class="img-fluid mb-2">
                                                            <span class="d-block text-center">
                                                                <span class="d-block fw-600 fs-15">{{ translate('Cash on Delivery')}}</span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                        
                                        @if (Auth::check())
                                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                                @foreach(\App\ManualPaymentMethod::all() as $method)
                                                    <div class="col-6 col-md-4">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="{{ $method->heading }}" type="radio" name="payment_option" onchange="toggleManualPaymentData({{ $method->id }})" data-id="{{ $method->id }}" checked>
                                                            <span class="d-block p-3 aiz-megabox-elem">
                                                                <img src="{{ uploaded_asset($method->photo) }}" class="img-fluid mb-2">
                                                                <span class="d-block text-center">
                                                                    <span class="d-block fw-600 fs-15">{{ $method->heading }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach

                                                @foreach(\App\ManualPaymentMethod::all() as $method)
                                                    <div id="manual_payment_info_{{ $method->id }}" class="d-none">
                                                        @php echo $method->description @endphp
                                                        @if ($method->bank_info != null)
                                                            <ul>
                                                                @foreach (json_decode($method->bank_info) as $key => $info)
                                                                    <li>{{ translate('Bank Name') }} - {{ $info->bank_name }}, {{ translate('Account Name') }} - {{ $info->account_name }}, {{ translate('Account Number') }} - {{ $info->account_number}}, {{ translate('Routing Number') }} - {{ $info->routing_number }}</li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if (\App\Addon::where('unique_identifier', 'offline_payment')->first() != null && \App\Addon::where('unique_identifier', 'offline_payment')->first()->activated)
                                <div class="bg-white border mb-3 p-3 rounded text-left d-none">
                                    <div id="manual_payment_description">

                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="pt-3">
                        <label class="aiz-checkbox">
                            <input type="checkbox" required id="agree_checkbox">
                            <span class="aiz-square-check"></span>
                            <span>{{ translate('I agree to the')}}</span>
                        </label>
                        <a href="{{ route('terms') }}">{{ translate('terms and conditions')}}</a>,
                        <a href="{{ route('returnpolicy') }}">{{ translate('return policy')}}</a> &
                        <a href="{{ route('privacypolicy') }}">{{ translate('privacy policy')}}</a>
                    </div>

                    <div class="row pt-3">
                        <div class="col-12 text-right">
                            <button type="button" onclick="submitOrder(this)" class="btn btn-primary bg-matt fw-600">{{ translate('Complete Order')}}</button>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('home') }}" class="link link--style-3">
                                <i class="las la-arrow-left"></i>
                                {{ translate('Return to shop')}}
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-lg-4 mt-4 mt-lg-0">
                @include('frontend.partials.cart_summary')
            </div>
        </div>
    </div>
</section>
@endsection

@section('modal')
<div class="modal fade" id="partialPaymentModal">
    <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-zoom payment-modal" id="modal-size" role="document">
        <div class="modal-content position-relative">
            <button type="button" class="close absolute-top-right btn-icon close z-1" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="la-2x">&times;</span>
            </button>
            <div id="partial-payment-modal-body">
                <form action="{{ route('payment.checkout') }}" class="form-default" role="form" method="POST" id="partial-checkout-form">
                    @csrf
                    <div class="card shadow-sm border-0 rounded">
                        <div class="card-header p-3">
                            <h3 class="fs-16 fw-600 mb-0">
                                {{ translate('Select a payment option')}}
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-12 mx-auto">
                                    <div class="row gutters-10">
                                        @if(\App\BusinessSetting::where('type', 'sslcommerz_payment')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="sslcommerz" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/sslcommerz.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('sslcommerz')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\BusinessSetting::where('type', 'shurjopay')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="shurjopay" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/shurjoPay.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('shurjoPay')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\BusinessSetting::where('type', 'nagad')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="nagad" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/nagad.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Nagad')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                        @if(\App\BusinessSetting::where('type', 'bkash')->first()->value == 1)
                                            <div class="col-6 col-md-4">
                                                <label class="aiz-megabox d-block mb-3">
                                                    <input value="bkash" class="online_payment partial_available" type="radio" name="payment_option" checked>
                                                    <span class="d-block p-3 aiz-megabox-elem">
                                                        <img src="{{ static_asset('assets/img/cards/bkash.png')}}" class="img-fluid mb-2">
                                                        <span class="d-block text-center">
                                                            <span class="d-block fw-600 fs-15">{{ translate('Bkash')}}</span>
                                                        </span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row gutters-10">
                                        <div class="col">
                                            <div class="input-group">
                                                <input type="hidden" name="payment_type" value="partial">
                                                <input type="number" class="form-control font-weight-bold" id="amount" name="amount" min="10" step="0.01" placeholder="Enter partial amount for payment">
                                                <div class="input-group-append">
                                                    <button type="button" onclick="payNow()" class="btn btn-primary">Pay Now</button>
                                                </div>
                                            </div>
                                            <p class="text-left ml-1 opacity-60">Amount must be between {{ single_price(10) }} to {{ single_price($ttotal) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">

        $(document).ready(function(){
            $(".online_payment").click(function(){
                $('#manual_payment_description').parent().addClass('d-none');
            });
            toggleManualPaymentData($('input[name=payment_option]:checked').data('id'));
        });

        function use_wallet(){
            $('input[name=payment_option]').val('wallet');
            if($('#agree_checkbox').is(":checked")){
                $('#checkout-form').submit();
            }else{
                AIZ.plugins.notify('danger','{{ translate('You need to agree with our policies') }}');
            }
        }
        function use_partialPayment(){
            if($('#agree_checkbox').is(":checked")){
                $('#partialPaymentModal').modal();
            }else{
                AIZ.plugins.notify('danger','{{ translate('You need to agree with our policies') }}');
            }
        }
        function payNow(){
            $('input[name=payment_type]').val('partial');
            if($('#amount').val() >= 10.00){
                $('#partial-checkout-form').submit();
            }else{
                AIZ.plugins.notify('danger','{{ translate('Please input valid amount') }}');
            }
        }
        function submitOrder(el){
            $(el).prop('disabled', true);
            if($('#agree_checkbox').is(":checked")){
                $('#checkout-form').submit();
            }else{
                AIZ.plugins.notify('danger','{{ translate('You need to agree with our policies') }}');
                $(el).prop('disabled', false);
            }
        }

        function toggleManualPaymentData(id){
            if(typeof id != 'undefined'){
                $('#manual_payment_description').parent().removeClass('d-none');
                $('#manual_payment_description').html($('#manual_payment_info_'+id).html());
            }
        }
    </script>
@endsection
