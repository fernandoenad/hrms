@extends('layouts.rs')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rs') }}">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Active</span>
                    <span class="info-box-number">
                        <a href="{{ route('rs') }}">
                            {{ number_format($empl_a, 0) }}
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection
