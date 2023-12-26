@extends('layouts.oust')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Station {{ $station->code ?? '' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.station.show', $station->id) }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $station->code ?? '' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('ou.station._profile')
        </div>

        <div class="col-md-3">
           <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Teaching</span>
                    <span class="info-box-number">
                        {{ number_format(
                            App\Models\Deployment::join('items', 'deployments.item_id', '=', 'items.id')
                                ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                ->where('employeetype', '=', 'Teaching')
                                ->where('deployments.station_id', '=', $station->id)->count()
                            , 0) }}
                    </span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Non-Teaching</span>
                    <span class="info-box-number">
                        {{ number_format(
                            App\Models\Deployment::join('items', 'deployments.item_id', '=', 'items.id')
                                ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                ->where('employeetype', '=', 'Non-Teaching')
                                ->where('deployments.station_id', '=', $station->id)->count()
                            , 0) }}
                    </span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total</span>
                    <span class="info-box-number">
                        {{ number_format(
                            App\Models\Deployment::join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                ->where('station_id', '=', $station->id)->count()
                            , 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    Breakdown by Position
                </div>
                <div class="card-body p-0">
                    <ul class="nav nav-pills flex-column">
                        <?php $positions = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                ->where('deployments.station_id', '=', $station->id)
                                ->select('position')
                                ->groupBy('position')
                                ->orderByRaw('CONVERT(salarygrade, SIGNED) desc')
                                ->orderBy('position')->get(); ?>

                        @if(sizeof($positions) > 0)
                            @foreach($positions as $position)
                    
                                <li class="nav-item">
                                    <a href="{{ route('ou.station.employees.filter', [$station->id, $position->position]) }}" class="nav-link">
                                        <i class="fas fa-user-tag"></i> {{ $position->position ?? '' }}
                                        <?php $position_count = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                                            ->join('employees', 'deployments.item_id', '=', 'employees.item_id')
                                            ->where('deployments.station_id', '=', $station->id)
                                            ->where('position', '=', $position->position)
                                            ->count(); ?>

                                        <span class="badge badge-primary float-right">{{ $position_count }}</span>
                                    </a>
                                </li>
                            
                            @endforeach
                        @else
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fas fa-fa-user-tag"></i> No record found.
                                </a>
                            </li>
                        @endif
                    </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
