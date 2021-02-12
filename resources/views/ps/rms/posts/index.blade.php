@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ request()->type }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.rms') }}">RMS Dashboard</a></li>
                    <li class="breadcrumb-item">{{ request()->type }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">  

    <div class="row">
        <div class="col-md-9">

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

            <div class="card card-primary card-outline">
                <div class="card-header">
                    All {{ request()->type }}
                    <span class="float-right">
                        <a href="{{ route('ps.rms.posts-create', request()->type) }}" class="btn btn-primary btn-sm">New {{ substr(request()->type, 0, strlen(request()->type)-1) }}</a>
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover ">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Type</th>                                  
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($posts) > 0)
                                    @foreach($posts as $post)
                                        <tr>
                                            <td>
                                                <a href="{{ route('ps.rms.posts-show', $post->id)}}">
                                                    <strong>{{ $post->title ?? '' }}</strong>
                                                </a>
                                            </td>
                                            <td>{{ $post->type ?? '' }}</td>
                                            <td>{{ date('M d, Y h:i A', strtotime($post->updated_at)) ?? '' }}</td>

                                        </tr>
                                    @endforeach
                                @else
                                    <tr><td colspan="4">No record found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.rms._tools')
        </div>
    </div>
</div>
@endsection
