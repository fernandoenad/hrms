@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications for {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">{{ $office->name ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.applications', $office->id) }}">Cycles</a></li>
                    <li class="breadcrumb-item active">{{ $cycle }} Applications</li>
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
                                    <th>Positions</th>
                                    <th class="text-right">Vacancies</th> 
                                    <th class="text-right">Applications</th>
                                    <th class="text-right">New</th>
                                    <th class="text-right">Pending</th>
                                    <th class="text-right">Confirmed</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($vacancies) > 0)
                                    @foreach($vacancies as $vacancy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ou.office.applications.showvacancy', [$office->id, $cycle, $vacancy->id]) }}">
                                                    <?php $vacancy_ = App\Models\Vacancy::find($vacancy->id); ?>
                                                    <strong>{{ $vacancy_->name ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td class="text-right">{{ $vacancy_->vacancy ?? '' }}</td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('vacancy_id', '=', $vacancy->id)->get()->count() }}
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('status', '=', 1)
                                                    ->where('vacancy_id', '=', $vacancy->id)->get()->count() }}
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('status', '=', 2)
                                                    ->where('vacancy_id', '=', $vacancy->id)->get()->count() }}
                                            </td>
                                            <td class="text-right">
                                                {{ App\Models\Application::join('stations', 'applications.station_id', '=', 'stations.id')
                                                    ->join('offices', 'stations.office_id', '=', 'offices.id')
                                                    ->where('office_id', '=', $office->id)
                                                    ->where('status', '=', 3)
                                                    ->where('vacancy_id', '=', $vacancy->id)->get()->count() }}
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
