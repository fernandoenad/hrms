@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Add Non-Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.employees', $station->id) }}">Employees</a></li>
                    <li class="breadcrumb-item active">Add Non-Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <div class="card card-default">
                <div class="card-header">
                    Add Non-Employee
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ou.station.employees.store2', $station->id) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Non-Employee') }}</label>

                            <div class="col-md-8">
                                <input id="person_id" type="hidden" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') ?? request()->id }}" autocomplete="person_id">
                                <div class="input-group input-group-md">
                                    <input readonly id="person_name" type="text" class="form-control @error('person_name') is-invalid @enderror" name="person_name" value="{{ old('person_name') ?? request()->name }}" autocomplete="person_name">
                                    <div class="input-group-append">
                                        <a href="{{ route('ou.station.employees.lookup2', $station->id) }}?redirect={{ Route::currentRouteName() }}" class="btn btn-primary float-right">
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

                        <div class="form-group row">
                            <label for="itemno" class="col-md-3 col-form-label text-md-right">{{ __('Item No.') }}</label>

                            <div class="col-md-8">
                                <input id="itemno" type="text" class="form-control @error('itemno') is-invalid @enderror" name="itemno" value="{{ old('itemno') }}" autocomplete="itemno">

                                @error('itemno')
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
                                        <option value="{{ $itemlevel->details }}" @if(old('level') == $itemlevel->details) {{ 'selected' }} @endif>{{ $itemlevel->details }}</option>
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
                            <label for="creationdate" class="col-md-3 col-form-label text-md-right">{{ __('Creation Date') }}</label>

                            <div class="col-md-8">
                                <input id="creationdate" type="date" class="form-control @error('creationdate') is-invalid @enderror" name="creationdate" value="{{ old('creationdate') }}" autocomplete="creationdate">

                                @error('creationdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-8">
                                <input list="positions" id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') }}" autocomplete="position">
                                <datalist id="positions">
                                    @foreach($positions as $position)
                                        <option value="{{ $position->position }}">
                                    @endforeach
                                </datalist>

                                @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="salarygrade" class="col-md-3 col-form-label text-md-right">{{ __('Salary Grade') }}</label>

                            <div class="col-md-8">
                                <select id="salarygrade" type="text" class="form-control @error('salarygrade') is-invalid @enderror" name="salarygrade" value="{{ old('salarygrade') }}" autocomplete="salarygrade">
                                    <option value="">Select</option>
                                    @for($i=1; $i<33; $i++)
                                        <option value="{{ $i }}" @if (old('salarygrade') == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                                    @endfor
                                </select>

                                @error('salarygrade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="employeetype" class="col-md-3 col-form-label text-md-right">{{ __('Employee Type') }}</label>

                            <div class="col-md-8">
                                <select id="employeetype" type="text" class="form-control @error('employeetype') is-invalid @enderror" name="employeetype" value="{{ old('employeetype') }}" autocomplete="employeetype">
                                    <option value="">Select</option>
                                    @foreach($employeetypes as $employeetype)
                                        <option value="{{ $employeetype->details }}" @if (old('employeetype') == $employeetype->details) {{ 'selected' }} @endif>{{ $employeetype->details }}</option>
                                    @endforeach
                                </select>
                                @error('employeetype')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('Plantilla Owner') }}</label>

                            <div class="col-md-8">
                                <select id="station_id" type="text" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') }}" autocomplete="station_id">
                                    <option value="">Select</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}" @if (old('station_id') == $station->id ) {{ 'selected' }} @endif>{{ $station->code }} - {{ $station->name }}, {{ $station->office->name }}</option>
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
                            <label for="employmentstatus " class="col-md-3 col-form-label text-md-right">{{ __('Empl Status') }}</label>

                            <div class="col-md-8">
                                <select id="employmentstatus" type="date" class="form-control @error('employmentstatus') is-invalid @enderror" name="employmentstatus" value="{{ old('employmentstatus ') }}" autocomplete="employmentstatus">
                                    <option value="">Select</option>
                                    @foreach($employmentstatuses as $employmentstatus)
                                        <option value="{{ $employmentstatus->details }}" @if(old('employmentstatus') ==  $employmentstatus->details) {{ 'selected' }} @endif>{{ $employmentstatus->details }}</option>
                                    @endforeach
                                </select>

                                @error('employmentstatus')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="appointmentdate " class="col-md-3 col-form-label text-md-right">{{ __('Appt Date') }}</label>

                            <div class="col-md-8">
                                <input id="appointmentdate" type="date" class="form-control @error('appointmentdate') is-invalid @enderror" name="appointmentdate" value="{{ old('appointmentdate') }}" autocomplete="appointmentdate">

                                @error('appointmentdate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="firstdaydate " class="col-md-3 col-form-label text-md-right">{{ __('First Day') }}</label>

                            <div class="col-md-8">
                                <input id="firstdaydate" type="date" class="form-control @error('firstdaydate') is-invalid @enderror" name="firstdaydate" value="{{ old('firstdaydate ') }}" autocomplete="firstdaydate">

                                @error('firstdaydate')
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
                                    {{ __('Request to Add Employee') }}
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
