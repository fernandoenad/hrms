@extends('layouts.error')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Error 404</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active">404 Error Page</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-warning"> 404</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Oops! Page not found.</h3>

                <p>
                    We could not find the page you were looking for.<br>
                    Meanwhile, you may <a href="{{ url()->previous() }}">return to the previous page</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

