@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Applications for {{ $cycle }} Cycle</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">{{ $station->code ?? '' }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.applications', $station->id) }}">Cycles</a></li>
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
                                                <a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}">
                                                    <?php $vacancy_ = App\Models\Vacancy::find($vacancy->id); ?>
                                                    <strong>{{ $vacancy_->name ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td class="text-right">{{ $vacancy_->vacancy ?? '' }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle)
                                                    ->where('station_id', '=', $station->id)
                                                    ->where('vacancy_id', '=', $vacancy->id)->get()->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle)
                                                    ->where('station_id', '=', $station->id)
                                                    ->where('vacancy_id', '=', $vacancy->id)
                                                    ->where('status', '=', 1)->get()->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle)
                                                    ->where('station_id', '=', $station->id)
                                                    ->where('vacancy_id', '=', $vacancy->id)
                                                    ->where('status', '=', 2)->get()->count() }}</td>
                                            <td class="text-right">{{ App\Models\Application::where('schoolyear', '=', $cycle)
                                                    ->where('station_id', '=', $station->id)
                                                    ->where('vacancy_id', '=', $vacancy->id)
                                                    ->where('status', '=', 3)->get()->count() }}</td>
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
       
            @if($station->services == 'Secondary')
            <div class="card card-primary card-outline">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Positions Not Applied For</th>                                
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($vacancies2) > 0)
                                    @foreach($vacancies2 as $vacancy)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ou.station.applications.showvacancy', [$station->id, $cycle, $vacancy->id]) }}">
                                                    <?php $vacancy_ = App\Models\Vacancy::find($vacancy->id); ?>
                                                    <strong>{{ $vacancy_->name ?? '' }}</strong>
                                                </a>
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
            @endif
        </div>

        <div class="col-md-3">
            @include('ou.station.applications._tools')
        </div>
    </div>
</div>
@endsection
