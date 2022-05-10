<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ translate('Make Payment')}}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
</div>
<form action="{{ route('purchase_history.make_partial_payment') }}" class="form-default" role="form" method="POST" id="partial-payment-form">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">
    @php
        $due = $order->grand_total - $order->transactions->sum('amount');
    @endphp
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
                                    <input value="sslcommerz" class="online_payment" type="radio" name="payment_option" checked>
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
                                    <input value="shurjopay" class="online_payment" type="radio" name="payment_option" checked>
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
                                    <input value="nagad" class="online_payment" type="radio" name="payment_option" checked>
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
                                    <input value="bkash" class="online_payment" type="radio" name="payment_option" checked>
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
                            <p class="text-left ml-1 opacity-60">Amount must be between {{ single_price(10) }} to {{ single_price($due) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    function payNow(){
        if($('#amount').val() >= 10.00){
            $('#partial-payment-form').submit();
        }else{
            AIZ.plugins.notify('danger','{{ translate('Please input valid amount') }}');
        }
    }
</script>
