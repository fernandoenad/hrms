@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Employee</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.employees') }}">Employees</a></li>
                    <li class="breadcrumb-item active">Employee</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
        @include('ps.people._profile')
        </div>
        
        <div class="col-md-6">
            @include('rs.employees._content')
        </div>

        <div class="col-md-3">
            @include('ictu.people._tools')
        </div>
    </div>
</div>
@endsection
