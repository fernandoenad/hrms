@extends('layouts.ps')

@section('content')    

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">RMS Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item">RMS Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

            <div class="row">                
                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">New Applications</span>
                            <span class="info-box-number">
                                <a href="#">
                                    {{ number_format($applications_new, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Pending Applications</span>
                            <span class="info-box-number">
                                <a href="#">
                                    {{ number_format($applications_pending, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="info-box">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-inbox"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Confirmed Applications</span>
                            <span class="info-box-number">
                                <a href="#">
                                    {{ number_format($applications_confirmed, 0) }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>

            <div class="card card-primary card-outline">
                <div class="card-header">
                    Recent Applications
                    <div class="float-right">
                        <form class="form-inline" method="post" action="{{ route('ps.rms.applications-search') }}">
                            @csrf
                            <div class="input-group input-group-sm float-right">
                                <input id="str" name="str" class="form-control form-control-navbar @error('str') is-invalid @enderror" value="{{ old('str') ?? request()->get('str') }}" autocomplete="str" type="search" placeholder="Search applicant" aria-label="Search">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <small>
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th width="25%">Name / Position Applied</th>
                                    <th>Contact / Address</th> 
                                    <th>Position / Station / District</th>                                    
                                    <th>Submitted at / Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($applications) > 0)
                                    <?php $i=1;?>
                                    @foreach($applications as $application)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td>
                                                <a href="{{ route('ps.rms.applications-show', [$application->schoolyear, $application->vacancy->id,  $application->id]) }}">
                                                    <strong>{{ $application->person->getFullnameBox() ?? '' }}</strong>
                                                </a>
                                                <br>
                                                {{ $application->vacancy->name ?? '' }} 
                                                <br>
                                                ({{ $application->schoolyear ?? '' }})
                                            </td>
                                            <td>
                                                {{ $application->person->contact->primaryno ?? '' }}<br>
                                                {{ $application->person->address->current ?? '' }}                                            
                                            </td>
                                            <td>
                                                {{ $application->person->employee->item->position ?? 'No employment record' }}<br>
                                                {{ $application->person->employee->item->deployment->station->name ?? '' }}<br>
                                                {{ $application->person->employee->item->deployment->station->office->name ?? '' }}
                                            </td>
                                            <td>
                                                <span class="badge badge-default">
                                                    {{ date('M d, Y h:i a', strtotime($application->created_at)) ?? '' }}
                                                </span>    
                                                <br>
                                                <span class="badge badge-{{ $application->getstatuscolor($application->status) ?? '' }}">
                                                    {{ $application->getStatus($application->status) ?? '' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <?php $i++;?>
                                    @endforeach
                                @else
                                    <tr><td colspan="5">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        </small>
                    </div>
                </div> 
                <div class="card-footer p-1 pb-0">
                    <span class="small float-right">{{ $applications->links() }}</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
