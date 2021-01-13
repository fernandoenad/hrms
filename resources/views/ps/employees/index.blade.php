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
            <div class="card card-outline card-primary">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0">
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
                                        <td>{{ $employee->station->name ?? __('') }}</td>
                                        <td>{{ $employee->station->office->name ?? __('') }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.') }}</td>
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
            @include('ps.employees._tools')
        </div>
    </div>
</div>
@endsection
