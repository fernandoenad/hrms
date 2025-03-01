@extends('layouts.app')

@section('content')    
<div class="content-header">
    <div class="container-fluid">
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row d-flex justify-content-center">			
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body login-card-body">
						<div class="row d-flex justify-content-center">
							<img src="{{ asset('img/lock.png') }}" width="80">
						</div>

						<div class="row d-flex justify-content-center">
							<p>Sign in to start your session</p>
						</div>

						<div class="row d-flex justify-content-center">
							<p></p>
							@if (session('status'))
								<div class="alert alert-success">
									{{ session('status') }}
								</div>
							@endif
							
						</div>

						<form method="POST" action="{{ route('login') }}">
							@csrf
							<!--
							<div class="input-group mb-3">
								<input 
									type="text" 
									name="email" 
									placeholder="Email"
									class="form-control @error('email') is-invalid @enderror" 
									value="{{ old('email') }}" 
									autocomplete="email"
									autofocus
								>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-user"></span>
									</div>
								</div>
								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<div class="input-group mb-3">
								<input 
									type="password" 
									name="password"
									placeholder="Password" 
									class="form-control @error('password') is-invalid @enderror" 
									value="{{ old('password') }}" 
									autocomplete="current-password"
								>
								<div class="input-group-append">
									<div class="input-group-text">
										<span class="fas fa-lock"></span>
									</div>
								</div>
								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>

							<div class="form-group row">
								<div class="col-md-6">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

										<label class="form-check-label" for="remember">
											{{ __('Remember Me') }}
										</label>
									</div>
								</div>
							</div>
							

							<div class="row d-flex justify-content-center">
								<p></p>
							</div>

							<div class="form-group row mb-0">
								<div class="col-md-12">                               
									@if (Route::has('password.request'))
										<a class="btn btn-link" href="{{ route('password.request') }}">
											{{ __('Forgot Your Password?') }}
										</a>
									@endif

									<button type="submit" class="btn btn-primary float-right">
										{{ __('Login') }}
									</button>
									<hr>
									<center>
										<a href="{{ url('/auth/google') }}" class="google-btn">
											<img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" width="10%">
											Sign in with DepEd GMail
										</a>
										<br>
										@if (session('error'))
											<div class="alert alert-danger">
												{{ session('error') }}
											</div>
										@endif
									</center>
								</div>
							</div>
							-->
							<div class="form-group row mb-0">
								<div class="col-md-12 text-center">                               
									<a href="{{ url('/auth/google') }}" class="google-btn">
										<img src="https://developers.google.com/identity/images/g-logo.png" alt="Google Logo" width="10%">
										Sign in with DepEd GMail
									</a>
									<br>
									<br>

									@if (session('not_reg'))
										<div class="alert alert-danger">
											<strong>{{ session('not_reg') }}</strong>
											<a href="./rms/register">Register?</a>
										</div>
										
									@endif
									@if (session('not_deped'))
										<div class="alert alert-danger">
											<strong>{{ session('not_deped') }}</strong>
										</div>
									@endif
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
