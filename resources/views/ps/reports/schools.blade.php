@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ ($fiscalcategory == '%' ? 'All Schools' : $fiscalcategory . ' Schools') }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.reports') }}">Reports</a></li>
                    <li class="breadcrumb-item active">{{ ($fiscalcategory == '%' ? 'All Schools' : $fiscalcategory . ' Schools') }}</li>
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
                                    <th>Station</th>
                                    <th>Head of Station</th>
                                    <th class="text-right">Filled Position</th>     
                                    <th class="text-right">Plantilla Position</th>                                 
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($stations) > 0)
                                    @foreach($stations as $station)
                                        <tr>
                                            <td>{{ $station->name }}</td>
                                            <td>{{ (isset($station->person) ? $station->person->getFullnameBox() : '') }}</td>
                                            <td class="text-right">
                                                {{ \App\Http\Controllers\PS\ReportController::getEmployeesStation($station->id, 'deployment')->count() }}                                            
                                            </td>
                                            <td class="text-right">{{ $station->item->count() }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4">No record found.</td></tr>
                                @endif                               
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer pt-2 pb-0">
                    <span class="float-right">{{ $stations->links() }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.reports._tools')
        </div>
    </div>
</div>
@endsection
