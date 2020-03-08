@extends('layouts.registration')
@section("title","ورود")
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{asset('images/bourse-explications-696x392.jpg')}}" alt="">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">


                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="آدرس ایمیل" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="پسورد" name="password" required>
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
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    مرا به خاطر بسپار
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">ورود</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->

                {{--                <p class="mb-1">--}}
                {{--                    <a href="forgot-password.html">I forgot my password</a>--}}
                {{--                </p>--}}
                {{--                <p class="mb-0">--}}
                {{--                    <a href="register.html" class="text-center">Register a new membership</a>--}}
                {{--                </p>--}}
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
@endsection
