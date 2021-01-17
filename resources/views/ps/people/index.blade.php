@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">People</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">People</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">People</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.people') }}">
                                    {{ number_format($people_c, 0)}}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Employees</span>
                            <span class="info-box-number">
                                <a href="{{ route('ps.employees') }}">
                                    {{ number_format($employee_c, 0)}}
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
                                    <th>Sex</th>
                                    <th>Primary Contact #</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($people) > 0)
                                    @foreach($people as $person)
                                    <tr>
                                        <td>{{ $person->id  ?? __('') }}</td>
                                        <td>
                                            <a href="{{ route('ps.people.show', $person->id) }}">
                                                {{ $person->getFullnameSorted()  ?? __('') }}
                                            </a>
                                        </td>
                                        <td>{{ $person->sex  ?? __('') }}</td>
                                        <td>{{ $person->contact->primaryno  ?? __('') }}</td>
                                        <td>@if(isset($person->employee->id)) {{ 'Employee' }} @else {{ 'Applicant / Unassigned' }} @endif</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">{{ __('No record was found.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $people->render() !!}
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
