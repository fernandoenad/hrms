@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Modify Credentials</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.people') }}">People</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.people.show', $person->id) }}">Person</a></li>
                    <li class="breadcrumb-item active">Modify Credentials</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('ictu.people._profile')
        </div>

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h5>{{ __('Modify Credentials')}}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ictu.people.update-credentials', $person->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-md-3 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                        <div class="col-md-8">
                            <input @if($person->user->email_verified_at !== null) {{ 'readonly' }} @endif id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? $person->user->email }}" autocomplete="email">
                            <small class="text-danger">@if($person->user->email_verified_at !== null) {{ 'Emails are no longer editable once verified.' }} @endif </small>
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="username" class="col-md-3 col-form-label text-md-right">{{ __('Username') }}</label>

                        <div class="col-md-8">
                            <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') ?? $person->user->username }}" autocomplete="username">
                            <small><em>{{ __('Spaces are not allowed.') }}</em></small>

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Update Credentials') }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.people._tools')
        </div>
    </div>
</div>
@endsection
