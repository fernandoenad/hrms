@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Step Increment</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees') }}">Employees</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees.show', $person->employee->id) }}">Employee</a></li>
                    <li class="breadcrumb-item active">Step Increment</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        @include('ps.people._profile')
        </div>

        <div class="col-md-6">
            <div class="card card-default">
                <div class="card-header">
                    <h5>Process Increment Step</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ps.employees.si-done', $person->employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group row">
                            <label for="itemno" class="col-md-3 col-form-label text-md-right">{{ __('Item No.') }}</label>

                            <div class="col-md-8">
                                <input id="itemno" readonly type="text" class="form-control @error('itemno') is-invalid @enderror" name="itemno" value="{{ old('itemno') ?? $person->employee->item->itemno }}" autocomplete="itemno">

                                @error('itemno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="position" class="col-md-3 col-form-label text-md-right">{{ __('Position') }}</label>

                            <div class="col-md-8">
                                <input id="position" readonly type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position') ?? $person->employee->item->position }}" autocomplete="position">

                                @error('itempositionno')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="salarygrade" class="col-md-3 col-form-label text-md-right">{{ __('Salary Grade') }}</label>

                            <div class="col-md-8">
                                <input id="salarygrade" readonly type="text" class="form-control @error('salarygrade') is-invalid @enderror" name="salarygrade" value="{{ old('salarygrade') ?? $person->employee->item->salarygrade }}" autocomplete="salarygrade">

                                @error('salarygrade')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="step_old" class="col-md-3 col-form-label text-md-right">{{ __('Current Step') }}</label>

                            <div class="col-md-8">
                                <input id="step_old" readonly type="text" class="form-control @error('step_old') is-invalid @enderror" name="step_old" value="{{ old('step_old') ?? $person->employee->step }}" autocomplete="step_old">

                                @error('step_old')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="step" class="col-md-3 col-form-label text-md-right">{{ __('New Step') }}</label>

                            <div class="col-md-8">
                                <select id="step" type="text" class="form-control @error('step') is-invalid @enderror" name="step" value="{{ old('step') ?? $person->employee->step }}" autocomplete="step">
                                    <option value="">Select</option>
                                    @for($i=$person->employee->step + 1; $i<=8; $i++)
                                        <option value="{{ $i }}" @if($i <= $person->employee->step) {{ 'disabled' }} @endif @if(old('step') == $i || $person->employee->step == $i) {{ 'selected' }} @endif>{{ $i }}</option>
                                    @endfor
                                </select>

                                @error('step')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastnosidate" class="col-md-3 col-form-label text-md-right">{{ __('Effectivity') }}</label>

                            <div class="col-md-8">
                                <input id="lastnosidate" type="date" class="form-control @error('lastnosidate') is-invalid @enderror" name="lastnosidate" value="{{ old('lastnosidate') }}" autocomplete="lastnosidate">

                                @error('lastnosidate')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Process') }}
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
            @include('ps.people._tools')
        </div>
    </div>
</div>
@endsection
