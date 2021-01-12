@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Modify Contact')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('my') }}">My Profile</a></li>
                    <li class="breadcrumb-item active">Modify Contact</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row d-flex justify-content-center">
                        <p></p>
                    </div>
                        
                    <form method="POST" action="{{ route('contact.update', [$contact->id]) }}">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row">
                            <label for="type" class="col-md-3 col-form-label text-md-right">{{ __('Type') }}</label>

                            <div class="col-md-8">
                                <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" autocomplete="type">
                                    <option value="">Select</option>
                                    <option value="DepEd E-Mail" @if (old('type') ?? $contact->type == 'DepEd E-Mail') {{ 'selected' }} @endif>DepEd E-Mail</option>
                                    <option value="MS365 E-Mail" @if (old('type') ?? $contact->type == 'MS365 E-Mail') {{ 'selected' }} @endif>MS365 E-Mail</option>
                                    <option value="Primary Contact" @if (old('type') ?? $contact->type == 'Primary Contact') {{ 'selected' }} @endif>Primary Contact</option>
                                    <option value="Secondary Contact" @if (old('type') ?? $contact->type  == 'Secondary Contact') {{ 'selected' }} @endif>Secondary Contact</option>
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="details" class="col-md-3 col-form-label text-md-right">{{ __('Details') }}</label>

                            <div class="col-md-8">
                                <input id="details" type="text" class="form-control @error('details') is-invalid @enderror" name="details" value="{{ old('details') ?? $contact->details }} " autocomplete="details">

                                @error('details')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-11">                               
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

