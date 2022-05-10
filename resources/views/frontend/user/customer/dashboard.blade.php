@extends('frontend.layouts.user_panel')

@section('panel_content')
    <div class="aiz-titlebar mt-2 mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ translate('Dashboard') }}</h1>
            </div>
        </div>
    </div>
    <div class="row gutters-10">
		<div class="col-md-4">
			<div class="bg-matt text-white rounded-lg mb-4 overflow-hidden">
				<div class="px-3 py-3">
                    @if(Session::has('cart'))
                        <div class="h3 fw-700">{{ count(Session::get('cart'))}} {{ translate('Product(s)') }}</div>
                    @else
                        <div class="h3 fw-700">0 {{ translate('Product') }}</div>
                    @endif
			            <div class="opacity-50">{{ translate('in your cart') }}</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="bg-matt text-white rounded-lg mb-4 overflow-hidden">
				<div class="px-3 py-3">
                    @php
                        $orders = \App\Order::where('user_id', Auth::user()->id)->get();
                        $total = 0;
                        foreach ($orders as $key => $order) {
                            $total += count($order->orderDetails);
                        }
                    @endphp
  					<div class="h3 fw-700">{{ count(Auth::user()->wishlists)}} {{ translate('Product(s)') }}</div>
  					<div class="opacity-50">{{ translate('in your wishlist') }}</div>
                </div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="bg-matt text-white rounded-lg mb-4 overflow-hidden">
				<div class="px-3 py-3">
                    @php
                        $orders = \App\Order::where('user_id', Auth::user()->id)->get();
                        $total = 0;
                        foreach ($orders as $key => $order) {
                            $total += count($order->orderDetails);
                        }
                    @endphp
					<div class="h3 fw-700">{{ $total }} {{ translate('Product(s)') }}</div>
					<div class="opacity-50">{{ translate('you ordered') }}</div>
	            </div>
			</div>
		</div>
	</div>
    <div class="row gutters-10">
		<div class="col-md-6">
			<div class="card">
                <div class="card-header">
                    <h6 class="mb-0">{{ translate('Default Shipping Address') }}</h6>
                </div>
		        <div class="card-body">
                  @if(Auth::user()->addresses != null)
                      @php
                          $address = Auth::user()->addresses->where('set_default', 1)->first();
                      @endphp
                      @if($address != null)
                          <ul class="list-unstyled mb-0">
			                  <li class=" py-2"><span>{{ translate('Address') }} : {{ $address->address }}</span></li>
                              <li class=" py-2"><span>{{ translate('Country') }} : {{ $address->country }}</span></li>
                              <li class=" py-2"><span>{{ translate('City') }} : {{ $address->city }}</span></li>
                              <li class=" py-2"><span>{{ translate('Postal Code') }} : {{ $address->postal_code }}</span></li>
                              <li class=" py-2"><span>{{ translate('Phone') }} : {{ $address->phone }}</span></li>
                          </ul>
                      @endif
                  @endif
				</div>
			</div>
		</div>
        @if (\App\BusinessSetting::where('type', 'classified_product')->first()->value)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">{{ translate('Purchased Package') }}</h6>
                    </div>
                    <div class="card-body text-center">
                        @php
                            $customer_package = \App\CustomerPackage::find(Auth::user()->customer_package_id);
                        @endphp
                        @if($customer_package != null)
                            <img src="{{ uploaded_asset($customer_package->logo) }}" class="img-fluid mb-4 h-110px">
                    		<p class="mb-1 text-muted">{{ translate('Product Upload') }}: {{ $customer_package->product_upload }} {{ translate('Times')}}</p>
                    		<p class="text-muted mb-4">{{ translate('Product Upload Remaining') }}: {{ Auth::user()->remaining_uploads }} {{ translate('Times')}}</p>
                            <h5 class="fw-600 mb-3 text-primary">{{ translate('Current Package') }}: {{ $customer_package->getTranslation('name') }}</h5>
                        @else
                            <h5 class="fw-600 mb-3 text-primary">{{translate('Package Not Found')}}</h5>
                        @endif
                        <a href="{{ route('customer_packages_list_show') }}" class="btn btn-success d-inline-block">{{ translate('Upgrade Package') }}</a>
                    </div>
                </div>
            </div>
        @endif
	</div>
@endsection
