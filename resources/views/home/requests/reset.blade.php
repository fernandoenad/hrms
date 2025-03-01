@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">New Password Reset Request</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('help') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('help.track-requests') }}">Request Lookup</a></li>
                    <li class="breadcrumb-item active">New Password Reset Request</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    <div class="alert alert-default">
                        Your reference number is <strong>{{ request()->get('id') }}</strong>. You may look-up for its status after 48 hours.
                    </div>
                @endif

                <div class="card">
                    <div class="card-header text-muted border-bottom-0">
                        Fill out the fields below...
                    </div>

                    
                
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-md-12">
                                <form method="POST" action="">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="employee_number" class="col-md-2 col-form-label text-md-left">{{ __('Employee No.') }}</label>
                                        <div class="col-md-10">
                                            <input id="employee_number" type="number" class="form-control @error('employee_number') is-invalid @enderror" name="employee_number" value="{{ old('employee_number') }}">

                                            @error('employee_number')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="firstname" class="col-md-2 col-form-label text-md-left">{{ __('First name') }}</label>
                                        <div class="col-md-10">
                                            <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}">

                                            @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="middlename" class="col-md-2 col-form-label text-md-left">{{ __('Middle name') }}</label>
                                        <div class="col-md-10">
                                            <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}">

                                            @error('middlename')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="lastname" class="col-md-2 col-form-label text-md-left">{{ __('Last name') }}</label>
                                        <div class="col-md-10">
                                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}">

                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="dob" class="col-md-2 col-form-label text-md-left">{{ __('Date of Birth') }}</label>
                                        <div class="col-md-10">
                                            <input id="dob" type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}">

                                            @error('dob')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="account" class="col-md-2 col-form-label text-md-left">{{ __('Account') }}</label>
                                        <div class="col-md-10">
                                            <select id="account" type="account" class="form-control @error('account') is-invalid @enderror" name="account" value="{{ old('account') }}">
                                                <option value="">Please select:</option>
                                                <option value="Google" {{ old('account') == 'Google' ? 'selected' : '' }}>Google</option>
                                                <option value="Microsoft" {{ old('account') == 'Microsoft' ? 'selected' : '' }}>Microsoft</option>
                                            </select>
                                            @error('account')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-2 col-form-label text-md-left">{{ __('DepEd Email') }}</label>
                                        <div class="col-md-10">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <a href="{{ route('login') }}" class="btn btn-default">Cancel</a>
                                            <button class="btn btn-primary float-right">Submit Request</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('home.requests._tools')
            </div>
        </div>
    </div>
</div>
@endsection