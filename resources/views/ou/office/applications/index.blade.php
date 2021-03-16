@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications by Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item active">Applications by Cycle</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Cycle</th>
                                    <th class="text-right">Positions</th> 
                                    <th class="text-right">Applications</th>
                                    <th class="text-right">New</th>
                                    <th class="text-right">Pending</th>
                                    <th class="text-right">Confirmed</th>                                     
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($cycles) > 0)
                                    @foreach($cycles as $cycle)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ou.office.applications.showcycle', [$office->id, $cycle->schoolyear]) }}">
                                                    <strong>{{ $cycle->schoolyear ?? '' }} Cycle</strong>
                                                </a>
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->groupBy('vacancy_id')
                                                    ->select('vacancy_id')->get()->count()}}
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->select('vacancy_id')->get()->count()}}
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('status', '=', 1)
                                                    ->select('vacancy_id')->get()->count() }}
                                                </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('status', '=', 2)
                                                    ->get()->count() }}
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('status', '=', 3)
                                                    ->get()->count() }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="6"></td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ou.office.applications._tools')
        </div>
    </div>
</div>
@endsection
