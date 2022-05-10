@extends('frontend.layouts.app')

@section('content')
<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="fw-600 h4">{{ translate('All Categories') }}</h1>
            </div>
            @if (\App\BusinessSetting::where('type', 'breadcums')->first()->value == 1)
            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item opacity-50">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        <a class="text-reset" href="{{ route('categories.all') }}">"{{ translate('All Categories') }}"</a>
                    </li>
                </ul>
            </div>
            @endif
        </div>
    </div>
</section>
<section class="mb-4">
    <div class="container">
        @foreach ($categories as $key => $category)
            <div class="mb-3 bg-white shadow-sm rounded">
                <div class="p-3 border-bottom fs-16 fw-600">
                    <a href="{{ route('products.category', $category->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm" style="height: auto; max-width: 300px;">
                        <img src="{{ uploaded_asset($category->banner) }}" data-src="{{ uploaded_asset($category->banner) }}" alt="{{  $category->getTranslation('name') }}" class="ls-is-cached lazyloaded" height="78" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                    </a>
                    <a href="{{ route('products.category', $category->slug) }}" class="text-reset">{{  $category->getTranslation('name') }}</a>
                </div>
                <div class="p-3 p-lg-4">
                    <div class="row">
                        @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($category->id) as $key => $first_level_id)
                        <div class="col-lg-3 col-6 text-left">
                            <h6 class="mb-3">
                                <a href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}" class="d-block rounded bg-white p-2 text-reset shadow-sm">
                                    <img src="{{ uploaded_asset(\App\Category::find($first_level_id)->banner) }}" data-src="{{ uploaded_asset(\App\Category::find($first_level_id)->banner) }}" alt="{{ \App\Category::find($first_level_id)->getTranslation('name') }}" class="ls-is-cached lazyloaded" height="78" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                </a>
                                <a class="text-reset fw-600 fs-14" href="{{ route('products.category', \App\Category::find($first_level_id)->slug) }}">{{ \App\Category::find($first_level_id)->getTranslation('name') }}</a>
                            </h6>
                            <ul class="mb-3 list-unstyled pl-2">
                                @foreach (\App\Utility\CategoryUtility::get_immediate_children_ids($first_level_id) as $key => $second_level_id)
                                <li class="mb-2">
                                    <a class="text-reset" href="{{ route('products.category', \App\Category::find($second_level_id)->slug) }}" >{{ \App\Category::find($second_level_id)->getTranslation('name') }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@endsection
