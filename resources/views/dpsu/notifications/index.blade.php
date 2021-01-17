@extends('layouts.dpsu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">NOSI Notifications</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dpsu') }}">Home</a></li>
                    <li class="breadcrumb-item active">NOSI Notifications</li>
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
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-bell"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Qualifiers</span>
                            <span class="info-box-number">
                                <a href="{{ route('dpsu.employees.active') }}">
                                    {{ number_format($qual_count, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-database"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Processing</span>
                            <span class="info-box-number">
                                <a href="{{ route('dpsu.employees.active') }}">
                                    {{ number_format(0, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Completed</span>
                            <span class="info-box-number">
                                <a href="{{ route('dpsu.employees.inactive') }}">
                                    {{ number_format(0, 0) }}
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
                                @if(sizeof($qual_list) > 0)
                                    @foreach($qual_list as $employee)
                                        <tr>
                                            <td>{{ $employee->empno}}</td>
                                            <td>{{ $employee->person->getFullnameSorted() }}</td>
                                            <td>{{ $employee->item->position }}</td>
                                            <td>{{ $employee->item->deployment->station->name }}</td>
                                            <td>{{ $employee->item->deployment->station->office->name }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $qual_list->render() !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('dpsu.notifications._tools')
        </div>
    </div>
</div>
@endsection
