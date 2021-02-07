@extends('layouts.my')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Modify Contact')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a href="{{ route('my') }}">My Profile</a></li>
                    <li class="breadcrumb-item active">Modify Contact</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <div class="card card-primary card-outline">
                @include('my._profile')
            </div>
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <p></p>
                    </div>
                        
                    <form method="POST" action="{{ route('my.contact.update') }}">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="primaryno" class="col-md-3 col-form-label text-md-right">{{ __('Primary Contact') }}</label>

                            <div class="col-md-8">
                                <input id="primaryno" type="text" class="form-control @error('primaryno') is-invalid @enderror" name="primaryno" value="{{ old('primaryno') ?? $person->contact->primaryno }}" autocomplete="primaryno">

                                @error('primaryno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="secondaryno" class="col-md-3 col-form-label text-md-right">{{ __('Secondary Contact') }}</label>

                            <div class="col-md-8">
                                <input id="secondaryno" type="text" class="form-control @error('secondaryno') is-invalid @enderror" name="secondaryno" value="{{ old('secondaryno') ?? $person->contact->secondaryno }}" autocomplete="secondaryno">

                                @error('secondaryno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencyperson" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-8">
                                <input id="emergencyperson" type="text" class="form-control @error('emergencyperson') is-invalid @enderror" name="emergencyperson" value="{{ old('emergencyperson') ?? $person->contact->emergencyperson }}" autocomplete="emergencyperson">

                                @error('emergencyperson')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencyrelation" class="col-md-3 col-form-label text-md-right">{{ __('Relationship') }}</label>

                            <div class="col-md-8">
                                <input id="emergencyrelation" type="text" class="form-control @error('emergencyrelation') is-invalid @enderror" name="emergencyrelation" value="{{ old('emergencyrelation') ?? $person->contact->emergencyrelation }}" autocomplete="emergencyrelation">

                                @error('emergencyrelation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencyaddress" class="col-md-3 col-form-label text-md-right">{{ __('Address') }}</label>

                            <div class="col-md-8">
                                <input list="emergencyaddresses" id="emergencyaddress" type="text" class="form-control @error('emergencyaddress') is-invalid @enderror" name="emergencyaddress" value="{{ old('emergencyaddress') ?? $person->contact->emergencyaddress }}" autocomplete="emergencyaddress">
                                <datalist id="emergencyaddresses">
                                    @foreach($emergencyaddresses as $emergencyaddress)
                                        <option value="{{ $emergencyaddress->emergencyaddress ?? '' }}">
                                    @endforeach
                                </datalist>
                                <small><em>{{ __('Barangay, Town, Province') }}</em></small>

                                @error('emergencyaddress')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="emergencycontact" class="col-md-3 col-form-label text-md-right">{{ __('Contact') }}</label>

                            <div class="col-md-8">
                                <input id="emergencycontact" type="text" class="form-control @error('emergencycontact') is-invalid @enderror" name="emergencycontact" value="{{ old('emergencycontact') ?? $person->contact->emergencycontact }}" autocomplete="emergencycontact">

                                @error('emergencycontact')
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
                                    {{ __('Update Contact') }}
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

