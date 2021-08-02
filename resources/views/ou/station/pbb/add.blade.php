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
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.pbb', [$station->id, $year]) }}">PBB Report {{ $year }}</a></li>
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
                    <form method="POST" action="{{ route('ou.station.pbb.store', [$station->id, $year]) }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="person_id" class="col-md-3 col-form-label text-md-right">{{ __('Employee') }}</label>

                            <div class="col-md-8">
                                <input id="person_id" type="hidden" class="form-control @error('person_id') is-invalid @enderror" name="person_id" value="{{ old('person_id') ?? request()->id }}" autocomplete="person_id">
                                <div class="input-group input-group-md">
                                    <input readonly id="person_name" type="text" class="form-control @error('person_name') is-invalid @enderror" name="person_name" value="{{ old('person_name') ?? request()->name }}" autocomplete="person_name">
                                    <div class="input-group-append">
                                        <a href="{{ route('ou.station.pbb.lookup', [$station->id, $year]) }}?redirect={{ Route::currentRouteName() }}" class="btn btn-primary float-right">
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
                            <label for="station_id" class="col-md-3 col-form-label text-md-right">{{ __('Reporting Station') }}</label>

                            <div class="col-md-8">
                                <input id="station_id" type="hidden" class="form-control @error('station_id') is-invalid @enderror" name="station_id" value="{{ old('station_id') ?? $station->id }}" autocomplete="station_id">
                                <input readonly id="deployment_station_name" type="text" class="form-control @error('deployment_station_name') is-invalid @enderror" name="deployment_station_name" value="{{ old('deployment_station_name') ?? $station->name }}" autocomplete="deployment_station_name">


                                @error('station_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        @if(isset(request()->id))
                        <?php $person = App\Models\Person::find(request()->id); ?>
                        <?php $employee = $person->employee; ?>
                        <?php $employee_id = $person->employee->id; ?>
                        <?php $empno = $person->employee->empno; ?>
                        <?php $hiredate = strtotime($person->employee->hiredate); ?>
                        <?php $startdate = strtotime($year . "-" . "10-01"); ?>
                        <?php $startdate= ($hiredate < $startdate ? $startdate : $hiredate); ?>
                        <?php $enddate= strtotime($year+1 . "-" . "07-31"); ?>
                        <?php $length_of_service = date('m', $enddate - $startdate); ?>
                        <?php $salary_grade = $person->employee->item->salarygrade; ?>
                        <?php $step = $person->employee->step; ?>

                        <div class="form-group row">
                            <label for="empno" class="col-md-3 col-form-label text-md-right">{{ __('Employee No.') }}</label>

                            <div class="col-md-8">
                                <input id="employee_id" type="hidden" class="form-control @error('employee_id') is-invalid @enderror" name="employee_id" value="{{ old('employee_id') ?? $employee_id }}" autocomplete="employee_id">
                                <input id="empno" type="text" class="form-control @error('empno') is-invalid @enderror" name="empno" value="{{ old('empno') ?? $empno }}" autocomplete="empno">

                                @error('empno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                                @error('employee_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="length_of_service" class="col-md-3 col-form-label text-md-right">{{ __('Length of Service') }}</label>

                            <div class="col-md-8">
                                <input id="length_of_service" type="text" step="1" class="form-control @error('length_of_service') is-invalid @enderror" name="length_of_service" value="{{ old('length_of_service') ?? $length_of_service }}" placeholder="in months" autocomplete="length_of_service">
                                
                                @error('length_of_service')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="salary_grade" class="col-md-3 col-form-label text-md-right">{{ __('Salary Grade') }}</label>

                            <div class="col-md-8">
                                <input id="salary_grade" type="number" step="1" class="form-control @error('salary_grade') is-invalid @enderror" name="salary_grade" value="{{ old('salary_grade') ?? $salary_grade }}" autocomplete="salary_grade">


                                @error('salary_grade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="step" class="col-md-3 col-form-label text-md-right">{{ __('Salary Step') }}</label>

                            <div class="col-md-8">
                                <input id="step" type="number" step="1" class="form-control @error('step') is-invalid @enderror" name="step" value="{{ old('step') ?? $step }}" autocomplete="step">


                                @error('step')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ipcr_score" class="col-md-3 col-form-label text-md-right">{{ __('IPCR Score') }}</label>

                            <div class="col-md-8">
                                <input id="ipcr_score" type="number" step=".001" class="form-control @error('ipcr_score') is-invalid @enderror" name="ipcr_score" value="{{ old('ipcr_score') }}" autocomplete="ipcr_score" placeholder="0.000">


                                @error('ipcr_score')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qualified" class="col-md-3 col-form-label text-md-right">{{ __('Qualified?') }}</label>

                            <div class="col-md-8">
                                <select id="qualified" type="text" class="form-control @error('qualified') is-invalid @enderror" name="qualified" value="{{ old('qualified') }}" autocomplete="qualified">
                                    <option value="" @if(old('qualified') == "") {{ 'selected' }} @endif>select</option>   
                                    <option value="2" @if(old('qualified') == 2) {{ 'selected' }} @endif>No</option>
                                    <option value="1" @if(old('qualified') == 1) {{ 'selected' }} @endif>Yes</option>
                                </select>

                                @error('qualified')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        @endif
                                         
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
            @include('ou.station.pbb._tools')
        </div>
    </div>
</div>
@endsection
