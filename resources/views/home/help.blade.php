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
                @if(sizeof($posts) > 0)
                    @foreach($posts as $post)
                        <div class="card">
                            <div class="card-body">
                                <span class="badge badge-default float-right">
                                    Posted at {{ date('M d, Y', strtotime($post->created_at)) ?? '' }} | 
                                    Updated at  {{ date('M d, Y', strtotime($post->updated_at)) ?? '' }}
                                </span>

                                <h3>{{ $post->title ?? '' }}</h3>
                                <p>
                                    {{ substr(strip_tags($post->content), 0, 100) ?? '' }} 
                                    <a data-toggle="collapse" href="#more{{ $post->id }}" 
                                        role="button" aria-expanded="true" 
                                        aria-controls="collapseExample" class="text-primary">more</a> 

                                    <div id="container">
                                        <div class="collapse" id="more{{ $post->id }}">
                                            <p><?php echo $post->content ?></p>
                                        </div>
                                    </div>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="card card-danger card-outline">
                        <div class="card-body">
                            <p>No record found.</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-3">
                @include('home._tools')
            </div>
        </div>
    </div>
</div>
@endsection