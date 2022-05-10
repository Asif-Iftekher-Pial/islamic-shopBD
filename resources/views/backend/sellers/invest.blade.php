@extends('backend.layouts.app')

@section('content')


<div class="card">
      <div class="card-header row gutters-5">
        <div class="col text-center text-md-left">
          <h5 class="mb-md-0 h6">{{ translate('All Investors') }}</h5>
        </div>
      </div>
    <div class="card-body">
        <table class="table aiz-table mb-0">
            <thead>
            <tr>
                <th data-breakpoints="lg">#</th>
                <th>{{translate('Email')}}</th>
                <th data-breakpoints="lg">{{translate('Amount')}}</th>
                <th data-breakpoints="lg">{{translate('Profit')}}</th>
                <th>{{translate('Name')}}</th>
                <th>{{translate('Phone')}}</th>
                <th>{{translate('Photo')}}</th>
                <th data-breakpoints="lg">{{translate('Age')}}</th>
                <th data-breakpoints="lg">{{translate('Pre Addr')}}</th>
                <th data-breakpoints="lg">{{translate('Per Addr')}}</th>
                <th data-breakpoints="lg">{{translate('Income Source')}}</th>
                <th data-breakpoints="lg">{{translate('Qualification')}}</th>
                <th data-breakpoints="lg">{{translate('Alem Names')}}</th>
            </tr>
            </thead>
            <tbody>
                @foreach($invests as $key => $invest)
                <tr>
                    <td>{{ ($key+1) + ($invests->currentPage() - 1)*$invests->perPage() }}</td>
                    <td>{{$invest->email}}</td>
                    <td>{{$invest->amount}} Lac</td>
                    <td>{{$invest->profit}}</td>
                    <td>{{$invest->name}}</td>
                    <td>{{$invest->phone}}</td>
                    <td>
                        @if($invest->photo != null)
                                <img class="h-50px" src="{{ uploaded_asset($invest->photo) }}" alt="{{$invest->name}}">
                            @else
                                —
                            @endif
                    </td>
                    <td>{{$invest->age}}</td>
                    <td>{{$invest->present}}</td>
                    <td>{{$invest->permanent}}</td>
                    <td>{{$invest->income_source}}</td>
                    <td>{{$invest->educational_qualification}}</td>
                    <td>{{$invest->alem_names}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="aiz-pagination">
          {{ $invests->links() }}
        </div>
    </div>
</div>

@endsection

@section('modal')
	<!-- Delete Modal -->
	@include('modals.delete_modal')
@endsection

@section('script')
@endsection
