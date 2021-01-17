@extends('layouts.pu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Stations</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Stations</li>
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

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @if(Route::currentRouteName() == 'pu.stations.create')
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5>New Station</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pu.stations.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="type" class="col-md-3 col-form-label text-md-right">{{ __('Type') }}</label>

                                <div class="col-md-8">
                                    <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" autocomplete="type">
                                        <option value="">Select</option>
                                        @foreach($stationtypes as $stationtype)
                                            <option value="{{ $stationtype->details }}" @if(old('type') == $stationtype->details) {{ 'selected'}} @endif>{{ $stationtype->details }}</option>
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
                                <label for="code" class="col-md-3 col-form-label text-md-right">{{ __('Code') }}</label>

                                <div class="col-md-8">
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" autocomplete="code">

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
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="services" class="col-md-3 col-form-label text-md-right">{{ __('Services') }}</label>

                                <div class="col-md-8">
                                    <input list="servicesList" id="services" type="text" class="form-control @error('services') is-invalid @enderror" name="services" value="{{ old('services') }}" autocomplete="services">
                                    <datalist id="servicesList">
                                        @foreach($services as $service)
                                            <option value="{{ $service->services }}">
                                        @endforeach
                                    </datalist>

                                    @error('services')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-3 col-form-label text-md-right">{{ __('Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" autocomplete="category">
                                        <option value="">Select</option>
                                        @foreach($stationcategories as $stationcategory)
                                            <option value="{{ $stationcategory->details }}" @if(old('category') == $stationcategory->details) {{ 'selected'}} @endif>{{ $stationcategory->details }}</option>
                                        @endforeach
                                    </select>

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="office_id" class="col-md-3 col-form-label text-md-right">{{ __('Office') }}</label>

                                <div class="col-md-8">
                                    <select id="office_id" type="text" class="form-control @error('office_id') is-invalid @enderror" name="office_id" value="{{ old('office_id') }}" autocomplete="office_id">
                                        <option value="">Select</option>
                                        @foreach($offices as $office)
                                            <option value="{{ $office->id }}" @if(old('office_id') == $office->id) {{ 'selected'}} @endif>{{ $office->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('office_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="address" class="col-md-3 col-form-label text-md-right">{{ __('Brgy Addr') }}</label>

                                <div class="col-md-8">
                                    <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" autocomplete="address">

                                    @error('address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('School Head') }}</label>

                                <div class="col-md-8">
                                    <select id="person_id" type="text" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') }}" autocomplete="person_id">
                                        <option value="">Select</option>
                                        @foreach($people as $person)
                                            <option value="{{ $person->id }}" @if(old('person_id') == $person->id) {{ 'selected'}} @endif>{{ $person->getFullnameBox() }}</option>
                                        @endforeach
                                    </select>

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
                                            {{ __('Save Station') }}
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
            @endif  

            @if(Route::currentRouteName() == 'pu.stations.edit')
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5>Modify Station</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pu.stations.update', $station->id) }}">
                            @csrf
                            @method('PATCH')
                            
                            <div class="form-group row">
                                <label for="type" class="col-md-3 col-form-label text-md-right">{{ __('Type') }}</label>

                                <div class="col-md-8">
                                    <select id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" autocomplete="type">
                                        <option value="">Select</option>
                                        @foreach($stationtypes as $stationtype)
                                            <option value="{{ $stationtype->details }}" @if(old('type') == $stationtype->details || $station->type == $stationtype->details ) {{ 'selected'}} @endif>{{ $stationtype->details }}</option>
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
                                <label for="code" class="col-md-3 col-form-label text-md-right">{{ __('Code') }}</label>

                                <div class="col-md-8">
                                    <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') ?? $station->code }}" autocomplete="code">

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
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $station->name}}" autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="services" class="col-md-3 col-form-label text-md-right">{{ __('Services') }}</label>

                                <div class="col-md-8">
                                    <input list="servicesList" id="services" type="text" class="form-control @error('services') is-invalid @enderror" name="services" value="{{ old('services') ?? $station->services }}" autocomplete="services">
                                    <datalist id="servicesList">
                                        @foreach($services as $service)
                                            <option value="{{ $service->services }}">
                                        @endforeach
                                    </datalist>

                                    @error('services')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="category" class="col-md-3 col-form-label text-md-right">{{ __('Category') }}</label>

                                <div class="col-md-8">
                                    <select id="category" type="text" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" autocomplete="category">
                                        <option value="">Select</option>
                                        @foreach($stationcategories as $stationcategory)
                                            <option value="{{ $stationcategory->details }}" @if(old('category') == $stationcategory->details || $station->category == $stationcategory->details) {{ 'selected'}} @endif>{{ $stationcategory->details }}</option>
                                        @endforeach
                                    </select>

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="office_id" class="col-md-3 col-form-label text-md-right">{{ __('Office') }}</label>

                                <div class="col-md-8">
                                    <select id="office_id" type="text" class="form-control @error('office_id') is-invalid @enderror" name="office_id" value="{{ old('office_id') }}" autocomplete="office_id">
                                        <option value="">Select</option>
                                        @foreach($offices as $office)
                                            <option value="{{ $office->id }}" @if(old('office_id') == $office->id || $station->office_id == $office->id) {{ 'selected'}} @endif>{{ $office->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('office_id')
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
                                <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('School Head') }}</label>

                                <div class="col-md-8">
                                    <select id="person_id" type="text" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') }}" autocomplete="person_id">
                                        <option value="">Select</option>
                                        @foreach($people as $person)
                                            <option value="{{ $person->id }}" @if(old('person_id') == $person->id || $station->person_id == $person->id) {{ 'selected'}} @endif>{{ $person->getFullnameBox() }}</option>
                                        @endforeach
                                    </select>

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
            @endif 

            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>District</th>
                                    <th width="13%" class="text-right">Tchr</th>
                                    <th width="13%" class="text-right">Non-Tchr</th>
                                    <th width="13%" class="text-right">Total</th>
                                    <th width="13%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($stations) > 0)
                                    @foreach($stations as $station)
                                        <tr>
                                            <td><strong>{{ $station->name }} ({{ $station->code }})</strong></td>
                                            <td>{{ $station->office->name }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\StationController::getEmployees($station->id, 'Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\StationController::getEmployees($station->id, 'Non-Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\StationController::getEmployees($station->id, '%')->count() }}</td>
                                            <td class="text-right">
                                                <form method="POST" action="{{ route('pu.stations.delete', $station->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('pu.stations.edit', $station->id ) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" 
                                                        @if(\App\Http\Controllers\PU\StationController::getEmployees($station->id, '%')->count() > 0) 
                                                            {{ 'disabled' }}
                                                        @endif>
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
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
                        {!! $stations->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('pu.stations._tools')
        </div>
    </div>
</div>
@endsection
