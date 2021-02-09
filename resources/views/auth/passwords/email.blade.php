@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('request'))
                            <div class="alert alert-success" role="alert">
                                {{ session('request') }}
                                Click <strong><a href="{{ route('help.track-request', session('request_id')) }}" 
                                    class="text-primary" onclick="event.preventDefault(); 
                                        document.getElementById('track-request').submit();">here</a></strong> 
                                    to check the status of your request.
                                    <form id="track-request" action="{{ route('help.track-request') }}" method="POST" class="d-none">
                                        @csrf
                                        <input name="id" type="hidden" name="id" value="{{ session('request_id') }}">
                                    </form>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-4">
                                    <a class="btn btn-link float-right" 
                                        data-toggle="collapse" href="#sendRequest" role="button" aria-expanded="false" 
                                        aria-controls="collapseExample">
											{{ __('No email received?') }}
										</a>
                                    </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="collapse @error('remarks1') {{ 'show' }} @enderror @error('remarks2') {{ 'show' }} @enderror" id="sendRequest">
                            <div class="card card-body">
                                <h5><u>Submit request</u> | <a href="{{ route('help.track-requests') }}">Check request status instead</a></h5>
                                <br>
                                <form method="POST" action="{{ route('rms.account.request') }}">
                                @csrf  

                                <div class="form-group row">
                                   <div class="col-md-12">
                                        <label for="action">{{ __('Requested Action') }}</label>
                                        <input id="action" readonly type="text" class="form-control @error('action') is-invalid @enderror" name="action" value="{{ old('action') ?? 'Account Lookup' }}" autocomplete="action">
  
                                        @error('action')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                   <div class="col-md-12">
                                        <label for="remarks1">{{ __('Name') }}</label>
                                        <input id="remarks1" type="text" class="form-control @error('remarks1') is-invalid @enderror" name="remarks1" value="{{ old('remarks1') }}" placeholder="e.g. Fernando Enad" autocomplete="remarks1">
  
                                        @error('remarks1')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                   <div class="col-md-12">
                                        <label for="remarks2">{{ __('DepEd Email') }}</label>
                                        <input id="remarks2" type="text" class="form-control @error('remarks2') is-invalid @enderror" name="remarks2" value="{{ old('remarks2') }}" placeholder="e.g. fernando.enad@deped.gov.ph" autocomplete="remarks2">
  
                                        @error('remarks2')
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
