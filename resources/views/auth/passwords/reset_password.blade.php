@extends('layouts.app')

@section('content')
<div class="content-header">
    <div class="container-fluid">
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <?php $user = App\Models\User::find(request()->session()->get('password_expired_id')); ?>
                    <div class="card-header">{{ __('Expired Password') }} for: <strong>{{ $user->name }}</strong></div>

                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger alert-square">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success alert-square">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('message'))
                            <div class="alert alert-info alert-square">
                                {{ session('message') }}
                            </div>
                        @endif
                      
                        <form method="POST" action="{{ route('auth.reset-password') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>

                                <div class="col-md-7">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>

                                <div class="col-md-7">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
