@extends('layouts.app')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-md-9">
                <h1>SDO Bohol HRMS-RMS</h1>
                @include('rms.dashboard._contents')
            </div>

            <div class="col-md-3">
                @include('rms.dashboard._tools')
            </div>
        </div>
    </div>
</div>
@endsection