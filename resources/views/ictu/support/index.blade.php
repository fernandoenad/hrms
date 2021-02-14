@extends('layouts.ictu')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Support Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ictu') }}">Home</a></li>
                    <li class="breadcrumb-item active">Support Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-life-ring"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Support Articles</span>
                            <span class="info-box-number">
                                {{ number_format($posts->count(), 0)}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

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

            <div class="card card-outline card-primary">
                <div class="card-header">
                    Support Article List
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 table-hover">
                            <thead>
                                <tr>
                                    <th>Help ID</th>
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Created at</th>
                                    <th>Updated at</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(sizeof($posts) > 0)
                                    @foreach($posts as $post)
                                    <tr>
                                        <td>{{ $post->id ?? '' }}</td>
                                        <td>
                                            <a href="{{ route('ictu.support.show', $post->id) }}">
                                                <strong>{{ $post->title ?? '' }}</strong>
                                            </a>
                                        </td>
                                        <td><?php echo substr(strip_tags($post->content), 0, 50) . '...'; ?></td>
                                        <td>{{ date('M d, Y h:ia', strtotime($post->created_at)) ?? '' }}</td>
                                        <td>{{ date('M d, Y h:ia', strtotime($post->updated_at)) ?? '' }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">{{ __('No record was found.') }}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer clearfix">
                    <div class="float-right small">
                        {{ $posts->links() }}
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
