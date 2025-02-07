@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Stations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item active">Stations</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(Route::currentRouteName() == 'ou.office.stations.edit')
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="card card-outline card-warning">
                            <div class="card-header">
                                <h5>Modify Station</h5>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('ou.office.stations.update', [$office->id, $station->id]) }}">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <div class="form-group row">
                                        <label for="code" class="col-md-3 col-form-label text-md-right">{{ __('Code') }}</label>

                                        <div class="col-md-8">
                                            <input id="code" readonly type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') ?? $station->code }}" autocomplete="code">

                                            @error('code')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Name') }}</label>

                                        <div class="col-md-8">
                                            <input id="name" readonly type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $station->name}}" autocomplete="name">

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="address" class="col-md-3 col-form-label text-md-right">{{ __('Brgy Addr') }}</label>

                                        <div class="col-md-8">
                                            <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') ?? $station->address }}" autocomplete="address">

                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Station Head') }}</label>

                                        <div class="col-md-8">
                                            <input id="person_id" type="hidden" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') ?? request()->id ?? $station->person_id }}" autocomplete="person_id">
                                            <div class="input-group input-group-md">
                                                <input readonly id="person_name" type="text" class="form-control @error('person_name') is-invalid @enderror" name="person_name" value="{{ old('person_name') ?? request()->name ?? (isset($station->person) ? $station->person->getFullnameBox() : '') }}" autocomplete="person_name">
                                                <div class="input-group-append">
                                                <a href="{{ route('ou.office.stations.lookup', [$office->id, $station->id]) }}?redirect={{ Route::currentRouteName() }}" class="btn btn-primary float-right">
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

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-8">
                                                <button type="submit" class="btn btn-primary float-right">
                                                    {{ __('Update Station') }}
                                                </button>
                                                <a href="{{ url()->previous()}}" class="btn btn-default">
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
            @endif 

            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>School Head/Email</th>
                                    <th width="8%" class="text-left">District</th>
                                    <th width="8%" class="text-right">Tchr</th>
                                    <th width="8%" class="text-right">Non-Tchr</th>
                                    <th width="8%" class="text-right">Total</th>
                                    <th width="13%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($stations) > 0)
                                    @foreach($stations as $station)
                                        <tr>
                                            <td>
                                                <strong><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->name }} ({{ $station->code }})</a></strong>                                                                                        
                                            </td>
                                            <td>
                                                <strong>@if($station->person != null) {{ $station->person->getFullnameSorted() }} @endif </strong><br>
                                                @if($station->person != null) {{ $station->person->user->email }} @endif
                                            </td>
                                            <td>{{ $station->services }} </td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\StationController::getEmployees($station->id, 'Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\StationController::getEmployees($station->id, 'Non-Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\StationController::getEmployees($station->id, '%')->count() }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('ou.office.stations.edit', [$office->id, $station->id] ) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            {{ __('No record was found.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
