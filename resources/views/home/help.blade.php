@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ __('Support Page')}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('help') }}">Home</a></li>
                    <li class="breadcrumb-item active">Support Page</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="card card-primary card-outline">
                    <div class="card-body">
                        <p>This is the help page, unfortunately, this is still being constructed.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('home._tools')
            </div>
        </div>
    </div>
</div>
@endsection