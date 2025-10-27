@extends('layouts.error')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">The Site Has Moved</h1>
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
            <h2 class="headline text-danger">The Site Has Moved</h2>

            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i>We’ve Upgraded!</h3>

                <p>
                    Our platform has migrated to a new address to serve you better.<br>
                    Please update your bookmarks and visit us at:<br>
                    <br>
                    👉 <a href="https://hrmis.depedbohol.org">https://hrmis.depedbohol.org</a>.<br>
                    <br>
                    For inquiries, contact <a href="https://m.me/hrmis.bohol">https://m.me/hrmis.bohol</a>.<br>
                    <br>
                    — DepEd Bohol ICTU
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

