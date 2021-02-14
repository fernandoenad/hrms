@extends('layouts.station')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Station {{ $station->code ?? '' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="">Home</a></li>
                    <li class="breadcrumb-item active">{{ $station->code ?? '' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            @include('station._profile')
        </div>

        <div class="col-md-3">
           <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Teaching</span>
                    <span class="info-box-number">
                        {{ number_format(
                            App\Models\Deployment::join('items', 'deployments.item_id', '=', 'items.id')
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
                            App\Models\Deployment::where('station_id', '=', $station->id)->count()
                            , 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <?php $positions = App\Models\Item::join('deployments', 'items.id', '=', 'deployments.item_id')
                    ->where('deployments.station_id', '=', $station->id)
                    ->groupBy('position')
                    ->orderBy('position'); ?>
            <div class="info-box mb-3 bg-primary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Inventory</span>
                    <span class="info-box-number">5,200</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
