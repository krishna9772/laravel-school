@extends('auth.layouts')

@section('title', 'Registration Page')

@section('body_class', 'hold-transition register-page')

@section('content')

<div class="register-box">
    <div class="register-logo">
        {{-- <a href="../../index2.html"><b>Admin</b>LTE</a> --}}
        School Management System
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            {{-- <p class="login-box-msg">Register a new membership</p> --}}


            <form action="{{route('register')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="" class="form-label required">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Full name">
                    @error('name')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label required">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                    @error('email')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label required">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    @error('password')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="" class="form-label required">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Retype password">
                    @error('confirm_password')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="row">
                    {{-- <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                            <label for="agreeTerms">
                                 I agree to the <a href="#">terms</a>
                            </label>
                        </div>
                    </div> --}}
                    <!-- /.col -->
                     <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Register</button>
                    </div>
                    <!-- /.col -->
                 </div>
            </form>

            <p class="mt-2">
            <a href="{{route('loginPage')}}" class="text-center">Already Have An Account? Login</a>
            </p>

            {{-- <div class="social-auth-links text-center">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign up using Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="fab fa-google-plus mr-2"></i> Sign up using Google+
                </a>
            </div>

            <a href="login.html" class="text-center">I already have a membership</a> --}}
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.card -->
</div>

@endsection
