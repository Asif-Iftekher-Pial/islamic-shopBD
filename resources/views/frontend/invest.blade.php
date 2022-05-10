@extends('frontend.layouts.app')

@section('content')

<section class="pt-4 mb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-6 mx-auto">
                <h1 class="fw-600 h4 text-center">Invest at Islamic Shop Bangladesh</h1>
                <p>আসসালামু আলাইকুম।</p>
                <p>আমরা ইসলামিক শপ বাংলাদেশ নতুন করে বিনিয়োগ নিচ্ছি। শীতকালীন পোষাক তৈরীতে আমাদের বেশ বড় বাজেটের বিনিয়োগ প্রয়োজন। খুব কম সময়ের মাঝে নিরাপদ বিনিয়োগের এই পরিবেশটি কাজে লাগাতে পারেন।</p>
                <p>সম্মানীত ভাই/বোন, ইসলামিক শপ বাংলাদেশে আপনাকে স্বাগতম। নিচের তথ্যগুলো সঠিকভাবে দিন। আপনার তথ্যগুলো পর্যালোচনা করে আমরা আপনাকে ইমেইল/কল করব ইনশাআল্লাহ্‌।</p>
                <br>
                <p>***বিনিয়োগের ধরনঃ মুদারাবা বা লাভের অংশীদারীত্ব।</p>
                <p class="text-danger">* Required</p>
            </div>
        </div>
    </div>
</section>

<section class="pb-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-6 mx-auto">
                <div class="card text-left">
                    <div class="card-body">
                        <form action="{{ route('invest_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus placeholder="email@example.com">

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="amount">বিনিয়োগের এর পরিমান ( টাকা ) *</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="amount" id="1" value="1" checked>
                                    <label class="form-check-label" for="1">
                                        ১ লাখ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="amount" id="2_4" value="2_4">
                                    <label class="form-check-label" for="2_4">
                                        ২-৪ লাখ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="amount" id="5_7" value="5_7">
                                    <label class="form-check-label" for="5_7">
                                        ৫-৭ লাখ
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="amount" id="10" value="10">
                                    <label class="form-check-label" for="10">
                                        ১০+ লাখ
                                    </label>
                                </div>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="profit">প্রতি ১ লাখ টাকা বিনিয়োগে ১ বছরে কত টাকা মুনাফা প্রত্যাশা করেন? ( টাকার পরিমান লিখুন ) *</label>
                                <input id="profit" type="number" class="form-control{{ $errors->has('profit') ? ' is-invalid' : '' }}" name="profit" value="{{ old('profit') }}" required >

                                @if ($errors->has('profit'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('profit') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">নাম *</label>
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required placeholder="{{ translate('Full Name') }}">

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="phone">মোবাইল নাম্বার *</label>
                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required >

                                @if ($errors->has('phone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="age">আপনার বয়স *</label>
                                <input id="age" type="number" class="form-control{{ $errors->has('age') ? ' is-invalid' : '' }}" name="age" value="{{ old('age') }}" required >

                                @if ($errors->has('age'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('age') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="present">বর্তমান ঠিকানা *</label>
                                <input id="present" type="text" class="form-control{{ $errors->has('present') ? ' is-invalid' : '' }}" name="present" value="{{ old('present') }}" required >

                                @if ($errors->has('present'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('present') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="permanent">স্থায়ী ঠিকানা *</label>
                                <input id="permanent" type="text" class="form-control{{ $errors->has('permanent') ? ' is-invalid' : '' }}" name="permanent" value="{{ old('permanent') }}" required >

                                @if ($errors->has('permanent'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('permanent') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="income_source">বর্তমান পেশা এবং আয়ের উৎস *</label>
                                <input id="income_source" type="text" class="form-control{{ $errors->has('income_source') ? ' is-invalid' : '' }}" name="income_source" value="{{ old('income_source') }}" required >

                                @if ($errors->has('income_source'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('income_source') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="educational_qualification">আপনার সর্বোচ্চ শিক্ষাগত যোগ্যতা *</label>
                                <input id="educational_qualification" type="text" class="form-control{{ $errors->has('educational_qualification') ? ' is-invalid' : '' }}" name="educational_qualification" value="{{ old('educational_qualification') }}" required >

                                @if ($errors->has('educational_qualification'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('educational_qualification') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="alem_names">আপনার পছন্দের পাঁচজন আলেমের নাম লিখুন। *</label>
                                <input id="alem_names" type="text" class="form-control{{ $errors->has('alem_names') ? ' is-invalid' : '' }}" name="alem_names" value="{{ old('alem_names') }}" required >

                                @if ($errors->has('alem_names'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alem_names') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="photo">আপনার একটি সাম্প্রতিক ছবি দিন। *</label>
                                <input id="photo" type="file" class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}" name="photo" >

                                @if ($errors->has('photo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-secondary btn-lg btn-block">
                                {{ translate('Submit') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
