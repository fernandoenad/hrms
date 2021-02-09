@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Modify Address')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">My Profile</a></li>
                    <li class="breadcrumb-item active">Modify Address</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('my._profile')
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <p></p>
                    </div>
                        
                    <form method="POST" action="{{ route('my.address.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="current" class="col-md-3 col-form-label text-md-right">{{ __('Current Address') }}</label>

                            <div class="col-md-8">
                                <input list="currents" id="current" type="text" class="form-control @error('current') is-invalid @enderror" name="current" value="{{ old('current') ?? $person->address->current }}" autocomplete="current">
                                <datalist id="currents">
                                    @foreach($currents as $current)
                                        <option value="{{ $current->current ?? '' }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Barangay, Town, Province') }}</em></small>

                                @error('current')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="currentzip" class="col-md-3 col-form-label text-md-right">{{ __('Current Address Zip') }}</label>

                            <div class="col-md-8">
                                <input id="currentzip" type="text" class="form-control @error('currentzip') is-invalid @enderror" name="currentzip" value="{{ old('currentzip') ?? $person->address->currentzip }}" autocomplete="currentzip">

                                @error('currentzip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permanent" class="col-md-3 col-form-label text-md-right">{{ __('Permanent Address') }}</label>

                            <div class="col-md-8">
                                <input list="permanents" id="permanent" type="text" class="form-control @error('permanent') is-invalid @enderror" name="permanent" value="{{ old('permanent') ?? $person->address->permanent }}" autocomplete="permanent">
                                <datalist id="permanents">
                                    @foreach($permanents as $permanent)
                                        <option value="{{ $permanent->permanent ?? '' }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Barangay, Town, Province') }}</em></small>

                                @error('permanent')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="permanentzip" class="col-md-3 col-form-label text-md-right">{{ __('Permanent Address Zip') }}</label>

                            <div class="col-md-8">
                                <input id="permanentzip" type="text" class="form-control @error('permanentzip') is-invalid @enderror" name="permanentzip" value="{{ old('permanentzip') ?? $person->address->permanentzip }}" autocomplete="permanentzip">

                                @error('permanentzip')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-3">   
                                <a href="{{ url()->previous() }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>                            
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Update address') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

