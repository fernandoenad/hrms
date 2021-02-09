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
                <div class="card-header">
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-filter"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right pl-3 pr-3" role="menu">
                                <strong>Field filters</strong><br>
                                <input type="checkbox" name="item_no" checked="checked"> Item No<br>
                                <input type="checkbox" name="position"> Position<br>
                                <input type="checkbox" name="station"> Station<br>
                                <input type="checkbox" name="district"> District<br>
                                <input type="checkbox" name="appt_date" checked="checked"> Appt Date<br>
                                <input type="checkbox" name="last_promo" checked="checked"> Last Promo Date<br>
                                <input type="checkbox" name="sex"> Sex<br>
                                <input type="checkbox" name="dob"> DOB<br>
                                <input type="checkbox" name="civil_stat"> Civil Stat<br>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Empl No.</th>
                                    <th>Name</th>
                                    <th class="item_no">Item No.</th>                                    
                                    <th class="position">Position</th>
                                    <th class="station" width="20%">Station</th>
                                    <th class="district" width="15%">District</th>
                                    <th class="appt_date">Appt Date</th>
                                    <th class="last_promo">Last Promo Date</th>
                                    <th class="sex">Sex</th>
                                    <th class="dob">DOB</th>
                                    <th class="civil_stat">Civil Stat</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($employees) > 0)
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->empno ?? __('') }}</td>
                                        <td class="name">
                                            <a href="{{ route('ps.employees.show', $employee->empid) }}">
                                                {{ $employee->person->getFullnameSorted() ?? __('') }}
                                            </a>
                                        </td>
                                        <td class="item_no">{{ $employee->item->itemno ?? __('') }}</td>
                                        <td class="position">{{ $employee->item->position ?? __('') }}</td>
                                        <td class="station">{{ $employee->item->deployment->station->name ?? __('') }}</td>
                                        <td class="district">{{ $employee->item->deployment->station->office->name ?? __('') }}</td>
                                        <td class="appt_date">{{ $employee->hiredate ?? __('') }}</td>
                                        <td class="last_promo">{{ $employee->lastapptdate ?? __('') }}</td>
                                        <td class="sex">{{ $employee->person->sex ?? __('') }}</td>
                                        <td class="dob">{{ $employee->person->dob ?? __('') }}</td>
                                        <td class="civil_stat">{{ $employee->person->civilstatus ?? __('') }}</td>
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
