@extends('layouts.my')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Submit Application</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rms.application') }}">My Application</a></li>
                    <li class="breadcrumb-item active">Submit Application</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-md-9">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        New Application
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning">
                            Editing application once submitted is not allowed so please make sure everything is accurate.
                        </div>

                        <form method="POST" action="{{ route('rms.application.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="schoolyear" class="col-md-3 col-form-label text-md-right">{{ __('School Year') }}</label>

                            <div class="col-md-8">
                                <input readonly id="schoolyear" type="text" class="form-control @error('schoolyear') is-invalid @enderror" name="schoolyear" value="{{ old('schoolyear') ?? $term }}" autocomplete="schoolyear">

                                @error('schoolyear')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-8">
                                <select id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" autocomplete="position">
                                    <option value="">Select</option>
                                    @foreach($positions as $position)
                                     <option value="{{ $position->details }}" @if(old('position') == $position->details){{ 'selected'}} @endif>{{ $position->details }}</option>
                                    @endforeach
                                </select>

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="major" class="col-md-3 col-form-label text-md-right">{{ __('Specialization') }}</label>

                            <div class="col-md-8">
                                <select id="major" type="text" class="form-control @error('major') is-invalid @enderror" name="major" value="{{ old('major') }}" autocomplete="major">
                                    <option value="">Select</option>
                                    @foreach($specializations as $specialization)
                                    <option value="{{ $specialization->details }}" @if(old('major') == $specialization->details){{ 'selected'}} @endif>{{ $specialization->details }}</option>
                                    @endforeach
                                </select>

                                @error('major')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="level" class="col-md-3 col-form-label text-md-right">{{ __('Level') }}</label>

                            <div class="col-md-8">
                                <select id="level" type="text" class="form-control @error('level') is-invalid @enderror" name="level" value="{{ old('level') }}" autocomplete="level">
                                    <option value="">Select</option>
                                    @foreach($itemlevels as $itemlevel)
                                    <option value="{{ $itemlevel->details }}" @if(old('level') == $itemlevel->details){{ 'selected'}} @endif>{{ $itemlevel->details }}</option>
                                    @endforeach
                                </select>

                                @error('level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="type" class="col-md-3 col-form-label text-md-right">{{ __('Application Type') }}</label>
                            
                            <div class="col-md-8">
                                <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" autocomplete="type">
                                    <option value="">Select</option>
                                    @foreach($applicationtypes as $applicationtype)
                                    <option value="{{ $applicationtype->details }}" @if(old('type') == $applicationtype->details){{ 'selected'}} @endif>{{ $applicationtype->details }}</option>
                                    @endforeach
                                </select>

                                @error('type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('Station') }}</label>

                            <div class="col-md-8">
                                <select id="station_id" type="text" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') }}" autocomplete="station_id">
                                 <option value="">Select</option>
                                    @foreach($stations as $station)
                                    <option value="{{ $station->id }}" @if(old('station_id') == $station->id){{ 'selected'}} @endif>{{ $station->code }}- {{ $station->name }}, {{ $station->office->name }} ({{ $station->office->town->name }})</option>
                                    @endforeach
                                </select>
                                @error('station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Save application') }}
                                </button>
                                <a href="{{ route('rms.application') }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                        </form>
                    </div>                    
                </div>
            </div>

            <div class="col-md-3">
                @include('rms.applications._tools')
            </div>
        </div>
    </div>
</div>
@endsection