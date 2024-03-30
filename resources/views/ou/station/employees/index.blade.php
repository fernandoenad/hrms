@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employees</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }} </a></li>
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
                <div class="card-header">
                    Employee List
                    <div class="card-tools">
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-filter"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right pl-3 pr-3" role="menu">
                                <strong>Field filters</strong><br>
                                <input type="checkbox" name="item_no"> Item No<br>
                                <input type="checkbox" name="position" checked="checked"> Position<br>
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
                        <small>
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="15%">Empl No.</th>
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
                                    <th></th>                               
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($employees) > 0)
                                    <?php $i=1;?>
                                    @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $employee->empno ?? __('') }}</td>
                                        <td class="name">
                                            <a href="{{ route('ou.station.employees.show', [$station->id, $employee->empid]) }}">
                                                <strong>@if(isset($employee->person)) {{ $employee->person->getFullnameSorted() ?? '' }} @endif</strong>
                                            </a>                                                                                         
                                        </td>
                                        <td class="item_no"><small>{{ $employee->item->itemno ?? __('') }}</td>
                                        <td class="position">{{ $employee->item->position ?? __('') }}</td>
                                        <td class="station">{{ $employee->item->station->name ?? __('') }}</td>
                                        <td class="district">{{ $employee->item->station->office->name ?? __('') }}</td>
                                        <td class="appt_date">{{ date('M d, Y', strtotime($employee->hiredate)) ?? __('') }}</td>
                                        <td class="last_promo">{{ date('M d, Y', strtotime($employee->lastapptdate)) ?? __('') }}</td>
                                        <td class="sex">{{ $person->sex ?? __('') }}</td>
                                        <td class="dob">{{ $person->dob ?? __('') }}</td>
                                        <td class="civil_stat">{{ $employee->civilstatus ?? __('') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                <a href="{{ route('ou.station.employees.show', [$station->id, $employee->empid]) }}" class="dropdown-item">View</a>
                                                <a href="{{ route('ou.station.employees.edit', [$station->id, $employee->empid]) }}" class="dropdown-item">Modify</a>
                                                <a class="dropdown-divider"></a>
                                                <a href="{{ route('ou.station.employees.move', [$station->id, $employee->empid]) }}" class="dropdown-item">Move / Transfer</a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            {{ __('No record was found.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div>
                <div class="card-footer p-2">
                    <span class="float-right">{{ $employees->links() }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.station.employees._tools')
        </div>
    </div>
</div>
@endsection
