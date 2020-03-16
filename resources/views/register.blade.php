@extends('layouts.admin')
@section('content')

	<div class="error-pagewrap">
		<div class="error-page-int" style="max-width: 700px;">
			<div class="text-center custom-login">
				<img src="{{asset('admin/img/logo/logo.png')}}" class="evtlgosd">
			</div>
			<div class="content-error">
				<div class="hpanel">
                    <div class="panel-body">
                        <form action="{{ route('register') }}" method="post" id="loginForm">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label>Username</label>
                                    <input class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Password</label>
                                    <input type="password" placeholder="******" class="form-control @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Repeat Password</label>
                                    <input type="password" placeholder="******" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password">
                                    @error('confirm_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Email Address</label>
                                    <input class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-lg-6">
                                    <label>Repeat Email Address</label>
                                    <input class="form-control  @error('confirm_email') is-invalid @enderror" name="confirm_email" value="{{ old('confirm_email') }}">
                                    @error('confirm_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="checkbox col-lg-12">
                                    <!--<input type="checkbox" class="i-checks" checked> Sigh up for our newsletter-->
                                    <span><a href="{{ route('login') }}" style="background:none;color:#f00;">Already have an account? Sign in</a></span>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success loginbtn">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
			</div>
			
		</div>   
    </div>
@endsection

@section('scripts')
@endsection