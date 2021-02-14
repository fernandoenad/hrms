@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ictu.support') }}">Support Mgmt</a></li>
                    <li class="breadcrumb-item active">Article</li>
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
            <div class="card">
                <div class="card-body">
                    <button class="float-right btn btn-danger btn-sm" title="Delete Post" href="{{ route('ictu.support.destroy', $post->id) }}" 
                        onclick="event.preventDefault();
                            if(confirm('This action is IRREVERSIBLE.\n Are you sure you wish to delete this post?')){
                            document.getElementById('post-delete').submit();} else {return false;}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                    <a class="float-right btn btn-warning btn-sm mr-1" title="Modify Post" href="{{ route('ictu.support.edit', $post->id) }}">
                        <i class="fas fa-edit"></i>
                    </a>
                    <a class="float-right btn btn-default btn-sm mr-1" title="Back to the Post dashboard" href="{{ route('ictu.support') }}">
                        <i class="fas fa-arrow-circle-left"></i>
                    </a>
                    <form id="post-delete" method="POST" action="{{ route('ictu.support.destroy', $post->id) }}" class="d-none">
                    @csrf
                    @method('DELETE')
                    </form>
                    
                    <h3>{{ $post->title }}</h3>                    
                    <span class="badge badge-mute p-0">
                        Posted at {{ date('M d, Y h:i A', strtotime($post->created_at )) }},
                        Updated at {{ date('M d, Y h:i A', strtotime($post->updated_at )) }}
                    </span>
                    <p></p>
                    <div id="container">
                        <?php echo  $post->content ?>
                    </div>
                </div> 
            </div>
        </div>

        <div class="col-md-3">
            @include('ictu.support._tools')
        </div>
    </div>
</div>
@endsection
