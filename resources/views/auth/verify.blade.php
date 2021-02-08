@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ __('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('Make sure to check your SPAM folder.') }}
                        {{ __('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                        </form>
                        <p></p>
                        <p>
                            {{ __('In the event that nothing is going through due the email being incorrectly') }}
                            {{ __('inputted), you may reach out to ICTU by clicking ') }}
                            <a data-toggle="collapse" href="#sendRequest" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('here') }}</a>.
                        </p>
                        <p>
                            {{ __('Click ') }}
                            <a data-toggle="collapse" href="#statusRequest" role="button" aria-expanded="false" aria-controls="collapseExample">
                                {{ __('here') }}</a>
                            {{ __(' to check on the status of your requests.') }}

                        </p>
                        <div class="collapse" id="sendRequest">
                            <div class="card card-body">
                                <h5>Submit request</h5>
                                <form method="POST" action="{{ route('rms.account.request') }}">
                                @csrf  

                                <div class="form-group row">
                                   <div class="col-md-12">
                                        <label for="action">{{ __('Requested Action') }}</label>
                                        <input id="action" readonly type="text" class="form-control @error('action') is-invalid @enderror" name="action" value="{{ old('action') ?? 'Email Correction' }}" autocomplete="action">
  
                                        @error('action')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                   <div class="col-md-12">
                                        <label for="remarks">{{ __('Correct Email') }}</label>
                                        <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" autocomplete="remarks">
  
                                        @error('remarks')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-primary float-right">
                                                {{ __('Send request') }}
                                            </button>
                                            <a href="{{ route('verification.notice') }}" class="btn btn-default">
                                                {{ __('Cancel') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>

                        <div class="collapse" id="statusRequest">
                            <div class="card card-body">
                                <h5>Recent email correction requests</h5>
                                <div class="table-responsive">
                                    <table class="table m-0 table-hover">
                                        <thead>
                                            <tr>
                                                <th>Timestamp</th>
                                                <th>Request</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $accountrequests = App\Models\AccountRequest::join('people', 'account_requests.person_id', '=', 'people.id')
                                                ->where('account_requests.person_id', '=', Auth()->user()->person_id)
                                                ->where('account_requests.action', '=', 'Email Correction')
                                                ->get(); ?>
                                            @if(sizeof($accountrequests)> 0)
                                                @foreach($accountrequests as $accountrequest)
                                                    <tr>
                                                        <td>{{ date('M d, Y h:ia', strtotime($accountrequest->created_at) ?? '') }}</td>
                                                        <td>{{ $accountrequest->action ?? '' }}</td>
                                                        <td>{{ $accountrequest->remarks ?? '' }}</td>
                                                        <td>
                                                            <span class="badge badge-{{  $accountrequest->getStatusColor($accountrequest->status) ?? ''}}">
                                                                {{ $accountrequest->getStatuS($accountrequest->status) ?? '' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                            <tr><td colspan="4">No record found.</td></tr>
                                            @endif
                                        </tbody>
                                    </table> 
                                </div>
                            </div>
                        </div<
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
