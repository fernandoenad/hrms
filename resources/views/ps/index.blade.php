@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Employees</span>
                    <span class="info-box-number">
                        <a href="{{ route('ps.employees') }}">
                            {{ number_format($employees->count(), 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-sitemap"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Plantilla Items</span>
                    <span class="info-box-number">
                        <a href="{{ route('ps.items') }}">
                            {{ number_format($items->count(), 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <div class="card-header pr-3">
                    <div class="float-right">
                        <form class="form-inline" method="post" action="{{ route('ps.search') }}">
                            @csrf
                            <div class="input-group input-group-md float-right">
                                <input id="searchString" name="searchString" class="form-control form-control-navbar @error('searchString') is-invalid @enderror" value="{{ old('searchString') ?? request()->get('searchString') }}" autocomplete="searchString" type="search" placeholder="Search school" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Station Name (Code), District</th>
                                    <th>School Head</th>
                                    <th class="text-right">Plantilla Count</th>
                                    <th class="text-right">Warm Body Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($stations) > 0)
                                    @foreach($stations as $station)
                                    <tr>
                                        <td>
                                            <strong>{{ $station->name }} ({{ $station->code }})</strong>
                                            <br>
                                            {{ $station->office->name }}
                                        </td>
                                        <td>
                                            @if(isset($station->person))
                                                {{ $station->person->getFullnameBox() }}
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            {{ $plantilla = number_format($station->item->count(), 0) }}
                                        </td>
                                        <td class="text-right">
                                            {{ $warmBody =  $station->join('deployments', 'stations.id', '=', 'deployments.station_id')->join('employees', 'deployments.item_id', '=', 'employees.item_id')->where('deployments.station_id', '=', $station->id)->get()->count() }}                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                @else 
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.')}}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right">
                        {!! $stations->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
