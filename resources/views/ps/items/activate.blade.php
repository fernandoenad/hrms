@extends('layouts.ps')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Activate Item</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('ps') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.items') }}">Items</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ps.items.show', $item->id) }}">Item</a></li>
                    <li class="breadcrumb-item active">Activate Item</li>
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
            <div class="card card-primary">
                <div class="card-body">
                    <form method="POST" action="{{ route('ps.items.activate-done', $item->id) }}">
                        @csrf
                        @method('PATCH')

                        <h5>Confirm activation by filling out the new remarks field below.</h5>
                        <br>
                        <div class="form-group row">
                            <label for="remarks_old" class="col-md-3 col-form-label text-md-right">{{ __('Old Remarks') }}</label>

                            <div class="col-md-8">
                                <input id="remarks_old" readonly type="text" class="form-control @error('remarks_old') is-invalid @enderror" name="remarks_old" value="{{ old('remarks_old') ?? $item->remarks }}" autocomplete="remarks_old">
                                
                                @error('remarks_old')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="remarks" class="col-md-3 col-form-label text-md-right">{{ __('New Remarks') }}</label>

                            <div class="col-md-8">
                                <input id="remarks" type="text" class="form-control @error('remarks') is-invalid @enderror" name="remarks" value="{{ old('remarks') }}" autocomplete="remarks">
                                
                                @error('remarks')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary float-right">
                                        {{ __('Activate Item') }}
                                    </button>
                                    <a href="{{ route('ps.items.show', $item->id) }}" class="btn btn-default">
                                        {{ __('Cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            @include('ps.items._tools')
        </div>
    </div>
</div>
@endsection
