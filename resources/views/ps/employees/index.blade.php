@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employees</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.employees.active') }}">
                                    {{ number_format($empl_a, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Unassigned</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.employees.unassigned') }}">
                                    {{ number_format($empl_un, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users-slash"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Terminated</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.employees.terminated') }}">
                                    {{ number_format($empl_te, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Position</th>
                                    <th width="20%">Station</th>
                                    <th width="15%">District</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($employees) > 0)
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->empno ?? __('') }}</td>
                                        <td>
                                            <a href="{{ route('ps.employees.show', $employee->empid) }}">
                                                {{ $employee->person->getFullnameSorted() ?? __('') }}
                                            </a>
                                        </td>
                                        <td>{{ $employee->item->position ?? __('') }}</td>
                                        <td>{{ $employee->item->deployment->station->name ?? __('') }}</td>
                                        <td>{{ $employee->item->deployment->station->office->name ?? __('') }}</td>
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
                        {!! $employees->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.people._tools')
        </div>
    </div>
</div>
@endsection
