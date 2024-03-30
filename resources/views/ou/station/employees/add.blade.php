@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.employees', $station->id) }}">Employees</a></li>
                    <li class="breadcrumb-item active">Add Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card card-default">
                <div class="card-header">
                    Add Employee
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ou.station.employees.store', $station->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Employee') }}</label>

                            <div class="col-md-8">
                                <input id="person_id" type="hidden" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') ?? request()->id }}" autocomplete="person_id">
                                <div class="input-group input-group-md">
                                    <input readonly id="person_name" type="text" class="form-control @error('person_name') is-invalid @enderror" name="person_name" value="{{ old('person_name') ?? request()->name }}" autocomplete="person_name">
                                    <div class="input-group-append">
                                        <a href="{{ route('ou.station.employees.lookup', $station->id) }}?redirect={{ Route::currentRouteName() }}" class="btn btn-primary float-right">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                </div>

                                @error('person_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="deployment_station_id" class="col-md-3 col-form-label text-md-right">{{ __('Deployment') }}</label>

                            <div class="col-md-8">
                                <!--
                                <select id="deployment_station_id" type="text" class="form-control @error('deployment_station_id') is-invalid @enderror" name="deployment_station_id" value="{{ old('deployment_station_id') }}" autocomplete="deployment_station_id">
                                    <option value="">Select</option>
                                    @foreach($stations as $station_i)
                                        <option value="{{ $station_i->id }}" @if (old('deployment_station_id') == $station_i->id) {{ 'selected' }} @endif>{{ $station_i->code }} - {{ $station_i->name }}, {{ $station_i->office->name }}</option>
                                    @endforeach
                                </select>
                                -->
                                <input id="deployment_station_id" type="hidden" class="form-control @error('deployment_station_id') is-invalid @enderror" name="deployment_station_id" value="{{ old('deployment_station_id') ?? $station->id }}" autocomplete="deployment_station_id">
                                <input readonly id="deployment_station_name" type="text" class="form-control @error('deployment_station_name') is-invalid @enderror" name="deployment_station_name" value="{{ old('deployment_station_name') ?? $station->name }}" autocomplete="deployment_station_name">


                                @error('deployment_station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                                         
                        <hr>                       
                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Save Employee') }}
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-default">
                                    {{ __('Cancel') }}
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.station.employees._tools')
        </div>
    </div>
</div>
@endsection
