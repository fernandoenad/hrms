@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employment Record</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees') }}">Employees</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.employees.show', $person->employee->id) }}">Employee</a></li>
                    <li class="breadcrumb-item active">Employment Record Removal</li>
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
                    <h5>{{ __('Confirm Employment Record Removal')}}</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('ps.employees.delete', $person->employee->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('DELETE')

                        <p>Are you sure you wish to this employee?</p>

                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary float-right">
                                    {{ __('Remove Employee Record') }}
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
