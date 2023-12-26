@extends('layouts.ouof')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $office->name ?? '' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ou.office.show', $office->id) }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ $office->name ?? '' }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            @include('ou.office._profile')
        </div>

        <div class="col-md-3">
           <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Teaching</span>
                    <span class="info-box-number">

                    </span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Non-Teaching</span>
                    <span class="info-box-number">

                    </span>
                </div>
            </div>
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-tags"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total</span>
                    <span class="info-box-number">

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
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-fa-user-tag"></i> No record found.
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
