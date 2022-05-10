@extends('backend.layouts.app')

@section('content')

    <div class="row">
        <!--<div class="col-lg-12">-->
        <!--    <div class="card">-->
        <!--        <div class="card-header">-->
        <!--            <h5 class="mb-0 h6">{{translate('SSL Wireless Credential')}}</h5>-->
        <!--        </div>-->
        <!--        <div class="card-body">-->
        <!--            <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">-->
        <!--                <input type="hidden" name="otp_method" value="ssl_wireless">-->
        <!--                @csrf-->
        <!--                <div class="form-group row">-->
        <!--                    <input type="hidden" name="types[]" value="SSL_SMS_API_TOKEN">-->
        <!--                    <div class="col-lg-3">-->
        <!--                        <label class="col-from-label">{{translate('SSL SMS API TOKEN')}}</label>-->
        <!--                    </div>-->
        <!--                    <div class="col-lg-6">-->
        <!--                        <input type="text" class="form-control" name="SSL_SMS_API_TOKEN" value="{{  env('SSL_SMS_API_TOKEN') }}" placeholder="SSL SMS API TOKEN" required>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="form-group row">-->
        <!--                    <input type="hidden" name="types[]" value="SSL_SMS_SID">-->
        <!--                    <div class="col-lg-3">-->
        <!--                        <label class="col-from-label">{{translate('SSL SMS SID')}}</label>-->
        <!--                    </div>-->
        <!--                    <div class="col-lg-6">-->
        <!--                        <input type="text" class="form-control" name="SSL_SMS_SID" value="{{  env('SSL_SMS_SID') }}" placeholder="SSL SMS SID" required>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="form-group row">-->
        <!--                    <input type="hidden" name="types[]" value="SSL_SMS_URL">-->
        <!--                    <div class="col-lg-3">-->
        <!--                        <label class="col-from-label">{{translate('SSL SMS URL')}}</label>-->
        <!--                    </div>-->
        <!--                    <div class="col-lg-6">-->
        <!--                        <input type="text" class="form-control" name="SSL_SMS_URL" value="{{  env('SSL_SMS_URL') }}" placeholder="SSL SMS URL" >-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--                <div class="form-group mb-0 text-right">-->
        <!--                    <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>-->
        <!--                </div>-->
        <!--            </form>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 h6">{{translate('Bulk SMS BD Credential')}}</h5>
                </div>
                <div class="card-body">
                    <form class="form-horizontal" action="{{ route('update_credentials') }}" method="POST">
                        <input type="hidden" name="otp_method" value="BulkSmsBD">
                        @csrf
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BulkSmsBD_USERNAME">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('BulkSmsBD USERNAME')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="BulkSmsBD_USERNAME" value="{{  env('BulkSmsBD_USERNAME') }}" placeholder="BulkSmsBD USERNAME" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <input type="hidden" name="types[]" value="BulkSmsBD_PASSWORD">
                            <div class="col-lg-3">
                                <label class="col-from-label">{{translate('BulkSmsBD PASSWORD')}}</label>
                            </div>
                            <div class="col-lg-6">
                                <input type="text" class="form-control" name="BulkSmsBD_PASSWORD" value="{{  env('BulkSmsBD_PASSWORD') }}" placeholder="BulkSmsBD PASSWORD" required>
                            </div>
                        </div>
                        <div class="form-group mb-0 text-right">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
