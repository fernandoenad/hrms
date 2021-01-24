@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Promotion</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees') }}">Employees</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees.show', $person->employee->id) }}">Employee</a></li>
                    <li class="breadcrumb-item active">Promotion</li>
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
                    <h5>Process Promotion</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ps.employees.pr-done', $person->employee->id) }}" enctype="multipart/form-data">
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
                            <label for="item_id" class="col-md-3 col-form-label text-md-right">{{ __('New Item No.') }}</label>

                            <div class="col-md-8">
                                <input id="item_id" type="hidden" class="form-control @error('item_id') is-invalid @enderror" name="item_id" value="{{ old('item_id') ?? request()->id }}" autocomplete="item_id">
                                <div class="input-group input-group-md">
                                    <input readonly id="itemno" type="text" class="form-control @error('itemno') is-invalid @enderror" name="itemno" value="{{ old('itemno') ?? request()->name }}" autocomplete="itemno">
                                    <div class="input-group-append">
                                        <a href="{{ route('ps.employees.lookup-item', $person->employee->id ) }}?redirect={{ Route::currentRouteName() }}" class="btn btn-primary float-right">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </div>
                                </div>

                                @error('item_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="appointmentdate" class="col-md-3 col-form-label text-md-right">{{ __('Appt Date') }}</label>

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
                            <label for="firstdaydate" class="col-md-3 col-form-label text-md-right">{{ __('First Day') }}</label>

                            <div class="col-md-8">
                                <input id="firstdaydate" type="date" class="form-control @error('firstdaydate') is-invalid @enderror" name="firstdaydate" value="{{ old('firstdaydate') }}" autocomplete="firstdaydate">

                                @error('firstdaydate')
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
                                    {{ __('Promote') }}
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
