@extends('layouts.admin')
@section('content')

	<div class="error-pagewrap">
		<div class="error-page-int">
			<div class="text-center m-b-md custom-login">
				<img src="{{asset('admin/img/logo/logo.png')}}" class="evtlgosd">
			</div>
			<div class="content-error">
				<div class="hpanel">
                    <div class="panel-body">
                            @if (Session::has('success'))

                                <div class="alert alert-success" role="alert">
                                   <strong>Success:</strong> {{ Session::get('success') }}
                                </div>

                            @endif

                        <form method="post" action="{{ route('login') }}" id="loginForm">
                            @csrf

                            <div class="form-group">
                                <label class="control-label" for="username">Email</label>
                                <input type="text" placeholder="example@gmail.com" title="Please enter you email" required="" value="{{ old('email') }}" name="email" id="username" class="form-control @error('email') is-invalid @enderror">
                                <span class="help-block small">Your unique email to app</span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="password">Password</label>
                                <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                <span class="help-block small">Your strong password</span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="checkbox login-checkbox">
                                <label>
										<input type="checkbox" name="remember" class="i-checks" {{ old('remember') ? 'checked' : '' }}> Remember me </label>
                                <p class="help-block small">(if this is a private computer)</p>
                            </div>
                            <button class="btn btn-success btn-block loginbtn">Login</button>
                            <a class="btn btn-default btn-block" href="{{ route('register') }}">Register</a>
                        </form>
                    </div>
                </div>
			</div>
			
		</div>   
    </div>
@endsection

@section('scripts')
@endsection