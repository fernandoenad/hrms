@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $station->code }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports') }}">Reports</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports.plantilla') }}">Plantilla</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports.plantilla.office', $office->id) }}">{{ $office->name }}</a></li>
                    <li class="breadcrumb-item active">{{ $station->code }}</li>
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
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Empl Name</th>
                                    <th>Position</th>
                                    <th>Hire Date</th>                                    
                                    <th class="text-right">Years in Service</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($employees) > 0)
                                    @foreach($employees as $employee)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.people.show', $employee->person->id ) }}">
                                                    <strong>{{ $employee->person->getFullNameSorted() }}</strong>
                                                </a>
                                                <br>
                                                <a href="{{ route('ps.items.show', $employee->item_id ) }}" class="text-muted">
                                                    {{ $employee->item->itemno }}
                                                </i>
                                            </td>
                                            <td>{{ $employee->item->position }}</td>
                                            <td>{{ $employee->hiredate }}</td>                                            
                                            <td class="text-right">
                                                {{ $employee->getYearsInService() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th>Total</th>
                                        <th>{{ $employees->count() }}</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                @else 
                                    <tr>
                                        <td colspan="4">No record was found.</td>
                                    </tr>
                                @endif


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.reports._tools')
        </div>
    </div>
</div>
@endsection
