@extends('backend.layouts.app')

@section('content')
@if(env('MAIL_USERNAME') == null && env('MAIL_PASSWORD') == null)
    <div class="">
        <div class="alert alert-danger d-flex align-items-center">
            {{translate('Please Configure SMTP Setting to work all email sending functionality')}},
            <a class="alert-link ml-2" href="{{ route('smtp_settings.index') }}">{{ translate('Configure Now') }}</a>
        </div>
    </div>
@endif
@if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
<div class="row gutters-10">
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ single_price(\App\Order::all()->sum('grand_total')) }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Sales') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Order::all()->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Orders') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Product::all()->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Products') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Customer::all()->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Customers') }}</span>                            
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gutters-10">
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Order::where('viewed', 0)->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('New Order') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Product::where('added_by', 'admin')->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Admin Products') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Brand::all()->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Product Brands') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Category::all()->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Product Categories') }}</span>                            
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row gutters-10">
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Seller::all()->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Vendor') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Seller::where('verification_status', 1)->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Approved Vendor') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Seller::where('verification_status', 0)->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Pending Vendor') }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bg-grad text-white rounded-lg mb-4 overflow-hidden">
            <div class="px-3 pt-3 mb-3">
                <div class="h3 fw-700 mb-3">{{ \App\Product::where('added_by', 'seller')->count() }}</div>
                <div class="opacity-50">
                    <span class="fs-16 d-block">{{ translate('Total Vendor Products') }}</span>                            
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@if(Auth::user()->user_type == 'admin' || in_array('1', json_decode(Auth::user()->staff->role->permissions)))
    <div class="row gutters-10">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fs-14">{{ translate('Sales Report') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="graph-1" class="w-100" height="500"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fs-14">{{ translate('Sales Analystics') }}</h6>
                </div>
                <div class="card-body">
                    <canvas id="graph-2" class="w-100" height="500"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0 fs-14">{{ translate('Latest Order') }}</h6>
                </div>
                <div class="card-body">
                    <table class="table aiz-table mb-0">
                        <thead>
                            <tr>
                                <th>{{ translate('Order Code') }}</th>
                                <th data-breakpoints="md">{{ translate('Num. of Products') }}</th>
                                <th data-breakpoints="md">{{ translate('Customer') }}</th>
                                <th data-breakpoints="md">{{ translate('Amount') }}</th>
                                <th data-breakpoints="md">{{ translate('Payment Status') }}</th>
                                <th class="text-right" width="20%">{{translate('options')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (\App\Order::where('seller_id', Auth::user()->id)->orderBy('code', 'desc')->take(10)->get() as $key => $order)
                            <tr>
                                <td>
                                    {{ $order->code }}
                                </td>
                                <td>
                                    {{ count($order->orderDetails) }}
                                </td>
                                <td>
                                    @if ($order->user != null)
                                    {{ $order->user->name }}
                                    @else
                                    Guest ({{ $order->guest_id }})
                                    @endif
                                </td>
                                <td>
                                    {{ single_price($order->grand_total) }}
                                </td>
                                <td>
                                    @if ($order->payment_status == 'paid')
                                    <span class="badge badge-inline badge-success">{{translate('Paid')}}</span>
                                    @elseif ($order->payment_status == 'partial')
                                    <span class="badge badge-inline badge-info">{{translate('Partial')}}</span>
                                    @else
                                    <span class="badge badge-inline badge-danger">{{translate('Unpaid')}}</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{route('all_orders.show', encrypt($order->id))}}" title="{{ translate('View') }}">
                                        <i class="las la-eye"></i>
                                    </a>
                                    <a class="btn btn-soft-primary btn-icon btn-circle btn-sm" href="{{ route('invoice.download', $order->id) }}" title="{{ translate('Download Invoice') }}">
                                        <i class="las la-download"></i>
                                    </a>
                                    <a href="#" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" data-href="{{route('orders.destroy', $order->id)}}" title="{{ translate('Delete') }}">
                                        <i class="las la-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif


@endsection
@section('script')
<script type="text/javascript">
    AIZ.plugins.chart('#graph-1',{
        type: 'bar',
        data: {
            labels: [
                @for ($i = 5; $i >= 0; $i--)
                '{{  \Carbon\Carbon::today()->startOfMonth()->subMonth($i)->shortMonthName }}',
                @endfor
            ],
            datasets: [{
                label: '{{ translate('Number of sale') }}',
                data: [
                    @for ($i = 5; $i >= 0; $i--)
                        @php
                            $dt = \Carbon\Carbon::today()->startOfMonth()->subMonth($i);
                        @endphp
                        {{ \App\Order::whereMonth('created_at', $dt->format('m'))->whereYear('created_at', $dt->format('Y'))->count() }},
                    @endfor
                ],
                backgroundColor: [
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                ],
                borderColor: [
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                    'rgba(210,180,140,255)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    gridLines: {
                        color: '#f2f3f8',
                        zeroLineColor: '#f2f3f8'
                    },
                    ticks: {
                        fontColor: "#8b8b8b",
                        fontFamily: 'Poppins',
                        fontSize: 10,
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#f2f3f8'
                    },
                    ticks: {
                        fontColor: "#8b8b8b",
                        fontFamily: 'Poppins',
                        fontSize: 10
                    }
                }]
            },
            legend:{
                labels: {
                    fontFamily: 'Poppins',
                    boxWidth: 10,
                    usePointStyle: true
                },
                onClick: function () {
                    return '';
                },
            }
        }
    });
    AIZ.plugins.chart('#graph-2',{
        type: 'bar',
        data: {
            labels: [
                @for ($i = 6; $i >= 0; $i--)
                '{{  \Carbon\Carbon::today()->subDay($i)->shortDayName }}',
                @endfor
            ],
            datasets: [{
                label: '{{ translate('Amount of sale') }}',
                data: [
                    @for ($i = 5; $i >= 0; $i--)
                        @php
                            $dt = \Carbon\Carbon::today()->subDay($i);
                        @endphp
                        {{ \App\Order::whereDate('created_at', $dt->format('Y-m-d'))->sum('grand_total') }},
                    @endfor
                ],
                backgroundColor: [
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                ],
                borderColor: [
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                    'rgba(104,131,139,255)',
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    gridLines: {
                        color: '#f2f3f8',
                        zeroLineColor: '#f2f3f8'
                    },
                    ticks: {
                        fontColor: "#8b8b8b",
                        fontFamily: 'Poppins',
                        fontSize: 10,
                        beginAtZero: true
                    }
                }],
                xAxes: [{
                    gridLines: {
                        color: '#f2f3f8'
                    },
                    ticks: {
                        fontColor: "#8b8b8b",
                        fontFamily: 'Poppins',
                        fontSize: 10
                    }
                }]
            },
            legend:{
                labels: {
                    fontFamily: 'Poppins',
                    boxWidth: 10,
                    usePointStyle: true
                },
                onClick: function () {
                    return '';
                },
            }
        }
    });
</script>
@endsection
