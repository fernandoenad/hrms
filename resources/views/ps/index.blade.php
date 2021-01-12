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
        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">People</span>
                    <span class="info-box-number">
                        {{ number_format($people->count(), 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-user-tie"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Employees</span>
                    <span class="info-box-number">
                        {{ number_format($employees->count(), 0) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-sitemap"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Plantilla Items</span>
                    <span class="info-box-number">
                        {{ number_format($items->count(), 0) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
