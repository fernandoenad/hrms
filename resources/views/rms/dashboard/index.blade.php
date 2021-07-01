@extends('layouts.my')  

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">RMS- {{ ($page == 'faqs' ? 'FAQs' : ucwords($page)) }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('rms') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ ($page == 'faqs' ? 'FAQs' : ucwords($page)) }}</li>
                </ol>
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
                @include('rms.dashboard._contents')
            </div>

            <div class="col-md-3">
                @include('rms.dashboard._tools')
            </div>
        </div>
    </div>
</div>
@endsection