@extends('layouts.pu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Towns</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Towns</li>
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

            @if(Route::currentRouteName() == 'pu.towns.create')
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5>New Office / District</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pu.towns.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Town Name') }}</label>

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
                                <label for="cdlevel" class="col-md-3 col-form-label text-md-right">{{ __('Congressional District') }}</label>

                                <div class="col-md-8">
                                    <select id="cdlevel" type="text" class="form-control @error('cdlevel') is-invalid @enderror" name="cdlevel" value="{{ old('cdlevel') }}" autocomplete="cdlevel">
                                        <option value="">Select</option>
                                        @foreach($cdlevels as $cdlevel)
                                            <option value="{{ $cdlevel->details }}" @if(old('cdlevel') == $cdlevel->details) {{ 'selected'}} @endif>CD {{ $cdlevel->details }}</option>
                                        @endforeach
                                    </select>

                                    @error('cdlevel')
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
                                            {{ __('Save Town') }}
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

            @if(Route::currentRouteName() == 'pu.towns.edit')
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5>New Office / District</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pu.towns.update', $town->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Town Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $town->name }}" autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="cdlevel" class="col-md-3 col-form-label text-md-right">{{ __('Congressional District') }}</label>

                                <div class="col-md-8">
                                    <select id="cdlevel" type="text" class="form-control @error('cdlevel') is-invalid @enderror" name="cdlevel" value="{{ old('cdlevel') }}" autocomplete="cdlevel">
                                        <option value="">Select</option>
                                        @foreach($cdlevels as $cdlevel)
                                            <option value="{{ $cdlevel->details }}" @if(old('cdlevel') == $cdlevel->details || $cdlevel->details == $town->cdlevel ) {{ 'selected'}} @endif>CD {{ $cdlevel->details }}</option>
                                        @endforeach
                                    </select>

                                    @error('cdlevel')
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
                                            {{ __('Update Town') }}
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
                                    <th>Town</th>
                                    <th width="14%" class="text-right">Districts</th>
                                    <th width="14%" class="text-right">Schools</th>
                                    <th width="14%" class="text-right">Tchr</th>
                                    <th width="14%" class="text-right">Non-Tchr</th>
                                    <th width="14%" class="text-right">Total</th>
                                    <th width="13%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($towns) > 0)
                                    @foreach($towns as $town)
                                        <tr>
                                            <td>
                                                <strong>{{ $town->name }}</strong>
                                                <br>
                                                CD {{ $town->cdlevel }}
                                            </td>
                                            <td class="text-right">{{ $town->office->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\TownController::getEmployees($town->id, 'Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\TownController::getEmployees($town->id, 'Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\TownController::getEmployees($town->id, 'Non-Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\TownController::getEmployees($town->id, '%')->count() }}</td>
                                            <td class="text-right">
                                                <form method="POST" action="{{ route('pu.towns.delete', $town->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('pu.towns.edit', $town->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" 
                                                        @if(\App\Http\Controllers\PU\TownController::getEmployees($town->id, '%')->count()  > 0 
                                                            || $town->office->count() > 0) 
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
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('pu.towns._tools')
        </div>
    </div>
</div>
@endsection
