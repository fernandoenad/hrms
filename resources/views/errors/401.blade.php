@extends('layouts.error')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Security Error</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('my') }}">Home</a></li>
                    <li class="breadcrumb-item active">401 Security Error</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="error-page">
            <h2 class="headline text-danger"> 401</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Access denied!</h3>

                <p>
                    You are not authorized to access this feature.<br>
                    Meanwhile, you may <a href="{{ url()->previous() }}">return to the previous page</a>.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

