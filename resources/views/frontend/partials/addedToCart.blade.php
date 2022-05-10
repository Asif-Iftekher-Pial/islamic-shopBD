<div class="modal-body added-to-cart card">
    <div class="text-center text-matt card-header">
        <h3>{{ translate('Item added to your cart!')}}</h3>
    </div>
    <div class="media mb-4 card-body">
        <img src="{{ static_asset('assets/img/placeholder.jpg') }}" data-src="{{ uploaded_asset($product->thumbnail_img) }}" class="mr-3 lazyload size-100px img-fit rounded" alt="Product Image">
        <div class="media-body text-left">
            <h6 class="fw-600">
                {{  $product->getTranslation('name')  }}
            </h6>
            <div class="row mt-3">
                <div class="col-sm-3 opacity-60">
                    <div>{{ translate('Price')}}:</div>
                </div>
                <div class="col-sm-9">
                    <div class="h6 text-primary">
                        <strong>
                            {{ single_price(($data['price']+$data['tax'])*$data['quantity']) }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center card-footer">
        <button class="btn btn-outline-primary mb-sm-0" data-dismiss="modal">{{ translate('Back to shopping')}}</button>
        <a href="{{ route('cart') }}" class="btn btn-primary mb-sm-0 bg-matt">{{ translate('Proceed to Checkout')}}</a>
    </div>
</div>
