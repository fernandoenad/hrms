@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Reports</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="card card-info">
                <div class="card-header">
                    Reports Dashboard
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="canvas" height="280" width="400">
                        </canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.reports._tools')
        </div>
    </div>
</div>
@endsection
