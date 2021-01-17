@extends('layouts.pu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Offices</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('pu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Offices</li>
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

            @if(Route::currentRouteName() == 'pu.offices.create')
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5>New Office / District</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pu.offices.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Office / District Name') }}</label>

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
                                <label for="town_id" class="col-md-3 col-form-label text-md-right">{{ __('Office Town') }}</label>

                                <div class="col-md-8">
                                    <select id="town_id" type="text" class="form-control @error('town_id') is-invalid @enderror" name="town_id" value="{{ old('town_id') }}" autocomplete="town_id">
                                        <option value="">Select</option>
                                        @foreach($towns as $town)
                                            <option value="{{ $town->id }}" @if(old('town_id') == $town->id) {{ 'selected'}} @endif>{{ $town->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('town_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Office / District Head') }}</label>

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
                                            {{ __('Save Office') }}
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

            @if(Route::currentRouteName() == 'pu.offices.edit')
            <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h5>Modify Office / District</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('pu.offices.update', $office->id) }}">
                            @csrf
                            @method('PATCH')

                            <div class="form-group row">
                                <label for="name" class="col-md-3 col-form-label text-md-right">{{ __('Office / District Name') }}</label>

                                <div class="col-md-8">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $office->name }}" autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="town_id" class="col-md-3 col-form-label text-md-right">{{ __('Office Town') }}</label>

                                <div class="col-md-8">
                                    <select id="town_id" type="text" class="form-control @error('town_id') is-invalid @enderror" name="town_id" value="{{ old('town_id') }}" autocomplete="town_id">
                                        <option value="">Select</option>
                                        @foreach($towns as $town)
                                            <option value="{{ $town->id }}" @if(old('town_id') == $town->id || $office->town_id == $town->id) {{ 'selected'}} @endif>{{ $town->name }}</option>
                                        @endforeach
                                    </select>

                                    @error('town_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Office / District Head') }}</label>

                                <div class="col-md-8">
                                    <select id="person_id" type="text" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') }}" autocomplete="person_id">
                                        <option value="">Select</option>
                                        @foreach($people as $person)
                                            <option value="{{ $person->id }}" @if(old('person_id') == $person->id || $office->person_id ==  $person->id) {{ 'selected'}} @endif>{{ $person->getFullnameBox() }}</option>
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
                                            {{ __('Save Office') }}
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
                                    <th>District/Office</th>
                                    <th width="15%" class="text-right">Schools</th>
                                    <th width="15%" class="text-right">Tchr</th>
                                    <th width="15%" class="text-right">Non-Tchr</th>
                                    <th width="15%" class="text-right">Total</th>
                                    <th width="13%" class="text-right"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($offices) > 0)
                                    @foreach($offices as $office)
                                        <tr>
                                            <td>
                                                <strong>{{ $office->name }}</strong>
                                                <br>
                                                {{ $office->town->name }}
                                            </td>
                                            <td class="text-right">{{ $office->station->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\OfficeController::getEmployees($office->id, 'Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\OfficeController::getEmployees($office->id, 'Non-Teaching')->count() }}</td>
                                            <td class="text-right">{{ \App\Http\Controllers\PU\OfficeController::getEmployees($office->id, '%')->count() }}</td>
                                            <td class="text-right">
                                                <form method="POST" action="{{ route('pu.offices.delete', $office->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="{{ route('pu.offices.edit', $office->id) }}" class="btn btn-primary btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-danger btn-sm" 
                                                        @if(\App\Http\Controllers\PU\OfficeController::getEmployees($office->id, '%')->count() > 0) 
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
            @include('pu.offices._tools')
        </div>
    </div>
</div>
@endsection
